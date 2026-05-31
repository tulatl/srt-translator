<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Video;

class AutoTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try{
            if (Video::where('status', 'pending')->exists()) {
                \Log::info('Auto task ajillaa - pending');
                $video = Video::where('status', 'pending')->first();
                if ($video && $video->updated_at->lt(now()->subMinutes(30))) {
                    $video->update([
                        'status' => 'new'
                    ]);
                    \Log::info('Auto task ajillaa - pending -> new');
                }
            }
        } catch (\Exception $e) {
            \Log::error('Auto task error: '.__LINE__. ' ' . $e->getMessage());
        }

        try{
            if(Video::where('status', 'srt_generated')->exists()){
                $video = Video::where('status', 'srt_generated')->first();
                \Log::info('Auto task ajillaa - srt_generated');
                translate($video, $video->target_language);
            }
        } catch (\Exception $e) {
            \Log::error('Auto task error: '.__LINE__. ' ' . $e->getMessage());
        }

        // try{
        //     if(Video::where('status', 'translated')->exists()){
        //         $video = Video::where('status', 'translated')->first();
        //         $video->updateQuietly([
        //             'expired_at' => now()->addDays(2)->toDateTimeString(),
        //             'status' => 'done',
        //         ]);
        //         \Log::info('Auto task ajillaa - translated');
        //     }
        // } catch (\Exception $e) {
        //     \Log::error('Auto task error: '.__LINE__. ' ' . $e->getMessage());
        // }

        try{
            $video = Video::where('status', 'new')->first();
            if ($video) {
                $video->update(['status' => 'pending']);
                \Log::info('Auto task ajillaa - new -> pending');
            } else {
                \Log::info('Auto task ajillaa - no new video');
            }
        } catch (\Exception $e) {
            \Log::error('Auto task error: '.__LINE__. ' ' . $e->getMessage());
        }
        

        \Log::info('Auto task ajillaa - ' . now());
    }
}
