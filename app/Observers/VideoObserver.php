<?php

namespace App\Observers;

use App\Models\Video;

class VideoObserver
{
    /**
     * Handle the Video "created" event.
     */
    public function created(Video $video): void
    {
        $sessionToken = bin2hex(random_bytes(16));
        $video->updateQuietly([
            'status' => 'new',
            'token' => $sessionToken,
        ]);
    }

    /**
     * Handle the Video "updated" event.
     */
    public function updated(Video $video): void
    {
        if ($video->wasChanged('status') && $video->status == 'pending') {
            $autioPath = generateAudio($video);
            $video->updateQuietly([
                'status' => 'audio_generated',
            ]);
            $srt_path = generateSrt($video);
            if(empty($srt_path)){
                \Log::error('SRT path is empty for video ID: ' . $video->id);
                return;
            }
            $video->updateQuietly([
                'status' => 'srt_generated',
            ]);
        }
        if ($video->wasChanged('str_path') && !empty($video->str_path) && file_exists($video->str_path)) {
            translate($video, $video->target_language);
        }
        if ($video->wasChanged('status') && $video->status == 'translated') {
            $video->updateQuietly([
                'expired_at' => now()->addDays(2)->toDateTimeString(),
                'status' => 'done',
            ]);
        }
    }

    /**
     * Handle the Video "deleted" event.
     */
    public function deleted(Video $video): void
    {
        if ($video->file) {
            $dir = storage_path('app/public/' . $video->file->id);
            if (file_exists($dir)) {
                \File::deleteDirectory($dir);
            }
            $video->file->delete();
        }
    }

    /**
     * Handle the Video "restored" event.
     */
    public function restored(Video $video): void
    {
        //
    }

    /**
     * Handle the Video "force deleted" event.
     */
    public function forceDeleted(Video $video): void
    {
        //
    }
}
