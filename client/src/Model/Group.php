<?php

namespace App\Model;

class Group
{
    public function __construct(
        private string|int|null $id = null,
        private ?string $name = null,
        private ?array $users = null,
    ) {
    }

    public function getUsers(): ?array
    {
        return $this->users;
    }

    public function setUsers(?array $users): Group
    {
        $this->users = $users;

        return $this;
    }

    public function getId(): int|string|null
    {
        return $this->id;
    }

    public function setId(int|string|null $id): Group
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Group
    {
        $this->name = $name;

        return $this;
    }
}