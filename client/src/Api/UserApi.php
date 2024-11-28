<?php

namespace App\Api;

use App\Model\User;
use App\Retrofit\Attribute\Body;
use App\Retrofit\Attribute\Get;
use App\Retrofit\Attribute\Post;
use App\Retrofit\Attribute\ReturnType;
use Doctrine\Common\Collections\Collection;

interface UserApi
{
    #[Get('users'), ReturnType(entryType: User::class)]
    public function getUsers(): Collection;

    #[Get('users/{id}')]
    public function getUser(int $id): ?User;

    #[Post('users')]
    public function createUser(#[Body] array $user): User;

//    #[HttpRequest(method: Request::METHOD_PATCH, path: '{user.id}', body: 'user')]
//    public function updateUser(User $user);

//    #[HttpRequest(method: Request::METHOD_DELETE, path: '{user[id]}')]
//    public function deleteUser(User $user);

}
