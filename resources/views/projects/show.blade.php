@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3">
        <div class="flex justify-between w-full it ems-end">
            <h2 class="text-gray text-sm font-normal">
                <a href="/projects" class="a-no-underline">My projects</a> / <span>{{ $project->title }}</span>
            </h2>
            <a class="button-blue a-no-underline" href="{{$project->path()}}/edit">Edit project</a>
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
                                           class="w-full {{ $task->completed ? 'text-gray-500' : '' }}"/>
                                    <input type="checkbox" name="completed" value="1"
                                           {{ $task->completed ? 'checked' : '' }} onchange="this.form.submit()"/>
                                </div>

                            </form>
                        </div>
                    @endforeach

                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="post">
                            @csrf

                            <input name="body" placeholder="Just type what you should do..." class="w-full">
                        </form>
                    </div>
                </div>

                <div class="mb-6">
                    <h2 class="text-lg text-gray font-normal mb-3">General Notes</h2>
                    <div>
                        <form method="post" actioin="{{ $project->path() }}">
                            @method('PATCH')
                            @csrf
                            <textarea name="notes" class="card w-full" style="min-height: 200px;"
                                      placeholder="Anything special that you want to make a note of?">{{ $project->notes }}</textarea>
                            <button type="submit" class="button-blue mt-4">Save</button>
                        </form>

                        @if($errors->any())
                            <div class="field mt-6">

                                @foreach($errors->all() as $error)
                                    <li class="text-sm text-red-600">
                                        {{$error}}
                                    </li>
                                @endforeach

                            </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="lg:w-1/4 px-3">
                @include('projects.card')

                @include('projects.activity.card')
            </div>
        </div>
    </main>

@endsection
