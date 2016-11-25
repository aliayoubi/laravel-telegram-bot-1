
<div style="margin-top: 40px; text-align: center;">

    <div class="ui mini pagination menu">

        @if ($updates->currentPage() > 1)
            <a href="{{ $updates->previousPageUrl() }}" class="item">
                Previous Page
            </a>
        @endif

        <div class="disabled item">
            {{ $updates->currentPage() }}
        </div>

        @if ($updates->currentPage() < $updates->lastPage())
            <a href="{{ $updates->nextPageUrl() }}" class="item">
                Next Page
            </a>
        @endif
    </div>
</div>