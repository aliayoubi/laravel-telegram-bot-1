
@extends('telegram::layout')

@section('content')

    @if ($type === 'ssl')
        <div class="ui warning message">
            To enable webhook, please visit this page using HTTPS.
            <br><strong>Note:</strong> You must own a valid SSL certificate to be able to use webhook.
        </div>
    @endif

    @if ($type === 'enabled')
        <div class="ui info message">
            Webhook was successfully <strong>enabled</strong> for <strong>{{ $bot->name(false) }}</strong>.
            <br><strong>Note:</strong> You will not be able to receive updates using getUpdates for as long as an outgoing webhook is set up.
        </div>
    @endif

    @if ($type === 'disabled')
        <div class="ui info message">
            Webhook was successfully <strong>disabled</strong> for <strong>{{ $bot->name(false) }}</strong>.
            <br><strong>Note:</strong> Now you should handle incoming updates manually.
        </div>
    @endif

@endsection