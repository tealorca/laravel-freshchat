<?php

namespace Tealorca\LaravelFreshchat\Tests;

use Orchestra\Testbench\TestCase;
use Tealorca\LaravelFreshchat\LaravelFreshchatServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelFreshchatServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
