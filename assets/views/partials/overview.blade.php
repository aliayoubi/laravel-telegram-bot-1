
<table class="ui very basic celled table">
    <tbody>
        <tr>
            <td class="collapsing"><strong>Fully-Qualified Class Name</strong></td>
            <td>{{ $bot->name() }}</td>
        </tr>
        <tr>
            <td class="collapsing"><strong>Number of Active Chats</strong></td>
            <td>
                <a href="/api/telegram-bot/{{ $token }}/?show=chats">
                    {{ \SumanIon\TelegramBot\Chat::where('manager', $bot->name())->count() }}
                </a>
            </td>
        </tr>
        <tr>
            <td class="collapsing"><strong>Number of Updates</strong></td>
            <td>
                {{ \SumanIon\TelegramBot\Update::where('manager', $bot->name())->count() }}
                <a href="/api/telegram-bot/{{ $token }}/refresh-updates" style="margin-left: 5px">refresh</a>
            </td>
        </tr>
        <tr>
            <td class="collapsing"><strong>Number of Requests</strong></td>
            <td>{{ \SumanIon\TelegramBot\Request::where('manager', $bot->name())->count() }}</td>
        </tr>
        <tr>
            <td class="top aligned collapsing"><strong>Available Abilities</strong></td>
            <td>
                @php
                    $abilities = \SumanIon\TelegramBot\Ability::orderBy('id', 'desc')->get();
                @endphp

                <form action="/api/telegram-bot/{{ $token }}/ability" method="POST" class="ui form">
                    <div class="ui action input">
                        <input type="text" name="name" autocomplete="off" spellcheck="false">
                        <button class="ui mini button" type="submit">CREATE</button>
                    </div>
                </form>

                @if ($abilities->count())
                    <div style="margin-top: 20px">
                        <div class="ui bulleted list">
                            @foreach ($abilities as $ability)
                                <div class="item">
                                    {{ $ability->name }}
                                    <a href="/api/telegram-bot/{{ $token }}/ability/{{ $ability->id }}/delete" style="font-size: 10px; margin-left: 5px">
                                        DELETE
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </td>
        </tr>
    </tbody>
</table>