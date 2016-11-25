
<div style="margin-top: 40px">
    <table class="ui very basic celled table">
        <tbody>
            <tr>
                <td style="width: 200px">
                    <strong>{{ $chat->chat_id }}</strong>
                    @if ($chat->type === 'private')
                        <div class="ui mini green horizontal label" style="margin-left: 5px">{{ strtoupper($chat->type) }}</div>
                    @else
                        <div class="ui mini yellow horizontal label" style="margin-left: 5px">{{ strtoupper($chat->type) }}</div>
                    @endif
                </td>
                <td class="right aligned">
                    <a href="/api/telegram-bot/{{ $token }}/chat/{{ $chat->id }}/delete" class="ui mini red icon button">
                        <i class="delete icon"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td><strong>Name</strong></td>
                <td>
                    @if ($chat->type === 'private')
                        {{ $chat->first_name }} {{ $chat->last_name }}
                        @if ($chat->username)
                            {{ '@' . $chat->username }}
                        @endif
                    @else
                        {{ $chat->title }}
                    @endif
                </td>
            </tr>
            <tr>
                <td><strong>Updates</strong></td>
                <td>
                    <a href="/api/telegram-bot/{{ $token }}?show=updates&id={{ $chat->id }}">
                        {{ $chat->updates()->count() }}
                    </a>
                </td>
            </tr>
            <tr>
                <td><strong>Requests</strong></td>
                <td>
                    <a href="/api/telegram-bot/{{ $token }}?show=requests&id={{ $chat->id }}">
                        {{ $chat->requests()->count() }}
                    </a>
                </td>
            </tr>
            <tr>
                <td><strong>Abilities</strong></td>
                <td>
                    <form action="/api/telegram-bot/{{ $token }}/chat/{{ $chat->id }}/abilities" method="POST">
                        <select name="abilities[]" multiple="" class="ui fluid dropdown">
                            @php
                                $chat_abilities = $chat->abilities->map(function ($ability) {
                                    return $ability->name;
                                })->all();
                            @endphp

                            @foreach ($abilities as $ability)
                                <option value="{{ $ability->id }}" {{ in_array($ability->name, $chat_abilities) ? 'selected' : '' }}>
                                    {{ $ability->name }}
                                </option>
                            @endforeach
                        </select>
                        <div style="margin-top: 10px">
                            <button class="ui mini primary button" type="submit">UPDATE</button>
                        </div>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</div>