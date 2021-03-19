<?php

namespace TealOrca\LaravelFreshchat;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TealOrca\LaravelFreshchat\Skeleton\SkeletonClass
 */
class LaravelFreshchatFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-freshchat';
    }
}
