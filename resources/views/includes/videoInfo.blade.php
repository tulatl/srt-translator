Processing video: {{ $video->name }}<br>
<strong>Target Language:</strong> {{ $video->target_language }}<br>
<strong>Progress:</strong> {{ $progress ?? 0 }}%<br>
<strong>Status:</strong> {{ $video->status }}<br>
<strong>Date:</strong> {{ $video->created_at->format('Y-m-d H:i:s') }}<br>
<strong>Updated at:</strong> {{ $video->updated_at->format('Y-m-d H:i:s') }}<br>
@if ($video->expired_at)
<strong>Expired at:</strong> {{ $video->expired_at }}<br>
@endif
@if($video->status == 'done')
    <form action="{{ route('srt.download') }}" method="POST" style="display:inline;">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-success mt-2">{{ __('Download Srt') }}</button>
        <a href="{{ route('new.video') }}" class="btn btn-primary mt-2 ml-2">{{ __('New Video') }}</a>
    </form>
@else
<form action="{{ route('video.cancel') }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger mt-2">{{ __('Cancel') }}</button>
</form>
@endif