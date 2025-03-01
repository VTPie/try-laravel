@php
    $priorityList = config("todo.priority");
    $statusList = config("todo.status");
    $currentRequest = request();
@endphp
<div class="accordion-item my-3">
    <h2 class="accordion-header">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        Filter
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <div class="row">
                <div class="col-7">
                    <div class="row mt-3">
                        <div class="col-2">
                            <p class="mt-2">Priority:</p>
                        </div>
                        <div class="col-10">
                            @foreach ($priorityList as $index => $value)
                                @if ($priorityCounter[$index]->counter ?? false)
                                    <a type="button"
                                        class="btn btn-outline-primary w-25 {{ $currentRequest->filled('priority') && $currentRequest->input('priority') == $index ? 'active' : ''}}"
                                        href="{{ $currentRequest->fullUrlWithQuery(['priority' => $index, 'page' => 1]) }}">
                                        {{$value}}
                                        <span class="badge bg-danger rounded-circle">{{$priorityCounter[$index]->counter}}</span>
                                    </a>
                                @else
                                    <a type="button" class="btn btn-outline-primary w-25 disabled">
                                        {{$value}}
                                        <span class="badge bg-danger rounded-circle">0</span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <p class="mt-2">Status:</p>
                        </div>
                        <div class="col-10">
                            @foreach ($statusList as $index => $value)
                                @if ($statusCounter[$index]->counter ?? false)
                                    <a type="button"
                                        class="btn btn-outline-primary w-25 {{ $currentRequest->filled('status') && $currentRequest->input('status') == $index ? 'active' : ''}}"
                                        href="{{ $currentRequest->fullUrlWithQuery(['status' => $index, 'page' => 1]) }}">
                                        {{$value}}
                                        <span class="badge bg-danger rounded-circle">{{$statusCounter[$index]->counter}}</span>
                                    </a>
                                @else
                                    <a type="button" class="btn btn-outline-primary w-25 disabled">
                                        {{$value}}
                                        <span class="badge bg-danger rounded-circle">0</span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div>
                        <input type="text" class="form-control mt-3" id="search-box" placeholder="Type something to search by name ..." value={{$searchValue}}>
                        <button type="button" class="btn btn-primary mt-2 mx-auto d-block" id="btn-search">Search</button>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-2">
                    <a href="{{ route('todo.index') }}" class="btn btn-secondary mx-auto d-block">Clear Filter</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $btnSearch = document.getElementById("btn-search");

    $btnSearch.addEventListener("click", function() {
        let searchValue = document.getElementById("search-box").value.trim();
        let currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set("searchBy", searchValue);
        window.location.href = currentUrl.toString();
    });
</script>