
<div style="margin-top: 40px; text-align: center;">

    <div class="ui mini pagination menu">

        @if ($requests->currentPage() > 1)
            <a href="{{ $requests->previousPageUrl() }}" class="item">
                Previous Page
            </a>
        @endif

        <div class="disabled item">
            {{ $requests->currentPage() }}
        </div>

        @if ($requests->currentPage() < $requests->lastPage())
            <a href="{{ $requests->nextPageUrl() }}" class="item">
                Next Page
            </a>
        @endif
    </div>
</div>