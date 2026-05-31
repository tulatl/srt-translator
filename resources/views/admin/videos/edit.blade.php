@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.video.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.videos.update", [$video->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.video.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $video->name) }}">
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.video.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="language">{{ trans('cruds.video.fields.language') }}</label>
                <input class="form-control {{ $errors->has('language') ? 'is-invalid' : '' }}" type="text" name="language" id="language" value="{{ old('language', $video->language) }}">
                @if($errors->has('language'))
                    <span class="text-danger">{{ $errors->first('language') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.video.fields.language_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="target_language">{{ trans('cruds.video.fields.target_language') }}</label>
                <input class="form-control {{ $errors->has('target_language') ? 'is-invalid' : '' }}" type="text" name="target_language" id="target_language" value="{{ old('target_language', $video->target_language) }}">
                @if($errors->has('target_language'))
                    <span class="text-danger">{{ $errors->first('target_language') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.video.fields.target_language_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="str_path">{{ trans('cruds.video.fields.str_path') }}</label>
                <input class="form-control {{ $errors->has('str_path') ? 'is-invalid' : '' }}" type="text" name="str_path" id="str_path" value="{{ old('str_path', $video->str_path) }}">
                @if($errors->has('str_path'))
                    <span class="text-danger">{{ $errors->first('str_path') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.video.fields.str_path_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="translated_str_path">{{ trans('cruds.video.fields.translated_str_path') }}</label>
                <input class="form-control {{ $errors->has('translated_str_path') ? 'is-invalid' : '' }}" type="text" name="translated_str_path" id="translated_str_path" value="{{ old('translated_str_path', $video->translated_str_path) }}">
                @if($errors->has('translated_str_path'))
                    <span class="text-danger">{{ $errors->first('translated_str_path') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.video.fields.translated_str_path_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status">{{ trans('cruds.video.fields.status') }}</label>
                <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="text" name="status" id="status" value="{{ old('status', $video->status) }}">
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.video.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="expired_at">{{ trans('cruds.video.fields.expired_at') }}</label>
                <input class="form-control datetime {{ $errors->has('expired_at') ? 'is-invalid' : '' }}" type="text" name="expired_at" id="expired_at" value="{{ old('expired_at', $video->expired_at) }}">
                @if($errors->has('expired_at'))
                    <span class="text-danger">{{ $errors->first('expired_at') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.video.fields.expired_at_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection