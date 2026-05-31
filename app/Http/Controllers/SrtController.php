<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class SrtController extends Controller
{
    protected $languages = [
        'af' => 'Afrikaans',
        'ar' => 'Arabic',
        'az' => 'Azerbaijani',
        'be' => 'Belarusian',
        'bg' => 'Bulgarian',
        'bn' => 'Bengali',
        'ca' => 'Catalan',
        'cs' => 'Czech',
        'cy' => 'Welsh',
        'da' => 'Danish',
        'de' => 'German',
        'el' => 'Greek',
        'en' => 'English',
        'eo' => 'Esperanto',
        'es' => 'Spanish',
        'et' => 'Estonian',
        'fa' => 'Persian',
        'fi' => 'Finnish',
        'fr' => 'French',
        'gl' => 'Galician',
        'gu' => 'Gujarati',
        'he' => 'Hebrew',
        'hi' => 'Hindi',
        'hr' => 'Croatian',
        'ht' => 'Haitian Creole',
        'hu' => 'Hungarian',
        'id' => 'Indonesian',
        'is' => 'Icelandic',
        'it' => 'Italian',
        'ja' => 'Japanese',
        'ka' => 'Georgian',
        'ko' => 'Korean',
        'la' => 'Latin',
        'lt' => 'Lithuanian',
        'lv' => 'Latvian',
        'mk' => 'Macedonian',
        'mn' => 'Mongolian',
        'ms' => 'Malay',
        'mt' => 'Maltese',
        'nl' => 'Dutch',
        'no' => 'Norwegian',
        'pl' => 'Polish',
        'pt' => 'Portuguese',
        'ro' => 'Romanian',
        'ru' => 'Russian',
        'sk' => 'Slovak',
        'sl' => 'Slovenian',
        'sq' => 'Albanian',
        'sr' => 'Serbian',
        'sv' => 'Swedish',
        'sw' => 'Swahili',
        'ta' => 'Tamil',
        'te' => 'Telugu',
        'th' => 'Thai',
        'tl' => 'Tagalog',
        'tr' => 'Turkish',
        'uk' => 'Ukrainian',
        'ur' => 'Urdu',
        'vi' => 'Vietnamese',
        'zh-CN' => 'Chinese (Simplified)',
        'zh-TW' => 'Chinese (Traditional)',
    ];
    
    public function test()
    {
        if(Video::where('status', 'pending')->exists()){
            return null;
        }
        // if(Video::where('status', 'translated')->exists()){
        //     $video = Video::where('status', 'translated')->first();
        //     $video->updateQuietly([
        //         'expired_at' => now()->addDays(2)->toDateTimeString(),
        //         'status' => 'done',
        //     ]);
        // }
        if(Video::where('status', 'srt_generated')->exists()){
            $video = Video::where('status', 'srt_generated')->first();
            translate($video, $video->target_language);
        }
        $video = Video::where('status', 'new')->first();
        $video->update(['status' => 'pending']);
    }

    public function index(Request $request)
    {
        $progress = 0;
        if (session()->has('video_token')) {
            $token = session()->get('video_token');
            $video = Video::where('token', $token)->first();
            if($video){
                if(empty($video->file)){
                    $video->delete();
                    session()->forget('video_token');
                }
                if ($video->file) {
                    $progress = 20;
                }
                if($video->status == 'pending'){
                    $progress = 30;
                }
                if($video->status == 'audio_generated'){
                    $progress = 40;
                }
                if($video->status == 'srt_generated'){
                    $progress = 80;
                }
                if($video->status == 'translated'){
                    $progress = 90;
                }
                if($video->status == 'done'){
                    $progress = 100;
                }
                // if($video->status == 'new'){
                //     $video->update([
                //         'name' => $video->name . '_' . $video->id,
                //     ]);
                // }
            } else {
                session()->forget('video_token');
            }

            if($request->ajax()){
                $html = view('includes.videoInfo', compact('video', 'progress'))->render();
                return response()->json([
                    'html' => $html,
                ]);
            }
        } else {
            $video = null;
        }
        $languages = $this->languages;
        return view('index', compact('languages', 'video', 'progress'));
    }
    
    public function newVideo()
    {
        session()->has('video_token') ? session()->forget('video_token') : null;
        return view('index', ['languages' => $this->languages]);
    }

    public function upload(Request $request)
    {
        $data = $request->validate([
            'file' => 'required|mimes:mp4,avi,mov,mkv,webm',
            'language' => 'required|in:' . implode(',', $this->languages),
            'target_language' => 'required|in:' . implode(',', array_keys($this->languages)),
        ]);

        $video = Video::create([
            'language' => $data['language'],
            'target_language' => $data['target_language'],
        ]);

        session(['video_token' => $video->token]);
        
        if ($request->hasFile('file')) {
            $video->addMedia($request->file('file'))->toMediaCollection('file');
        }

        return redirect()->route('index')->with('status', 'File uploaded successfully');
    }

    public function uploadAjax(Request $request)
    {
        $data = $request->validate([
            'file' => 'required|mimes:mp4,avi,mov,mkv,webm',
            'target_language' => 'required|in:' . implode(',', array_keys($this->languages)),
        ]);

        $video = Video::create([
            'target_language' => $data['target_language'],
        ]);

        session(['video_token' => $video->token]);

        if ($request->hasFile('file')) {
            $media = $video->addMedia($request->file('file'))->toMediaCollection('file');
        }

        // AJAX-д зориулж JSON хариу буцаана
        return response()->json([
            'success' => true,
            'message' => 'Файл амжилттай хуулагдлаа',
            'token' => $video->token,
        ]);
    }

    public function cancel()
    {
        if (session()->has('video_token')) {
            $token = session()->get('video_token');
            $video = Video::where('token', $token)->first();
            if ($video) {
                $video->delete();
                session()->forget('video_token');
                return redirect()->route('index')->with('status', 'Video upload cancelled successfully');
            }
        }
        return redirect()->route('index')->withError(['error' => 'No video found to cancel']);
    }

    public function download()
    {
        if (session()->has('video_token')) {
            $token = session()->get('video_token');
            $video = Video::where('token', $token)->first();
            if ($video) {
                return response()->download($video->translated_str_path);
            }
        }
        return redirect()->route('index')->withError(['error' => 'No video file found to download']);
    }
}
