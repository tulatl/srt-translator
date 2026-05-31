@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4>{{ __('Upload File') }}</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (isset($video) && $video)
            <div id="video-info">
                @include('includes.videoInfo')
            </div>
            @else
            <form id="file-upload-form" action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file">{{ trans('cruds.video.fields.file') }}</label>
                    <input class="form-control {{ $errors->has('file') ? 'is-invalid' : '' }}" type="file" name="file" id="file" value="{{ old('file', '') }}" accept="video/*">
                    @if($errors->has('file'))
                        <span class="text-danger">{{ $errors->first('file') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="language">Бичлэгний хэл</label>
                    <select name="language" class="form-control" id="language">
                        <option value="" disabled {{ old('language') ? '' : 'selected' }}>-- Бичлэгний хэл сонгоно уу --</option>
                        @foreach($languages as $label)
                            <option value="{{ $label }}" {{ old('language') == $label ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="target_language">{{ trans('cruds.video.fields.target_language') }}</label>
                    <select class="form-control {{ $errors->has('target_language') ? 'is-invalid' : '' }}" name="target_language" id="target_language">
                        <option value="" disabled {{ old('target_language') ? '' : 'selected' }}>-- Хэл сонгоно уу --</option>
                        @foreach($languages as $code => $label)
                            <option value="{{ $code }}" {{ old('target_language') == $code ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('target_language'))
                        <span class="text-danger">{{ $errors->first('target_language') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Upload') }}</button>
            </form>
            @endif
            <div id="result" style="margin-top: 10px;"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if (isset($video) && $video)
<script>
function fetchVideoInfo() {
    $.ajax({
        url: '{{ route("index") }}',
        method: 'GET',
        success: function (response) {
            console.log("Video info refreshed", response);
            $('#video-info').html(response.html);
        },
        error: function (xhr) {
            console.error("Video info fetch алдаа:", xhr);
        }
    });
}

$(document).ready(function () {
    fetchVideoInfo();
    setInterval(fetchVideoInfo, 310000);
});
</script>
@endif
@endpush