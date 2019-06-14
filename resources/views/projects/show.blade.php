@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3">
        <div class="flex justify-between w-full it ems-end">
            <h2 class="text-gray text-sm font-normal">
                <a href="/projects" class="a-no-underline">My projects</a> / <span>{{ $project->title }}</span>
            </h2>
            <a class="button-blue a-no-underline" href="/projects/create">Add project</a>
        </div>
    </header>

    <main>
        <div class="flex -mx-3">
            <div class="lg:w-3/4 px-3">
                <div class="mb-6">
                    <h2 class="text-lg text-gray font-normal mb-3">Tasks</h2>

                    @foreach($project->tasks as $task)
                        <div class="card">{{ $task->body }}</div>
                    @endforeach
                </div>

                <div class="mb-6">
                    <h2 class="text-lg text-gray font-normal mb-3">General Notes</h2>
                    <div class="card w-full" style="min-height: 200px;">
                        Lorem ipsum...
                    </div>
                </div>
            </div>
            <div class="lg:w-1/4 px-3">
                @include('projects.card')
            </div>
        </div>
    </main>

@endsection
