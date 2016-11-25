
@php
    $chats = $bot->chats(function ($query) {
        return $query->paginate(20);
    });

    $chats->appends(['show' => 'chats']);

    $abilities = \SumanIon\TelegramBot\Ability::orderBy('id', 'desc')->get();
@endphp

@if ($chats->total())
    <h3>Chats {{ $chats->total() }}</h3>
    @foreach ($chats as $chat)
        @include('telegram::partials.chats.chat')
    @endforeach
    @include('telegram::partials.chats.pagination')
@else
    <div class="ui warning message">There are no chats.</div>
@endif