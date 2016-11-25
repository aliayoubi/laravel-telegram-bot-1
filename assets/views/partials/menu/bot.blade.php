
<div style="margin-top: 40px">
    <div class="ui menu">
        <a href="/api/telegram-bot/{{ $token }}" class="{{ $show === 'overview' ? 'active' : '' }} item">
            Overview
        </a>
        <a href="/api/telegram-bot/webhook/{{ $token }}/enable" class="{{ $show === 'enable' ? 'active' : '' }} item" style="color: #2DB84B">
            Enable Webhook
        </a>
        <a href="/api/telegram-bot/webhook/{{ $token }}/disable" class="{{ $show === 'disable' ? 'active' : '' }} item" style="color: #D92B2F">
            Disable Webhook
        </a>
    </div>
</div>