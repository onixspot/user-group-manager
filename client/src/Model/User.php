<?php

namespace App\Model;

class User
{
    public function __construct(
        private ?int $id = null,
        private ?string $name = null,
        private ?string $email = null,
        private ?array $groups = null,
    ) {
    }

    public function getGroups(): ?array
    {
        return $this->groups;
    }

    public function setGroups(?array $groups): User
    {
        // $this->groups = array_map(static fn(string $g) => new Group($g), $groups);
        $this->groups = $groups;

        return $this;
    }

    public function setId(int $id): User
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name): User
    {
        $this->name = $name;

        return $this;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

}