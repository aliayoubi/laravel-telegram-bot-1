
<div style="margin-top: 40px">
    <div class="ui floating dropdown labeled icon button">
        <i class="send icon"></i>
        <span class="text">{{ $bot->name(false) }}</span>
        <div class="menu">
            @foreach($bots as $_bot)
                <a href="/api/telegram-bot/{{ $_bot->token() }}" class="{{ $token === $_bot->token() ? 'active' : '' }} item">
                    {{ $_bot->name(false) }}
                </a>
            @endforeach
        </div>
    </div>
</div>