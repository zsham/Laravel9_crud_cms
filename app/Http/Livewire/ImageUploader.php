<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Image;

class ImageUploader extends Component
{
    use WithFileUploads;

    public $title;
    public $image;
    public $editMode = false;
    public $imageId;

    protected $rules = [
        'title' => 'required',
        'image' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:2048'
    ];

    public function render()
    {
        $images = Image::all();
        return view('livewire.image-uploader', compact('images'));
    }

    public function save()
    {
        $this->validate();
        // dd('hai');

        $filename = time() . '.' . $this->image->getClientOriginalExtension();
        $this->image->storeAs('public/images', $filename);

        Image::create([
            'title' => $this->title,
            'filename' => $filename,
        ]);

        $this->resetForm();
    }

    public function edit($id)
    {
        $image = Image::find($id);

        if ($image) {
            $this->editMode = true;
            $this->title = $image->title;
            $this->imageId = $id;
        }
    }

    public function update()
    {
        $this->validate();

        $image = Image::find($this->imageId);

        if ($image) {
            if ($this->image) {
                $filename = time() . '.' . $this->image->getClientOriginalExtension();
                $this->image->storeAs('public/images', $filename);
                $image->filename = $filename;
            }

            $image->title = $this->title;
            $image->save();

            $this->resetForm();
        }
    }

    public function delete($id)
    {
        $image = Image::find($id);

        if ($image) {
            $image->delete();
        }
    }

    private function resetForm()
    {
        $this->title = '';
        $this->image = null;
        $this->editMode = false;
        $this->imageId = null;
    }
}
