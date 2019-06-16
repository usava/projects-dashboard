@csrf

<div class="field mb-6">
    <label class="label text-sm mb-2 block" for="titleInput">Title</label>
    <div class="control">
        <input type="text" value="{{ $project->title }}"
               class="input bg-transparent border border-gray-333 rounded p-2 text-xs w-full" name="title"
               id="titleInput" placeholder="Title..." required />
    </div>
</div>

<div class="form-group">
    <label class="label text-sm mb-2 block" for="descriptionInput">Description</label>
    <textarea type="text" class="textarea bg-transparent border border-gray-333 rounded p-2 text-xs w-full"
              rows="10"
              name="description" id="descriptionInput"
              placeholder="Description..."
              required>{{ $project->description }}</textarea>
</div>

<div class="field">
    <div class="control">
        <button type="submit" class="button is-link mr-2">{{ $button_text }}</button>
        <button type="button" class="button outline" onclick="window.location.href='{{ $project->path() }}'">
            Cancel
        </button>
    </div>
</div>

@if($errors->any())
    <div class="field mt-6">

        @foreach($errors->all() as $error)
            <li class="text-sm text-red-600">
                {{$error}}
            </li>
        @endforeach

    </div>
@endif
