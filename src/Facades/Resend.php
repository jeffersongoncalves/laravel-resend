<?php

namespace JeffersonGoncalves\Resend\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JeffersonGoncalves\Resend\Resend
 *
 * @method static \JeffersonGoncalves\Resend\Resources\Emails emails()
 * @method static \JeffersonGoncalves\Resend\Resources\Domains domains()
 * @method static \JeffersonGoncalves\Resend\Resources\ApiKeys apiKeys()
 * @method static \JeffersonGoncalves\Resend\Resources\Audiences audiences()
 * @method static \JeffersonGoncalves\Resend\Resources\Contacts contacts()
 * @method static \JeffersonGoncalves\Resend\Resources\Webhooks webhooks()
 * @method static \JeffersonGoncalves\Resend\Resources\Templates templates()
 * @method static \JeffersonGoncalves\Resend\Resources\Broadcasts broadcasts()
 * @method static \JeffersonGoncalves\Resend\Resources\Segments segments()
 */
class Resend extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \JeffersonGoncalves\Resend\Resend::class;
    }
}
