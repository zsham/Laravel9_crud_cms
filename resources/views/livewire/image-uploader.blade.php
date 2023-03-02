<div>
    <form wire:submit.prevent="{{ $editMode ? 'update' : 'save' }}" enctype="multipart/form-data">
        <div>
            <label>Title:</label>
            <input type="text" wire:model="title">
            @error('title') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Image:</label>
            <input type="file" wire:model="image">
            @if ($image)
                <img src="{{ $image->temporaryUrl() }}" width="150">
            @elseif ($editMode)
                <img src="{{ asset('storage/images/' . $images->find($imageId)->filename) }}" width="150">
            @endif
            @error('image') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div>
            <button type="submit">{{ $editMode ? 'Update' : 'Save' }}</button>
            @if ($editMode)
                <button type="button" wire:click="delete({{ $imageId }})">Delete</button>
            @endif
        </div>
    </form>
    <br>
    <table class="table table-bordered table-striped table-hover datatable" >
        <thead>
            <tr>
                <th>Title</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($images as $image)
                <tr>
                    <td>{{ $image->title }}</td>
                    <td><img src="{{ asset('storage/images/' . $image->filename) }}" width="150"></td>
                    <td><button type="button" wire:click="edit({{ $image->id }})">Edit</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
