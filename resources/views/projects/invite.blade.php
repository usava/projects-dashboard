<div class="card flex flex-col mt-3">
    <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 border-accent-light pl-4">
        Invite a User
    </h3>

    <form action="{{$project->path()}}/invitations" method="post" >
        @csrf
        <div class="mb-3">
            <input type="email" name="email" class="py-2 px-3 bg-card text-default border border-muted rounded w-full" placeholder="Email address" style="color: var(--text-muted-color)">
        </div>
        <button type="submit" class="button">Invite</button>
    </form>

    @include('errors', ['bag' => 'invitations'])
</div>
