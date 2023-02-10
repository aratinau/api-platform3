<?php

namespace App\Serializer;

use Symfony\Component\Serializer\Encoder\EncoderInterface;

class DinoEncoder implements EncoderInterface
{
    public const FORMAT = 'dino';

    public function encode($data, string $format, array $context = []): string
    {
        $body = [];
        foreach ($data[0] as $k) {
            $body[] = '🦕' . $k;
        }

        $filter = function ($tag) {
            return '<h1>' . $tag . '</h1>';
        };
        $emailsWrapped = array_map($filter, $body);
        $emailsWrapped = implode('', $emailsWrapped);

        return <<<HTML
    <html>
    <body>${emailsWrapped}</body>
    </html>
HTML;

        return json_encode($data);
    }

    public function supportsEncoding(string $format, array $context = []): bool
    {
        return self::FORMAT === $format;
    }

    public function supportsDecoding(string $format, array $context = []): bool
    {
        return self::FORMAT === $format;
    }
}
