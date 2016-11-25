
<div style="margin-top: 40px">

    <table class="ui very basic celled table">
        <tbody>
            <tr>
                <td style="width: 200px"><strong>#{{ $update->id }}</strong></td>
                <td class="right aligned">
                    <a href="/api/telegram-bot/{{ $token }}/update/{{ $update->id }}/delete?id={{ $chat->id }}" class="ui mini red icon button">
                        <i class="delete icon"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="top aligned"><strong>Content of the Update</strong></td>
                <td>
                    <pre class="app-update-content"><code class="json">{{ $update->content->toJson(JSON_PRETTY_PRINT) }}</code></pre>
                </td>
            </tr>
        </tbody>
    </table>
</div>