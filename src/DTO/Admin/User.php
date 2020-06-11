<?php

declare(strict_types=1);

namespace App\DTO\Admin;

use TerryApiBundle\Annotation\HTTPApi;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @HTTPApi
 */
class User
{
    /**
     * @Assert\Type("string")
     */
    public $email;

    /**
     * @Assert\Type("string")
     */
    public $key;

    /**
     * @Assert\Type("boolean")
     */
    public $isResetPassword;

    /**
     * @Assert\Type("boolean")
     */
    public $isResetKey;

    /**
     * @Assert\Type("array")
     */
    public $roles;

    public function __construct(string $email, array $roles, ?string $key = null)
    {
        $this->email = $email;
        $this->roles = $roles;
        $this->key = $key;
    }
}
