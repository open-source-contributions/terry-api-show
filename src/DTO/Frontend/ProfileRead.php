<?php

declare(strict_types=1);

namespace App\DTO\Frontend;

use TerryApiBundle\Annotation\HTTPApi;

/**
 * @HTTPApi
 */
class ProfileRead
{
    private string $email;

    private array $roles;

    private ?string $key;

    public function __construct(
        string $email,
        array $roles,
        ?string $key = null
    ) {
        $this->email = $email;
        $this->roles = $roles;
        $this->key = $key;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }
}
