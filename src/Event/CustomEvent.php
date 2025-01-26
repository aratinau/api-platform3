<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class CustomEvent extends Event
{
    private string $message;
    private array $data;

    public function __construct(string $message, array $data = [])
    {
        $this->message = $message;
        $this->data = $data;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
