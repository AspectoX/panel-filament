@props([
    'navigation',
])

@php
    use Filament\Support\Enums\MaxWidth;

    $navigation = filament()->getNavigation();
@endphp

<x-filament-panels::layout.base :livewire="$livewire">
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

                    {{-- filament()->isGlobalSearchEnabled() --}}
                    @if (true)
                         @livewire(Filament\Livewire\GlobalSearch::class)
                    @endif

                    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::GLOBAL_SEARCH_AFTER) }}

                    @if (filament()->auth()->check())
                        {{--  filament()->hasDatabaseNotifications() --}}
                        @if (true)
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

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::CONTENT_START, scopes: $livewire->getRenderHookScopes()) }}
        <main
            @class([
                'fi-main w-full',
            ])
        >

            {{ $slot }}

        </main>
        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::CONTENT_END, scopes: $livewire->getRenderHookScopes()) }}

        @if (filament()->hasNavigation())
            <div
                x-cloak
                x-data="{}"
                x-on:click="$store.sidebar.close()"
                x-show="$store.sidebar.isOpen"
                x-transition.opacity.300ms
                class="fixed inset-0 z-30 transition duration-500 fi-sidebar-close-overlay bg-gray-950/50 dark:bg-gray-950/75 lg:hidden"
            ></div>

            <x-filament-panels::sidebar
                :navigation="$navigation"
                class="fi-main-sidebar"
            />

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    setTimeout(() => {
                        let activeSidebarItem = document.querySelector(
                            '.fi-main-sidebar .fi-sidebar-item.fi-active',
                        )

                        if (
                            !activeSidebarItem ||
                            activeSidebarItem.offsetParent === null
                        ) {
                            activeSidebarItem = document.querySelector(
                                '.fi-main-sidebar .fi-sidebar-group.fi-active',
                            )
                        }

                        if (
                            !activeSidebarItem ||
                            activeSidebarItem.offsetParent === null
                        ) {
                            return
                        }

                        const sidebarWrapper = document.querySelector(
                            '.fi-main-sidebar .fi-sidebar-nav',
                        )

                        if (!sidebarWrapper) {
                            return
                        }

                        sidebarWrapper.scrollTo(
                            0,
                            activeSidebarItem.offsetTop -
                                window.innerHeight / 2,
                        )
                    }, 10)
                })
            </script>
        @endif
	</div>
</x-filament-panels::layout.base>
