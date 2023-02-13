<?php

namespace LiliControl\Traits;

use Illuminate\Support\Facades\Storage;

trait UploadFileTrait
{

    public function handleFilesToUpload($disk = 's3')
    {
        foreach (request()->files as $key => $file) {
            $this->applyImageProperties($key, $file);

            $folder = $this->model->getBaseName() . "/" . $key;
            $fileName = \Str::random(16) . "." . $file->getClientOriginalExtension();
            $path = Storage::disk($disk)->putFileAs($folder, $file, $fileName, 'public');
            $this->model->$key = $path;
        }
    }

    private function applyImageProperties($key, $file)
    {
        if (!array_key_exists($key, $this->model->getImageProperties())) {
            return;
        }
        $properties = $this->model->getImageProperties()[$key];
        $width = !empty($properties['width']) ? $properties['width'] : null;
        $height = !empty($properties['height']) ? $properties['height'] : null;
        $quality = !empty($properties['quality']) ? $properties['quality'] : 100;
        $img = \Image::make($file->getRealPath())->resize($width, $height);
        $img->save(null, $quality);
    }
}
