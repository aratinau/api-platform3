<?php

namespace App\Factory;

use App\Entity\Mail;
use App\Repository\MailRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Mail>
 *
 * @method        Mail|Proxy                              create(array|callable $attributes = [])
 * @method static Mail|Proxy                              createOne(array $attributes = [])
 * @method static Mail|Proxy                              find(object|array|mixed $criteria)
 * @method static Mail|Proxy                              findOrCreate(array $attributes)
 * @method static Mail|Proxy                              first(string $sortedField = 'id')
 * @method static Mail|Proxy                              last(string $sortedField = 'id')
 * @method static Mail|Proxy                              random(array $attributes = [])
 * @method static Mail|Proxy                              randomOrCreate(array $attributes = [])
 * @method static MailRepository|ProxyRepositoryDecorator repository()
 * @method static Mail[]|Proxy[]                          all()
 * @method static Mail[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Mail[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Mail[]|Proxy[]                          findBy(array $attributes)
 * @method static Mail[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Mail[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 */
final class MailFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Mail::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'author' => UserFactory::new(),
            'subject' => self::faker()->text(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Mail $mail): void {})
        ;
    }
}
