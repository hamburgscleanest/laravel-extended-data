<?php

namespace hamburgscleanest\LaravelExtendedData\Tests;

use Carbon\Carbon;
use hamburgscleanest\LaravelExtendedData\LaravelExtendedDataServiceProvider;
use hamburgscleanest\LaravelExtendedData\Models\ExtendedData;
use hamburgscleanest\LaravelExtendedData\Models\Helpers\DateTimeHelper;
use hamburgscleanest\LaravelExtendedData\Tests\Models\TestModel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as Orchestra;


class TestCase extends Orchestra
{
    protected function setUp()
    {
        parent::setUp();

        $this->setUpDatabase($this->app);

        $this->setUpHelperConfig($this->app);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [LaravelExtendedDataServiceProvider::class];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase(Application $app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['db']->connection()->getSchemaBuilder()->create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });


        TestModel::create();

        $this->loadLaravelMigrations(['--database' => 'testing']);
        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--path' => realpath(__DIR__ . '/../database/migrations'),
        ]);
    }

    protected function setUpHelperConfig(Application $app): void
    {
        $app['config']->set('laravel-extended-data', [
            'helpers' => [
                'birthday' => DateTimeHelper::class
            ],
        ]);
    }

    /**
     * @param string $date
     * @return ExtendedData
     */
    protected function getTestDateTime(string $date = '1987-02-07'): ExtendedData
    {
        $date = Carbon::parse($date);
        $ed = new ExtendedData(['datetime_01' => $date, 'helper' => 'birthday']);

        return TestModel::first()->extended_data()->save($ed);
    }

}