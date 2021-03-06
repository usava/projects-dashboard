<?php

namespace Tests\Feature;

use App\Project;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->signIn();
        $this->get('/projects/create')->assertStatus(200);

        $attrs = factory(Project::class)->raw(['owner_id' => auth()->id()]);

        $this->followingRedirects()
            ->post('/projects', $attrs)
            ->assertSee($attrs['title'])
            ->assertSee($attrs['description'])
            ->assertSee($attrs['notes']);

        $this->assertDatabaseHas('projects', $attrs);
    }

    /** @test */
    public function a_user_can_view_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title)
            ->assertSee(str_limit($project->description, 100));
    }

    /** @test */
    public function an_authenticated_user_cannot_view_projects_of_others()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function guest_cannot_manage_projects()
    {
        $project = factory('App\Project')->create();
        $this->get('/projects/create')->assertRedirect('login');
        $this->get('/projects')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = ['title' => 'Changed', 'description' => 'Changed', 'notes' => 'Changed'])
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_update_a_general_notes()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = ['notes' => 'Changed'])
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_projects_of_others()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->patch($project->path())->assertStatus(403);
    }

    /** @test */
    public function a_user_can_delete_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /** @test */
    public function unauthorized_users_cannot_delete_a_project()
    {
        $project = factory(Project::class)->create();

        $this->delete($project->path())->assertRedirect('/login');

        $this->signIn();

        $this->delete($project->path())->assertStatus(403);

        $this->assertDatabaseHas('projects', $project->only('id'));
    }

    /** @test */
    public function not_project_owner_cannot_delete_a_project()
    {
        $project = ProjectFactory::create();

        $user = $this->signIn();
        $project->invite($user);

        $this->actingAs($user)
            ->delete($project->path())
            ->assertStatus(403);

        $this->assertDatabaseHas('projects', $project->only('id'));
    }

    /** @test */
    public function a_user_can_see_all_projects_they_have_invited_to_on_their_dashboard()
    {
        $project = tap(ProjectFactory::create())->invite($this->signIn());

        $this->get('/projects')->assertSee($project->title);
    }

    /** @test */
    public function tasks_can_be_included_as_part_a_new_project()
    {
        $this->signIn();

        $attrs = factory(Project::class)->raw();
        $attrs['tasks'] = [
            ['body' => 'Task 1'],
            ['body' => 'Task 2'],
        ];

        $this->followingRedirects()
            ->post('/projects', $attrs);

        $this->assertCount(2,Project::first()->tasks);
    }
}
