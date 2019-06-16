@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3">
        <div class="flex justify-between w-full it ems-end">
            <h2 class="text-gray text-sm font-normal">My projects</h2>
            <button class="button a-no-underline" @click.prevent="$modal.show('new-project')">Add project</button>
        </div>

    </header>

    <main class="lg:flex lg:flex-wrap md:flex md:flex-wrap -mx-3">
        @forelse($projects as $project)
            <div class="lg:w-1/3 md:w-1/2 px-3 pb-6">
                @include('projects.card')
            </div>
        @empty
            <div>No projects yet</div>
        @endforelse
    </main>

   <new-project-modal></new-project-modal>

    <a href="#" @click.prevent="$modal.show('new-project')">Show modal</a>
@endsection
