<?php

namespace App\Retrofit\Factory;

use App\Retrofit\Attribute\Body;
use App\Retrofit\Attribute\Get;
use App\Retrofit\Attribute\Post;
use App\Retrofit\Attribute\RequestTag;
use App\Retrofit\Attribute\ResponseTag;
use App\Retrofit\Attribute\ReturnType;
use App\Retrofit\Http\Request;
use App\Retrofit\Http\Response;
use App\Retrofit\Service\ApiClient;
use Doctrine\Common\Collections\Collection;
use ReflectionAttribute;
use ReflectionMethod;

class ApiClientFactory
{
    private ApiClient $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function create(string $interface): object
    {
        return new class($interface, $this->apiClient) {

            public function __construct(
                private readonly string $interface, private ApiClient $apiClient
            ) {
            }

            public function __call(string $methodName, array $args)
            {
                $method = new ReflectionMethod($this->interface, $methodName);
                $request = $this->makeRequest($method, $args);
                $response = $this->prepareResponse($method);
                $options = ['vars' => $request->getUriVariables()];

                if ($request->getMethod() !== Request::METHOD_GET) {
                    $options['json'] = $request->getBody();
                }

                return $this->apiClient->request(
                    $request->getMethod(),
                    $request->getPath(),
                    $options,
                    $response->getReturnType()
                );
            }

            private function makeRequest(ReflectionMethod $reflectionMethod, array $args): Request
            {
                $request = new Request();
                $attributes = $this->resolveAttributes($reflectionMethod, RequestTag::class);
                $uriVariables = [];

                foreach ($reflectionMethod->getParameters() as $index => $reflectionParameter) {
                    $resolvedAttributes = $this->resolveAttributes(
                        $reflectionParameter,
                        RequestTag::class,
                        $args[$index]
                    );

                    if (empty($resolvedAttributes)) {
                        $uriVariables[$reflectionParameter->getName()] = $args[$index];
                    } else {
                        $attributes = [
                            ...$attributes,
                            ...$resolvedAttributes,
                        ];
                    }
                }
                $request->setUriVariables($uriVariables);

                foreach ($attributes as [$attribute, $data]) {
                    match (true) {
                        $attribute instanceof Get => $request
                            ->setMethod(Request::METHOD_GET)
                            ->setPath($attribute->url),

                        $attribute instanceof Post => $request
                            ->setMethod(Request::METHOD_POST)
                            ->setPath($attribute->url),

                        $attribute instanceof Body => $request->setBody($data)
                    };
                }

                return $request;
            }

            private function resolveAttributes($reflector, string $tag, mixed $context = null): array
            {
                return array_map(
                    static fn(ReflectionAttribute $reflectionAttribute) => [
                        $reflectionAttribute->newInstance(),
                        $context,
                    ],
                    $reflector->getAttributes($tag, ReflectionAttribute::IS_INSTANCEOF)
                );
            }

            private function prepareResponse(ReflectionMethod $reflectionMethod): Response
            {
                $response = new Response();

                $returnType = $reflectionMethod->getReturnType()?->getName();
                if (!in_array($returnType, [null, Collection::class], true)) {
                    $response->setReturnType($returnType);
                }

                $attributes = $this->resolveAttributes($reflectionMethod, ResponseTag::class);
                foreach ($attributes as [$attribute]) {
                    match (true) {
                        $attribute instanceof ReturnType => $response->setReturnType(
                            $returnType === Collection::class
                                ? sprintf('%s[]', $attribute->entryType)
                                : $attribute->type,
                        )
                    };
                }

                return $response;
            }
        };
    }
}
