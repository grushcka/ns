<?php

namespace Tests\Feature;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\{RefreshDatabase, RefreshDatabaseState, WithFaker};
use Tests\TestCase;

abstract class BaseTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;


    /**
     * Refresh a conventional test database.
     *
     * @return void
     */
    protected function refreshTestDatabase()
    {
        if (!RefreshDatabaseState::$migrated) {
            $this->artisan('migrate:refresh-all');

            $this->app[Kernel::class]->setArtisan(null);

            RefreshDatabaseState::$migrated = true;
        }

        $this->beginDatabaseTransaction();
    }
}
