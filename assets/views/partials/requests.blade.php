
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.8.0/styles/github.min.css">

<style>
    .app-request-content, .app-request-content code {
        max-width: 910px;
        max-height: 300px;
        margin: 0;
        font-size: 13px;
        line-height: 13px;
    }
</style>

@php
    $chat = \SumanIon\TelegramBot\Chat::where('id', $request->input('id'))->first();

    if ($chat) {
        $requests = $chat->requests()->orderBy('id', 'desc')->paginate(20);
        $requests->appends([ 'show' => 'requests', 'id' => $chat->id ]);
    }
@endphp

@if ($chat)
    @if ($requests->total())
        <h3>[#{{ $chat->chat_id }}] Requests ({{ $requests->total() }})</h3>
        @foreach ($requests as $request)
            @include('telegram::partials.requests.request')
        @endforeach
        @include('telegram::partials.requests.pagination')
    @else
        <div class="ui warning message">The Bot did not send any requests to the chat.</div>
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