
@extends('telegram::layout')

@section('content')

    @if ($show === 'overview')
        @include('telegram::partials.overview')
    @elseif ($show === 'chats')
        @include('telegram::partials.chats')
    @elseif ($show === 'updates')
        @include('telegram::partials.updates')
    @else
        <div class="ui warning message">The requested page was not found.</div>
    @endif

@endsection