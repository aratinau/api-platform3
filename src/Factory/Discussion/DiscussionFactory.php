<?php

namespace App\Factory\Discussion;

use App\Entity\Discussion\Discussion;
use App\Factory\UserFactory;
use App\Repository\DiscussionRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Discussion>
 *
 * @method        Discussion|Proxy                              create(array|callable $attributes = [])
 * @method static Discussion|Proxy                              createOne(array $attributes = [])
 * @method static Discussion|Proxy                              find(object|array|mixed $criteria)
 * @method static Discussion|Proxy                              findOrCreate(array $attributes)
 * @method static Discussion|Proxy                              first(string $sortedField = 'id')
 * @method static Discussion|Proxy                              last(string $sortedField = 'id')
 * @method static Discussion|Proxy                              random(array $attributes = [])
 * @method static Discussion|Proxy                              randomOrCreate(array $attributes = [])
 * @method static DiscussionRepository|ProxyRepositoryDecorator repository()
 * @method static Discussion[]|Proxy[]                          all()
 * @method static Discussion[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Discussion[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Discussion[]|Proxy[]                          findBy(array $attributes)
 * @method static Discussion[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Discussion[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 */
final class DiscussionFactory extends PersistentProxyObjectFactory
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
        return Discussion::class;
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
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Discussion $discussion): void {})
        ;
    }
}
