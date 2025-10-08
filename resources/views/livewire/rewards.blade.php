<div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Encabezado con Puntos -->
        <div class="mb-6 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-semibold">{{ __('Recompensas') }}</h2>
                    <p class="text-purple-100 mt-1">{{ __('Canjea tus puntos por increíbles recompensas') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-purple-100">{{ __('Tus puntos') }}</p>
                    <p class="text-3xl font-bold">{{ number_format($puntos) }}</p>
                </div>
            </div>
        </div>

        <!-- Grid de Recompensas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse ($recompensas as $recompensa)
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $recompensa->nombre }}
                            </h3>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $puntos >= $recompensa->puntos_requeridos ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                {{ number_format($recompensa->puntos_requeridos) }} pts
                            </span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ $recompensa->descripcion }}</p>
                        <div class="mt-4">
                            <flux:button wire:click="canjear({{ $recompensa->id }})"
                                variant="{{ $puntos >= $recompensa->puntos_requeridos ? 'primary' : 'secondary' }}"
                                class="w-full" :disabled="$puntos < $recompensa->puntos_requeridos">
                                {{ $puntos >= $recompensa->puntos_requeridos ? __('Canjear') : __('Puntos insuficientes') }}
                            </flux:button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-gray-500 dark:text-gray-400">
                    {{ __('No hay recompensas disponibles en este momento.') }}
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $recompensas->links() }}
        </div>

        <!-- Historial de Canjes -->
        @if ($canjes->isNotEmpty())
            <div class="mt-8">
                <h3 class="text-lg font-semibold mb-4">{{ __('Últimos Canjes') }}</h3>
                <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm">
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($canjes as $canje)
                            <li class="p-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            {{ $canje->recompensa->nombre }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $canje->fecha_canje->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $canje->estado === 'completado'
                                        ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'
                                        : ($canje->estado === 'pendiente'
                                            ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100'
                                            : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100') }}">
                                        {{ ucfirst($canje->estado) }}
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal de Confirmación de Canje -->
    <x-dialog-modal wire:model="showCanjearModal">
        <x-slot name="title">
            {{ __('Confirmar Canje de Recompensa') }}
        </x-slot>

        <x-slot name="content">
            @if ($selectedRecompensa)
                <div class="space-y-4">
                    <p>{{ __('¿Estás seguro de que deseas canjear esta recompensa?') }}</p>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="font-medium">{{ $selectedRecompensa->nombre }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                            {{ $selectedRecompensa->descripcion }}</div>
                        <div class="mt-2 text-sm">
                            <span class="font-medium">{{ __('Costo:') }}</span>
                            <span
                                class="text-purple-600 dark:text-purple-400">{{ number_format($selectedRecompensa->puntos_requeridos) }}
                                puntos</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('Puntos actuales:') }}
                            {{ number_format($puntos) }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('Puntos después del canje:') }}
                            {{ number_format($puntos - $selectedRecompensa->puntos_requeridos) }}</div>
                    </div>
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-4">
                <flux:button wire:click="$set('showCanjearModal', false)" variant="secondary">
                    {{ __('Cancelar') }}
                </flux:button>

                <flux:button wire:click="confirmarCanje" variant="primary">
                    {{ __('Confirmar Canje') }}
                </flux:button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
