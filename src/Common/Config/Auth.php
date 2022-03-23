<?php

namespace PlisioPhpSdk\Common\Config;

use Webmozart\Assert\Assert;

class Auth
{
    private string $user;
    private string $password;

    public function __construct(string $user, string $password)
    {
        Assert::notEmpty($user);
        Assert::notEmpty($password);

        $this->user = $user;
        $this->password = $password;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
