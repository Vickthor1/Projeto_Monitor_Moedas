@props(['name'])

@switch($name)
    @case('grid')
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <rect x="2" y="2" width="6" height="6" rx="1.5" fill="currentColor" />
            <rect x="12" y="2" width="6" height="6" rx="1.5" fill="currentColor" />
            <rect x="2" y="12" width="6" height="6" rx="1.5" fill="currentColor" />
            <rect x="12" y="12" width="6" height="6" rx="1.5" fill="currentColor" />
        </svg>
        @break

    @case('arrows')
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M4.5 11.5L3 10l1.5-1.5V8h5v1H5.5l1 1-1 1H4.5Zm11-3h-5V7h5v1.5L17 9l-1.5 1.5V11h-5V10h5v-1.5ZM7.5 16.5V14h5v2.5L15 16l-1.5-1.5V14h-5v1.5L7.5 16.5Z" fill="currentColor" />
        </svg>
        @break

    @case('clock')
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.7" />
            <path d="M10 5.5V10.5L13.5 12.75" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
        </svg>
        @break

    @case('user')
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M10 11c2.485 0 4.5-1.567 4.5-3.5S12.485 4 10 4 5.5 5.567 5.5 7.5 7.515 11 10 11Z" fill="currentColor" />
            <path d="M3.5 16.5c0-2.485 2.685-4.5 6.5-4.5s6.5 2.015 6.5 4.5V17H3.5v-.5Z" fill="currentColor" />
        </svg>
        @break

    @case('logout')
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M8 4h5a1 1 0 0 1 1 1v2h-1V5H8v10h5v-2h1v2a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1Z" fill="currentColor" />
            <path d="M11.293 7.293 9 9.586l2.293 2.293.707-.707L10.414 10l1.586-1.586-.707-.707Z" fill="currentColor" />
        </svg>
        @break

    @default
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.7" />
        </svg>
@endswitch
