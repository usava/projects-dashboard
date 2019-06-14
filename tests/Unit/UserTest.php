<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;
    /** @test */
    public function has_projects()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }
}
