<?php

namespace TealOrca\LaravelFreshchat\Tests;

use Orchestra\Testbench\TestCase;
use TealOrca\LaravelFreshchat\LaravelFreshchatServiceProvider;

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
