<?php

use Spatie\MediaLibrary\MediaCollections\Models\Media;

if (!function_exists('getAllMediaImages')) {
    function getAllMediaImages($model, $collection = 'images')
{
    return $model->getMedia($collection)->map(function ($media) {
        return [
            'id' => $media->id,
            'url' => $media->getFullUrl(),
            'name' => $media->name,
            'mime_type' => $media->mime_type,
            'size' => $media->size,
            'created_at' => $media->created_at,
        ];
    })->toArray();
}

}

function storeRoomImage($file, $room, $collection = 'room_images'): ?Media
{
    if ($file && $file->isValid()) {
        return $room->addMedia($file)->toMediaCollection($collection);
    }

    return null;
}
