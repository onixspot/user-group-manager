<?php

namespace App\Api;

use App\Model\Group;
use App\Retrofit\Attribute\Get;
use App\Retrofit\Attribute\ReturnType;
use Doctrine\Common\Collections\Collection;

interface GroupApi
{
    #[Get('groups'), ReturnType(entryType: Group::class)]
    public function getGroups(): Collection;

    public function getGroup(int $id): ?Group;

    public function createGroup(string $name): ?Group;

    public function updateGroup();

    public function deleteGroup();
}