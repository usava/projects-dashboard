<div class="card flex flex-col mt-3">
    <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 border-blue-333 pl-4">
        Invite a User
    </h3>

    <form action="{{$project->path()}}/invitations" method="post" >
        @csrf
        <div class="mb-3">
            <input type="email" name="email" class="border border-gray-700 rounded w-full" placeholder="Email address">
        </div>
        <button type="submit" class="button-blue text-xs">Invite</button>
    </form>

    @include('errors', ['bag' => 'invitations'])
</div>
