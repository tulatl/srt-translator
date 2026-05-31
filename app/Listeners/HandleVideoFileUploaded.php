<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAdded;

class HandleVideoFileUploaded
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MediaHasBeenAdded $event)
    {
        $media = $event->media;

        if ($media->collection_name === 'file') {
            $video = $media->model;

            $video->update([
        //         'name' => $media->name,
                'size' => $media->size,
                'duration' => $media->getCustomProperty('duration'),
            ]);


        //     // энд хадмал үүсгэх эсвэл watcher trigger хийх г.м
            \Log::info("🎬 File uploaded for video ID: {$video->id}, filename: {$media->file_name}");
        }
    }
}
