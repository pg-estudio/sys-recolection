<div class="relative">
    @if(isset($icon))
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <x-heroicon-o-{{ $icon }} class="h-5 w-5 text-gray-400" />
        </div>
    @endif
    
    <input 
        {{ $attributes->merge([
            'type' => 'text',
            'class' => 'block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500 dark:disabled:bg-gray-800 dark:disabled:text-gray-400 sm:text-sm' . 
            ($icon ? ' pl-10' : '')
        ]) }}
    />
</div>