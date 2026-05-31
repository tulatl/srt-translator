@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.video.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.videos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.video.fields.id') }}
                        </th>
                        <td>
                            {{ $video->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.video.fields.name') }}
                        </th>
                        <td>
                            {{ $video->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.video.fields.file') }}
                        </th>
                        <td>
                            @if($video->file)
                                <a href="{{ $video->file->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.video.fields.language') }}
                        </th>
                        <td>
                            {{ $video->language }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.video.fields.target_language') }}
                        </th>
                        <td>
                            {{ $video->target_language }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.video.fields.str_path') }}
                        </th>
                        <td>
                            {{ $video->str_path }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.video.fields.translated_str_path') }}
                        </th>
                        <td>
                            {{ $video->translated_str_path }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.video.fields.size') }}
                        </th>
                        <td>
                            {{ $video->size }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.video.fields.duration') }}
                        </th>
                        <td>
                            {{ $video->duration }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.video.fields.status') }}
                        </th>
                        <td>
                            {{ $video->status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.video.fields.expired_at') }}
                        </th>
                        <td>
                            {{ $video->expired_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.video.fields.token') }}
                        </th>
                        <td>
                            {{ $video->token }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.videos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection