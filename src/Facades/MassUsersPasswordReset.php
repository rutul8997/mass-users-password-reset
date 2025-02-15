<?php

namespace Rutul\MassUsersPasswordReset\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rutul\MassUsersPasswordReset\MassUsersPasswordReset
 */
class MassUsersPasswordReset extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Rutul\MassUsersPasswordReset\MassUsersPasswordReset::class;
    }
}
