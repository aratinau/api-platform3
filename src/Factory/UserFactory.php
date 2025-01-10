<?php

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<User>
 */
final class UserFactory extends PersistentProxyObjectFactory
{
    // password hashed for 1234
    private const PASSWORD_HASHED = '$2y$13$2E/s8EKeHLZXpZsA75KYvuyoF9cfCtWDa/C5c9XDVLHr1UwI.kuDq';

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public static function class(): string
    {
        return User::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array|callable
    {
        return [
            'email' => self::faker()->unique()->safeEmail(),
            'password' => self::PASSWORD_HASHED,
            'roles' => [],
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        // if you want an encoded password for each user
        return $this
//            ->beforeInstantiate(function(User $user): void {
//                $user->setPassword($this->passwordHasher->hashPassword(
//                    $user,
//                    $user->getPassword()
//                ));
//            })
            ;
    }
}
