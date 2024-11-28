<?php

namespace App\Retrofit\Service;

use Doctrine\Common\Collections\ArrayCollection;
use RuntimeException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

class ApiClient
{
    private HttpClientInterface $client;
    private SerializerInterface $serializer;

    public function __construct(HttpClientInterface $client, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    public function request(string $method, string $urlTemplate, array $options = [], ?string $responseClass = null): mixed
    {
        try {
            $response = $this->client->request($method, $urlTemplate, $options);

            $content = $response->getContent();

            if ($responseClass) {
                if (str_ends_with($responseClass, '[]')) {
                    $singleClass = substr($responseClass, 0, -2); // Видаляємо `[]`
                    $objects = $this->serializer->deserialize($content, $singleClass.'[]', 'json');

                    return new ArrayCollection($objects); // Повертаємо ArrayCollection
                }

                return $this->serializer->deserialize($content, $responseClass, 'json');
            }

            return json_decode($content, true, 512, JSON_THROW_ON_ERROR); // Повертаємо масив за замовчуванням
        } catch (Throwable $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
