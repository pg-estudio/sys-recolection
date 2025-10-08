@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'base',
    'disabled' => false
])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-200';

$variants = [
    'primary' => 'bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500 disabled:bg-primary-300',
    'secondary' => 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 focus:ring-primary-500 disabled:bg-gray-100 disabled:text-gray-400',
    'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500 disabled:bg-red-300',
    'success' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500 disabled:bg-green-300',
    'warning' => 'bg-yellow-600 text-white hover:bg-yellow-700 focus:ring-yellow-500 disabled:bg-yellow-300',
    'info' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500 disabled:bg-blue-300',
    'filled' => 'bg-gray-900 text-white hover:bg-gray-800 focus:ring-gray-500 disabled:bg-gray-300',
];

$sizes = [
    'xs' => 'px-2.5 py-1.5 text-xs',
    'sm' => 'px-3 py-2 text-sm leading-4',
    'base' => 'px-4 py-2 text-sm',
    'lg' => 'px-4 py-2 text-base',
    'xl' => 'px-6 py-3 text-base'
];

$classes = $baseClasses . ' ' . 
          ($variants[$variant] ?? $variants['primary']) . ' ' . 
          ($sizes[$size] ?? $sizes['base']);
@endphp

<button 
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $classes]) }}
    @if($disabled) disabled @endif
>
    {{ $slot }}
</button>