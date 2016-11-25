

<div style="margin-top: 40px; text-align: center;">

    <div class="ui mini pagination menu">

        @if ($chats->currentPage() > 1)
            <a href="{{ $chats->previousPageUrl() }}" class="item">
                Previous Page
            </a>
        @endif

        <div class="disabled item">
            {{ $chats->currentPage() }}
        </div>

        @if ($chats->currentPage() < $chats->lastPage())
            <a href="{{ $chats->nextPageUrl() }}" class="item">
                Next Page
            </a>
        @endif
    </div>
</div>