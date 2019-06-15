@extends('layouts.app')

@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-white md:py-12 md:px-16 rounded shadow">
        <h1 class="text-2xl font-normal mb-10 text-center">
            Edit Your Project
        </h1>
        <form action="{{$project->path()}}" method="post">
            @method('PATCH')
            @include('projects._form', ['button_text' => 'Update project'])
        </form>
    </div>
@endsection
