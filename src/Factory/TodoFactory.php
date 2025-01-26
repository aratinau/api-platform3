<?php

namespace App\Factory;

use App\Entity\Todo;
use App\Repository\TodoRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Todo>
 *
 * @method        Todo|Proxy                              create(array|callable $attributes = [])
 * @method static Todo|Proxy                              createOne(array $attributes = [])
 * @method static Todo|Proxy                              find(object|array|mixed $criteria)
 * @method static Todo|Proxy                              findOrCreate(array $attributes)
 * @method static Todo|Proxy                              first(string $sortedField = 'id')
 * @method static Todo|Proxy                              last(string $sortedField = 'id')
 * @method static Todo|Proxy                              random(array $attributes = [])
 * @method static Todo|Proxy                              randomOrCreate(array $attributes = [])
 * @method static TodoRepository|ProxyRepositoryDecorator repository()
 * @method static Todo[]|Proxy[]                          all()
 * @method static Todo[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Todo[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Todo[]|Proxy[]                          findBy(array $attributes)
 * @method static Todo[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Todo[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 */
final class TodoFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Todo::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array|callable
    {
        return [
            'description' => self::faker()->text(),
            'title' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Todo $todo): void {})
        ;
    }
}
