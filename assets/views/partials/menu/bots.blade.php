
<div style="margin-top: 40px">
    <div class="ui floating dropdown labeled icon button">
        <i class="send icon"></i>
        <span class="text">{{ $bot->name(false) }}</span>
        <div class="menu">
            @foreach($bots as $bot)
                <a href="/api/telegram-bot/{{ $bot->token() }}" class="{{ $token === $bot->token() ? 'active' : '' }} item">
                    {{ $bot->name(false) }}
                </a>
            @endforeach
        </div>
    </div>
</div>