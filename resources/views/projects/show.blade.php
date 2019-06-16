@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3">
        <div class="flex justify-between w-full it ems-end">
            <p class="text-gray text-sm font-normal">
                <a href="/projects" class="text-muted no-underline hover:underline">My projects</a> / <span>{{ $project->title }}</span>
            </p>
            <div class="flex items-center">
                @foreach($project->members as $member)
                    <img src="{{ gravatar_url($member->email) }}" alt="{{ $member->name }}'s avatar"
                         title="{{ $member->name }}" class="rounded-full w-8 mr-2"/>
                @endforeach
                <img src="{{ gravatar_url($project->owner->email) }}" alt="{{ $project->owner->name }}'s avatar"
                     title="{{ $project->owner->name }}" class="rounded-full w-8 mr-2"/>

                <a class="button no-underline hover:no-underline ml-6" href="{{$project->path()}}/edit">Edit project</a>
            </div>
        </div>
    </header>

    <main>
        <div class="flex -mx-3">
            <div class="lg:w-3/4 px-3">
                <div class="mb-6">
                    <h2 class="text-lg text-gray font-normal mb-3">Tasks</h2>

                    @foreach($project->tasks as $task)
                        <div class="card mb-3">
                            <form method="POST" action="{{ $task->path() }}">
                                @method('PATCH')
                                @csrf
                                <div class="flex items-center">
                                    <input name="body" value="{{ $task->body }}" type="text"
                                           class="w-full px-2 text-default bg-card {{ $task->completed ? 'line-through text-muted' : '' }}"/>
                                    <input type="checkbox" name="completed" value="1"
                                           {{ $task->completed ? 'checked' : '' }} onchange="this.form.submit()"/>
                                </div>

                            </form>
                        </div>
                    @endforeach

                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="post">
                            @csrf

                            <input name="body" placeholder="Just type what you should do..." class="w-full p-2 text-default bg-card">
                        </form>
                    </div>
                </div>

                <div class="mb-6">
                    <h2 class="text-lg text-muted font-light mb-3">General Notes</h2>
                    <div>
                        <form method="post" actioin="{{ $project->path() }}">
                            @method('PATCH')
                            @csrf
                            <textarea name="notes" class="card text-default w-full mb-4"
                                      style="min-height: 200px;"
                                      placeholder="Anything special that you want to make a note of?">
                                {{ $project->notes }}
                            </textarea>
                            <button type="submit" class="button mt-4">Save</button>
                        </form>

                        @include('errors')

                    </div>
                </div>
            </div>
            <div class="lg:w-1/4 px-3">
                @include('projects.card')

                @include('projects.activity.card')

                @can('manage', $project)
                    @include('projects.invite')
                @endcan
            </div>
        </div>
    </main>

@endsection
