<div class="card" style="height: 200px;">
    <h3 class="font-normal text-xl py-4 -ml-4 border-l-4 border-blue-333 pl-4">
        <a href="{{ $project->path() }}" class="text-black a-no-underline">{{$project->title}}</a>
    </h3>
    <div class="text-gray-500">{{ str_limit($project->description, 100) }}</div>
</div>
