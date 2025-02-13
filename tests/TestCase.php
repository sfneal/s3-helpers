<?php

namespace Sfneal\Helpers\Aws\S3\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Sfneal\Helpers\Aws\S3\Providers\S3HelpersServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;

    /**
     * Register package service providers®.
     *
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            S3HelpersServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // make sure, our .env file is loaded
        $app->useEnvironmentPath(__DIR__.'/..');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);

        $app['config']->set('filesystems.disks.s3', [
            'driver' => 's3',
            'key' => getenv('S3_KEY'),
            'secret' => getenv('S3_SECRET'),
            'region' => getenv('S3_REGION'),
            'bucket' => getenv('S3_BUCKET'),
            'root' => getenv('S3_ROOT'),
        ]);

        $app['config']->set('filesystems.default', 's3');

        parent::getEnvironmentSetUp($app);
    }
}
