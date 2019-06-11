<?php
declare(strict_types=1);

namespace App\Factories;

use App\Entity\User;
use App\Factories\Interfaces\UserFactoryInterface;

final class UserFactory implements UserFactoryInterface
{
    /**
     * Create user for given data.
     *
     * @param mixed[] $data
     *
     * @return \App\Entity\User
     */
    public function create(array $data): User
    {
        return (new User)
            ->setEmail($data['email'])
            ->setFamilyName($data['family_name'])
            ->setGivenName($data['given_name'])
            ->setGoogleId($data['google_id'])
            ->setLocale($data['locale']);
    }
}
