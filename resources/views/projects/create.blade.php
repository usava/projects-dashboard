@extends('layouts.app')

@section('content')
<h1>Create a Project</h1>

<form action="/projects" method="post">
    @csrf
    <div class="form-group">
        <label for="titleInput">Title</label>
        <input type="text"
               class="form-control" name="title" id="titleInput" aria-describedby="helpId" placeholder="Title...">
        <small id="helpId" class="form-text text-muted">Project title</small>
    </div>

    <div class="form-group">
        <label for="descriptionInput">Description</label>
        <input type="text" class="form-control" name="description" id="descriptionInput" aria-describedby="helpId" placeholder="Description...">
        <small id="helpId" class="form-text text-muted">Project description</small>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
    <button type="button" class="btn btn-outline-info" onclick="window.location.href='/projects/'">Cancel</button>
</form>
@endsection
