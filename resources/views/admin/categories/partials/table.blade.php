<table class="product_listing_table" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>CATEGORY</th>
                <th style="width: 7%;">STATUS</th>
                <th style="width: 7%;">ACTION</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>
                    <a href="{{ route('admin.products.index', ['id' => $category->id]) }}" style="text-decoration: none;color: #212529;">
                        {{ $category->category_name }}
                    </a>
                </td>
                <td>
                    <span>
                        <label class="switch">
                            <input type="checkbox"
                                   id="checkbox_{{ $category->id }}"
                                   class="category-status-toggle"
                                   data-id="{{ $category->id }}"
                                   {{ $category->status == '1' ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn-rfq btn-sm btn-rfq-secondary edit_page mr-1">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @php
        $paginator = $categories;
        $onEachSide = 2;
        $window = $onEachSide * 2;
    @endphp

    @if ($paginator->total() > 0)
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
            <div class="mb-2">
                <small>
                    Showing
                    {{ $paginator->firstItem() ?? 0 }}
                    to
                    {{ $paginator->lastItem() ?? 0 }}
                    of
                    {{ $paginator->total() }}
                    entries
                </small>
            </div>
            <div>
                <ul class="pagination mb-0">
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
                        </li>
                    @endif

                    @php
                        $currentPage = $paginator->currentPage();
                        $lastPage = $paginator->lastPage();

                        $startPage = max($currentPage - $onEachSide, 1);
                        $endPage = min($currentPage + $onEachSide, $lastPage);

                        if ($currentPage <= $onEachSide) {
                            $endPage = min($window + 1, $lastPage);
                        }
                        if ($currentPage >= $lastPage - $onEachSide) {
                            $startPage = max($lastPage - $window, 1);
                        }
                    @endphp

                    @if ($startPage > 1)
                        <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
                        @if ($startPage > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    @for ($page = $startPage; $page <= $endPage; $page++)
                        @if ($page == $currentPage)
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
                        @endif
                    @endfor

                    @if ($endPage < $lastPage)
                        @if ($endPage < $lastPage - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item"><a class="page-link" href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a></li>
                    @endif

                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                    @endif
                </ul>
            </div>
        </div>
    @endif
</div>
