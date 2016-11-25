
<div style="margin-top: 40px">

    <table class="ui very basic celled table">
        <tbody>
            <tr>
                <td style="width: 200px"><strong>#{{ $request->id }}</strong></td>
                <td class="right aligned">
                    <a href="/api/telegram-bot/{{ $token }}/request/{{ $request->id }}/delete?id={{ $chat->id }}" class="ui mini red icon button">
                        <i class="delete icon"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="top aligned"><strong>Request Type</strong></td>
                <td>
                    <div class="ui yellow horizontal label">{{ strtoupper($request->type) }}</div>
                </td>
            </tr>
            <tr>
                <td class="top aligned"><strong>Request URL</strong></td>
                <td>
                    <pre class="app-request-content"><code>{{ $request->url }}</code></pre>
                </td>
            </tr>
            <tr>
                <td class="top aligned"><strong>Fields</strong></td>
                <td>
                    <pre class="app-request-content"><code class="json">{{ json_encode(json_decode($request->fields, true), JSON_PRETTY_PRINT) }}</code></pre>
                </td>
            </tr>
            <tr>
                <td class="top aligned"><strong>Response</strong></td>
                <td>
                    <pre class="app-request-content"><code class="json">{{ json_encode(json_decode($request->response, true), JSON_PRETTY_PRINT) }}</code></pre>
                </td>
            </tr>
        </tbody>
    </table>
</div>