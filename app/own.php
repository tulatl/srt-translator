<?php

use Illuminate\Support\Facades\Http;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

if (!function_exists('generateAudio')) {
    function generateAudio($video){

        $audioPath = storage_path('app/public/' . $video->file->id . '/audio.wav');

        if(!file_exists($audioPath)){
            convertToWav($video->file);
        }

        $video->updateQuietly([
            'name' => pathinfo($video->file->file_name, PATHINFO_FILENAME),
        ]);
        
        return $audioPath;
    }
}

if (!function_exists('convertToWav')) {
    function convertToWav($file)
    {
        $inputPath = storage_path('app/public/' . $file->id . '/' . $file->file_name);
        $outputDir = storage_path('app/public/' . $file->id);
        $outputPath = $outputDir . '/audio.wav';

        $process = new Process([
            'ffmpeg',
            '-i', $inputPath,
            '-vn',
            '-acodec', 'pcm_s16le',
            '-ar', '16000',
            '-ac', '1',
            $outputPath
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return true;
    }
}

if (!function_exists('generateSrt')) {
    function generateSrt($video){
        try{
            $audioPath = storage_path('app/public/' . $video->file->id . '/audio.wav');
            $outputDir = storage_path('app/public/' . $video->file->id);
            $outputSrt = $outputDir  . '/audio.srt';

            if(file_exists($outputSrt)){
                return $outputSrt;
            }
            // Whisper команд
            $process = new Process([
                'whisper',
                $audioPath,
                '--model', 'small',
                '--output_format', 'srt',
                '--output_dir', $outputDir,
                '--language', $video->language ?? 'English',
            ]);
            
            $process->setTimeout(1800);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new \RuntimeException($process->getErrorOutput());
            }

            $video->update([
                'str_path' => $outputSrt,
                'status' => 'srt_generated',
            ]);
        } catch (\Exception $e) {
            // Handle the exception
            \Log::error('Error generating SRT: ' . $e->getMessage());
            $video->update([
                'status' => 'SRT generate failed',
            ]);
            return false;
        }

        return $outputSrt;
    }
}

if (!function_exists('translate')) {
    function translate($video, $target_mn){
        try{
            if (empty($video->str_path) && file_exists($video->str_path)) {
                $video->update(['status' => 'SRT path is empty']);
                throw new \Exception("STR path хоосон байна! Видео ID: {$video->id}");
            } else {
                $lines = file($video->str_path); 
                $outputFilePath = storage_path('app/public/' . $video->file->id . '/' . $video->name . '.srt');
                $translatedLines = [];

                foreach ($lines as $line) {
                    $trimmed = trim($line);

                    if (strpos($line, '-->') === false && !ctype_digit($trimmed) && $trimmed !== '') {
                        // Орчуулах хэсэг
                        $response = Http::get('https://translate.googleapis.com/translate_a/single', [
                            'client' => 'gtx',
                            'sl' => 'auto',
                            'tl' => $target_mn,
                            'dt' => 't',
                            'q' => $trimmed,
                        ]);

                        if ($response->successful()) {
                            $translatedText = $response[0][0][0] ?? $trimmed;
                            $translatedLines[] = $translatedText . "\n";
                        } else {
                            $translatedLines[] = $trimmed . "\n"; // fallback
                        }
                    } else {
                        $translatedLines[] = $line;
                    }
                }

                file_put_contents($outputFilePath, implode('', $translatedLines));
                $video->updateQuietly([
                    'translated_str_path' => $outputFilePath,
                    'expired_at' => now()->addDays(2)->toDateTimeString(),
                    'status' => 'done',
                ]);
            }
            
        } catch (\Exception $e) {
            \Log::error('Error translating SRT: ' .__LINE__. ' ' . $e->getMessage());
        }
        
        // $video->update([
        //     'translated_str_path' => $outputFilePath,
        //     'status' => 'translated',
        // ]);
    }
}