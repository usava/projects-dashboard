<div class="card flex flex-col" style="height: 200px;">
    <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 border-blue-333 pl-4">
        <a href="{{ $project->path() }}" class="text-black a-no-underline">{{$project->title}}</a>
    </h3>
    <div class="text-gray-500 flex-1">{{ str_limit($project->description, 100) }}</div>

    <footer>
        <form action="{{$project->path()}}" method="post" class="text-right">
            @csrf
            @method('DELETE')
            @can('manage', $project)
                <button type="submit" class="text-xs">Delete</button>
            @endcan
        </form>
    </footer>
</div>
