<?php

namespace App\Attribute;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::TARGET_PROPERTY | \Attribute::TARGET_CLASS)]
class WatchProperty
{
    public function __construct(
        public array $events = [],
        public bool $compareWithOldValue = false,
        public ?string $compareWithOtherAttribute = null,
        public ?string $triggerEventName = null
    ) {
    }
}
