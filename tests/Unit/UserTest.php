<?php

namespace Tests\Unit;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;
    /** @test */
    public function user_has_projects()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    public function user_has_accessible_projects()
    {
        $devine = $this->signIn();

        ProjectFactory::ownedBy($devine)->create();
        $this->assertCount(1, $devine->accessibleProjects());

        $slava = factory(User::class)->create();
        $oleg = factory(User::class)->create();

        $project = tap(ProjectFactory::ownedBy($slava)->create())->invite($oleg);
        $this->assertCount(1, $devine->accessibleProjects());

        $project->invite($devine);
        $this->assertCount(2, $devine->accessibleProjects());
    }


}
