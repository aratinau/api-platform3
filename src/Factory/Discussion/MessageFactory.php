<?php

namespace App\Factory\Discussion;

use App\Entity\Discussion\Message;
use App\Factory\UserFactory;
use App\Repository\MessageRepository;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Message>
 *
 * @method        Message|Proxy                              create(array|callable $attributes = [])
 * @method static Message|Proxy                              createOne(array $attributes = [])
 * @method static Message|Proxy                              find(object|array|mixed $criteria)
 * @method static Message|Proxy                              findOrCreate(array $attributes)
 * @method static Message|Proxy                              first(string $sortedField = 'id')
 * @method static Message|Proxy                              last(string $sortedField = 'id')
 * @method static Message|Proxy                              random(array $attributes = [])
 * @method static Message|Proxy                              randomOrCreate(array $attributes = [])
 * @method static MessageRepository|ProxyRepositoryDecorator repository()
 * @method static Message[]|Proxy[]                          all()
 * @method static Message[]|Proxy[]                          createMany(int $number, array|callable $attributes = [])
 * @method static Message[]|Proxy[]                          createSequence(iterable|callable $sequence)
 * @method static Message[]|Proxy[]                          findBy(array $attributes)
 * @method static Message[]|Proxy[]                          randomRange(int $min, int $max, array $attributes = [])
 * @method static Message[]|Proxy[]                          randomSet(int $number, array $attributes = [])
 */
final class MessageFactory extends PersistentProxyObjectFactory
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
        return Message::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'content' => self::faker()->text(),
            'discussion' => DiscussionFactory::new(),
            'author' => UserFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Message $message): void {})
        ;
    }
}
