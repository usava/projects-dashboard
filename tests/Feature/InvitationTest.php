<?php

namespace Tests\Feature;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_invite_a_user()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();
        $userToInvite = factory(User::class)->create();
        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
            'email' => $userToInvite->email
            ])
            ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    /** @test */
    public function invited_users_may_update_project_details()
    {
        $project = ProjectFactory::create();

        $project->invite($newUser = factory(User::class)->create());
        $this->signIn($newUser);
        $this->post(action('ProjectTasksController@store', $project), $task = ['body' => 'Foo bar tast']);
        $this->assertDatabaseHas('tasks', $task);
    }

    /** @test */
    public function the_email_must_be_associated_with_a_valid_member()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
                'email' => 'notasuser@example.com'
            ])
            ->assertSessionHasErrors([
                'email' => 'The user you are inviting must have a Dashboard Account'
            ], null, 'invitations');
    }

    /** @test */
    public function not_the_owner_of_a_project_may_not_invite_users()
    {
        $project = ProjectFactory::create();

        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post($project->path() . '/invitations')
            ->assertStatus(403);

        $project->invite($user);

        $this->actingAs($user)
            ->post($project->path() . '/invitations')
            ->assertStatus(403);
    }
}
