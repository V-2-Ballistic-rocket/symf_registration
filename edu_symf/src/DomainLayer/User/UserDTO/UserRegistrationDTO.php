<?php

namespace App\DomainLayer\User\UserDTO;

readonly class UserRegistrationDTO
{
    public function __construct(
        public string $login = '',
        public string $password = '',
        public string $email = "",
        public ?string $phoneNumber = "",
        public string $firstName = "",
        public string $lastName = "",
        public int $age = 0,
        public string $toAvatarPath = '',
        public string $country = '',
        public string $city = '',
        public string $street = '',
        public string $houseNumber = ''
    )
    {}
}