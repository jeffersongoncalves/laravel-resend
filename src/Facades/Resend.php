<?php

namespace Jeffersongoncalves\Resend\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jeffersongoncalves\Resend\Resend
 */
class Resend extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-resend';
    }
}
