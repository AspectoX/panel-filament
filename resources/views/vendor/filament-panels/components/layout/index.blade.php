@props([
    'navigation',
])

@php
    use Filament\Support\Enums\MaxWidth;

    $navigation = filament()->getNavigation();
@endphp

<x-filament-panels::layout.base :livewire="$livewire">
    {{-- The sidebar is after the page content in the markup to fix issues with page content overlapping dropdown content from the sidebar. --}}

    <div class="wrapper">
        <header class="ax-header">
            <div class="ax-header-left separador-r">
                @if ($homeUrl = filament()->getHomeUrl())
                    <a {{ \Filament\Support\generate_href_html($homeUrl) }}>
                        <x-filament-panels::logo />
                    </a>
                @else
                    <x-filament-panels::logo />
                @endif
            </div>
            <!-- <div class="ax-header-medium separador-r"></div> -->
            <div class="ax-header-right separador-l">
                <div
                    x-persist="topbar.end"
                    class="flex items-center ms-auto gap-x-4"
                >
                    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::GLOBAL_SEARCH_BEFORE) }}

                    @if (true) {{-- filament()->isGlobalSearchEnabled() --}}
                        @livewire(Filament\Livewire\GlobalSearch::class)
                    @endif

                    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::GLOBAL_SEARCH_AFTER) }}

                    @if (filament()->auth()->check())
                        @if (true) {{-- filament()->hasDatabaseNotifications() --}}
                            @livewire(Filament\Livewire\DatabaseNotifications::class, [
                                'lazy' => filament()->hasLazyLoadedDatabaseNotifications(),
                            ])
                        @endif

                        <x-filament-panels::user-menu />
                    @endif

                    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::TOPBAR_END) }}
                </div>
            </div>
        </header>

        @if (filament()->hasTopbar())
            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::TOPBAR_BEFORE, scopes: $livewire->getRenderHookScopes()) }}

            <x-filament-panels::topbar :navigation="$navigation" />

            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::TOPBAR_AFTER, scopes: $livewire->getRenderHookScopes()) }}
        @endif
            <main
                @class([
                    'fi-main w-full',
                ])
            >
                {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::CONTENT_START, scopes: $livewire->getRenderHookScopes()) }}

                {{ $slot }}

                {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::CONTENT_END, scopes: $livewire->getRenderHookScopes()) }}
            </main>
    </div>
</x-filament-panels::layout.base>
