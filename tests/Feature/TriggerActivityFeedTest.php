<?php

namespace Tests\Feature;


use App\Task;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);

        tap($project->activity->last(), function($activity) {
            $this->assertEquals('created_project', $activity->description);

            $this->assertNull($activity->changes);
        });

    }

    /** @test */
    public function updating_a_project()
    {
        $project = ProjectFactory::create();
        $oldTitle = $project->title;

        $project->update(['title' => 'updated']);

        $this->assertCount(2, $project->activity);
        tap($project->activity->last(), function($activity) use ($oldTitle) {
            $this->assertEquals('updated_project', $activity->description);

            $expected = [
                'before' =>  ['title' => $oldTitle],
                'after' => ['title' => 'updated'],
            ];

            $this->assertEquals($expected, $activity->changes);
        });

    }

    /** @test */
    public function creating_a_new_task()
    {
        $project = ProjectFactory::create();
        $project->addTask('Some task');
        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('Some task', $activity->subject->body);
        });
    }

    /** @test */
    public function completing_a_new_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), ['body' => 'some body', 'completed' => true]);
        $this->assertCount(3, $project->activity);

        tap($project->activity->last(), function($activity) {
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('some body', $activity->subject->body);
        });
    }

    /** @test */
    public function incompleting_a_new_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), ['body' => 'some body', 'completed' => true]);
        $this->assertCount(3, $project->activity);

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), ['body' => 'some body', 'completed' => false]);

        $project->refresh();
        $this->assertCount(4, $project->activity);

        tap($project->activity->last(), function($activity) {
            $this->assertEquals('uncompleted_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('some body', $activity->subject->body);
        });
    }

    /** @test */
    public function deleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks[0]->delete();
        $this->assertCount(3, $project->activity);
    }
}
