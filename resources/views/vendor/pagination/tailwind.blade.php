@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center space-x-2 mt-6">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 bg-gray-200 text-gray-500 rounded-lg cursor-not-allowed select-none">
                Prev
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" 
                class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 transition duration-200">
                Prev
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-2 text-gray-500">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-4 py-2 bg-blue-600 text-white font-semibold border border-blue-600 rounded-lg shadow-md">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" 
                            class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" 
                class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 transition duration-200">
                Next
            </a>
        @else
            <span class="px-4 py-2 bg-gray-200 text-gray-500 rounded-lg cursor-not-allowed select-none">
                Next
            </span>
        @endif
    </nav>
@endif
