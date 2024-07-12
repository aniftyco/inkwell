@if ($paginator->hasPages())
  <nav
    class="flex justify-between border-t-2 py-10"
    role="navigation"
    aria-label="Pagination Navigation"
  >
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
      <span
        class="cursor-default items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-500"
      >
        {!! __('pagination.previous') !!}
      </span>
    @else
      <a
        class="items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-zinc-100 focus:outline-none"
        href="{{ $paginator->previousPageUrl() }}"
        rel="prev"
      >
        {!! __('pagination.previous') !!}
      </a>
    @endif

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
      <a
        class="items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-zinc-100 focus:outline-none"
        href="{{ $paginator->nextPageUrl() }}"
        rel="next"
      >
        {!! __('pagination.next') !!}
      </a>
    @else
      <span
        class="cursor-default items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-500"
      >
        {!! __('pagination.next') !!}
      </span>
    @endif
  </nav>
@endif
