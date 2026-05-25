@if ($paginator->hasPages())
    @php
        $query = Request::query();
    @endphp
    
    <ul style="list-style: none; padding: 0; margin: 0; display: flex; justify-content: center; align-items: center; gap: 8px; flex-wrap: wrap;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li style="display: inline-flex;">
                <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0 12px; border-radius: 8px; border: 1px solid var(--border); background: var(--surface-strong); color: var(--dark); font-weight: 600; opacity: 0.5; cursor: not-allowed;">
                    ← Sebelumnya
                </span>
            </li>
        @else
            <li style="display: inline-flex;">
                <a href="{{ $paginator->previousPageUrl() }}" style="display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0 12px; border-radius: 8px; border: 1px solid var(--border); background: var(--surface-strong); color: var(--dark); text-decoration: none; font-weight: 600; font-size: 0.9em; transition: all 0.2s ease;" onmouseover="this.style.background='linear-gradient(135deg, #789DBC 0%, #C9E9D2 100%)'; this.style.color='white'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(120, 157, 188, 0.3)';" onmouseout="this.style.background='var(--surface-strong)'; this.style.color='var(--dark)'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    ← Sebelumnya
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li style="display: inline-flex;">
                    <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0 12px; border-radius: 8px; border: 1px solid var(--border); background: var(--surface-strong); color: var(--dark); font-weight: 600;">
                        {{ $element }}
                    </span>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li style="display: inline-flex;">
                            <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0 12px; border-radius: 8px; border: 1px solid #789DBC; background: linear-gradient(135deg, #789DBC 0%, #C9E9D2 100%); color: white; font-weight: 600; font-size: 0.9em; box-shadow: 0 4px 12px rgba(120, 157, 188, 0.3);">
                                {{ $page }}
                            </span>
                        </li>
                    @else
                        <li style="display: inline-flex;">
                            <a href="{{ $url }}" style="display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0 12px; border-radius: 8px; border: 1px solid var(--border); background: var(--surface-strong); color: var(--dark); text-decoration: none; font-weight: 600; font-size: 0.9em; transition: all 0.2s ease;" onmouseover="this.style.background='linear-gradient(135deg, #789DBC 0%, #C9E9D2 100%)'; this.style.color='white'; this.style.borderColor='#789DBC'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(120, 157, 188, 0.3)';" onmouseout="this.style.background='var(--surface-strong)'; this.style.color='var(--dark)'; this.style.borderColor='var(--border)'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li style="display: inline-flex;">
                <a href="{{ $paginator->nextPageUrl() }}" style="display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0 12px; border-radius: 8px; border: 1px solid var(--border); background: var(--surface-strong); color: var(--dark); text-decoration: none; font-weight: 600; font-size: 0.9em; transition: all 0.2s ease;" onmouseover="this.style.background='linear-gradient(135deg, #789DBC 0%, #C9E9D2 100%)'; this.style.color='white'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(120, 157, 188, 0.3)';" onmouseout="this.style.background='var(--surface-strong)'; this.style.color='var(--dark)'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    Selanjutnya →
                </a>
            </li>
        @else
            <li style="display: inline-flex;">
                <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0 12px; border-radius: 8px; border: 1px solid var(--border); background: var(--surface-strong); color: var(--dark); font-weight: 600; opacity: 0.5; cursor: not-allowed;">
                    Selanjutnya →
                </span>
            </li>
        @endif
    </ul>
@endif
