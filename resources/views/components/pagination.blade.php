@php
    $totalItems = $items->total();
    $totalPages = $items->lastPage();
    $isFirstPage = $items->onFirstPage();
    $isLastPage = $items->onLastPage();
    $prevPage = $items->previousPageUrl();
    $currentPage = $items->currentPage();
    $nextPage = $items->nextPageUrl();
@endphp

<nav aria-label="Page navigation" class="d-flex flex-row justify-content-between">
    <i class="mt-2">Total: {{$totalItems}} items</i>
    <ul class="pagination justify-content-end">
      <li class="page-item {{$isFirstPage ? 'disabled' : ''}}">
        <a class="page-link" href="{{$prevPage}}" tabindex="-1">Previous</a>
      </li>
      @for ($i = 1; $i <= $totalPages; $i++)
        <li class="page-item {{ $currentPage == $i ? 'disabled' : ''}}">
            <a class="page-link" href="/todo?page={{$i}}">{{$i}}</a>
        </li>
      @endfor
      <li class="page-item {{$isLastPage ? 'disabled' : ''}}">
        <a class="page-link" href="{{$nextPage}}">Next</a>
      </li>
    </ul>
</nav>