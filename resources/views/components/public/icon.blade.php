@props(['name', 'class' => 'h-4 w-4'])

@php
    $name = (string) $name;
@endphp

@if ($name === 'arrow-right')
    <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 20 20" fill="none" aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg">
        <path d="M4 10H15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
        <path d="M11.5 6.5L15 10l-3.5 3.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
            stroke-linejoin="round" />
    </svg>
@elseif ($name === 'calendar')
    <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 20 20" fill="none" aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg">
        <path d="M6 3.8v2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
        <path d="M14 3.8v2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
        <path d="M4.5 7.2h11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
        <path d="M5.5 5.2h9a2 2 0 0 1 2 2v7.3a2 2 0 0 1-2 2h-9a2 2 0 0 1-2-2V7.2a2 2 0 0 1 2-2z" stroke="currentColor"
            stroke-width="1.6" stroke-linejoin="round" />
    </svg>
@elseif ($name === 'user')
    <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 20 20" fill="none" aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg">
        <path d="M10 10.2a3.2 3.2 0 1 0 0-6.4 3.2 3.2 0 0 0 0 6.4z" stroke="currentColor" stroke-width="1.6" />
        <path d="M4.6 16.4c.9-2.2 3-3.4 5.4-3.4s4.5 1.2 5.4 3.4" stroke="currentColor" stroke-width="1.6"
            stroke-linecap="round" />
    </svg>
@elseif ($name === 'mail')
    <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 20 20" fill="none" aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg">
        <path d="M4.5 6.5h11v7a2 2 0 0 1-2 2h-7a2 2 0 0 1-2-2v-7z" stroke="currentColor" stroke-width="1.6"
            stroke-linejoin="round" />
        <path d="M4.9 6.9L10 10.7l5.1-3.8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
            stroke-linejoin="round" />
    </svg>
@elseif ($name === 'phone')
    <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 20 20" fill="none" aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg">
        <path
            d="M7.3 4.7l1.2 2.1a1.2 1.2 0 0 1-.2 1.5l-1 1a9.1 9.1 0 0 0 3.4 3.4l1-1a1.2 1.2 0 0 1 1.5-.2l2.1 1.2a1.2 1.2 0 0 1 .6 1.3c-.2 1-1 1.7-2 1.8-6.7.6-12.4-5.1-11.8-11.8.1-1 .8-1.8 1.8-2a1.2 1.2 0 0 1 1.3.6z"
            stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" />
    </svg>
@elseif ($name === 'map-pin')
    <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 20 20" fill="none" aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg">
        <path d="M10 17s5-4.2 5-9a5 5 0 1 0-10 0c0 4.8 5 9 5 9z" stroke="currentColor" stroke-width="1.6"
            stroke-linejoin="round" />
        <path d="M10 10.2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" stroke="currentColor" stroke-width="1.6" />
    </svg>
@endif
