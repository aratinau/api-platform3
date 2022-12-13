<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UserRegisterInput
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public $email;

    #[Assert\NotBlank]
    #[Assert\Length(min:4, max:32)]
    #[Assert\Regex("/^.*(?=.{8,})((?=.*[!@#$%^&*()\-_=+{};:,<.>]){1})(?=.*\d)((?=.*[a-z]){1})((?=.*[A-Z]){1}).*$/")]
    public $password;
}
