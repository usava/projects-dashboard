@extends('layouts.app')

@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-white md:py-12 md:px-16 rounded shadow">
        <h1 class="text-2xl font-normal mb-10 text-center">
            Let's add something new
        </h1>
        <form action="/projects" method="post">
            @include('projects._form', ['project' => new App\Project, 'button_text' => 'Create project'])
        </form>
    </div>
@endsection
