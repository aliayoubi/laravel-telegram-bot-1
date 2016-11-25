
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.8.0/styles/github.min.css">

<style>
    .app-update-content, .app-update-content code {
        margin: 0;
        max-height: 300px;
        font-size: 13px;
        line-height: 13px;
    }
</style>

@php
    $chat    = \SumanIon\TelegramBot\Chat::where('id', $request->input('id'))->first();

    if ($chat) {
        $updates = $chat->updates()->orderBy('id', 'desc')->paginate(20);
        $updates->appends([ 'show' => 'updates', 'id' => $chat->id ]);
    }
@endphp

@if ($chat)
    @if ($updates->total())
        <h3>[#{{ $chat->chat_id }}] Updates ({{ $updates->total() }})</h3>
        @foreach ($updates as $update)
            @include('telegram::partials.updates.update')
        @endforeach
        @include('telegram::partials.updates.pagination')
    @else
        <div class="ui warning message">The chat did not receive any updates.</div>
    @endif
@else
    <div class="ui warning message">The chat was not found.</div>
@endif

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.8.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.8.0/languages/json.min.js"></script>
    <script>
        hljs.initHighlightingOnLoad();
    </script>
@endpush