<?php

declare(strict_types=1);

namespace App\Infrastructure;

use Symfony\Component\HttpFoundation\Request;
use TerryApiBundle\ValueObject\AbstractHTTPClient;
use TerryApiBundle\ValueObject\HTTPServer;

class HTTPClient extends AbstractHTTPClient
{
    private const ACCEPT_LANGUAGE_DEFAULTS =  ['*' => 'de-DE'];
    private const ACCEPT_LANGUAGE_AVAILABLES = ['de', 'en', 'de-DE', 'en-GB'];

    public static function fromRequest(Request $request, HTTPServer $httpServer): self
    {
        return new self($request);
    }

    public function getContentLanguage(): string
    {
        // by locale
        return $this->locale();

        // or by header
        $language = $this->negotiate(
            $this->acceptLanguage(),
            self::ACCEPT_LANGUAGE,
            self::ACCEPT_LANGUAGE_DEFAULTS,
            self::ACCEPT_LANGUAGE_AVAILABLES,
        );

        return mb_substr($language, 0, 2);
    }
}