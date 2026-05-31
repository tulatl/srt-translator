<?php

namespace App\Http\Requests;

use App\Models\Video;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateVideoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('video_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'language' => [
                'string',
                'nullable',
            ],
            'target_language' => [
                'string',
                'nullable',
            ],
            'str_path' => [
                'string',
                'nullable',
            ],
            'translated_str_path' => [
                'string',
                'nullable',
            ],
            'status' => [
                'string',
                'nullable',
            ],
            'expired_at' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}
