<?php

namespace LiliControl\Traits;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * This Media Library component requires Spatie Media Library already in this package
 *
 * To use image galery component, use this trait in controller and implements Spatie Media Library
 * in Model, implementing HasMedia interface and use InteractsWithMedia trait
 *
 * New Routes:
 * Route::post('/sendImage/{id}', 'Dashboard\Controller@sendImage')->name('sendImage');
 * Route::delete('/destroyImage/{id}', 'Dashboard\Controller@destroyImage')->name('destroyImage');
 *
 *
 */
trait ImageGaleryTrait
{
    public function sendImage()
    {
        request()->validate([
            'image' => 'mimes:jpg,png|max:' . $this->model->getMaxUploadFileSize()
        ]);

        try {
            $model = $this->model->find(request()->id);
            $model->addMedia(request()->image)->toMediaCollection('images');
            return redirect()->back()->with(['success' => 'Image successfully sent']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('We has an error to sent image');
        }
    }

    public function destroyImage($id)
    {
        $media = Media::find($id);
        $media->delete();

        return redirect()->back()->with(['success' => 'Image successfully deleted!']);
    }
}
