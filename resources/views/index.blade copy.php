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
            <div id="loading" style="display: none; color: blue; margin-top: 10px;">
                Та түр хүлээнэ үү...
            </div>

            <div id="result" style="margin-top: 10px;"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#file-upload-form').on('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    $('#loading').show();
    $('#result').empty();

    $.ajax({
        url: '{{ route('file.upload') }}', // Laravel backend route
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response);
            $('#loading').hide();
            $('#result').html('<span style="color: green;">Upload success: ' + response.message + '</span>');
        },
        error: function(xhr) {
            $('#loading').hide();
            $('#result').html('<span style="color: red;">Upload failed: ' + xhr.responseText + '</span>');
        }
    });
});
</script>
@endpush