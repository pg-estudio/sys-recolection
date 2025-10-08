<x-dialog-modal wire:model="showViewModal">
    <x-slot name="title">
        {{ __('Detalles de la Solicitud') }}
    </x-slot>

    <x-slot name="content">
        @if ($selectedSolicitud)
            <div class="space-y-4">
                <div>
                    <label class="font-medium text-sm">{{ __('Usuario') }}</label>
                    <p class="mt-1">{{ $selectedSolicitud->user->name }}</p>
                </div>
                <div>
                    <label class="font-medium text-sm">{{ __('Tipo de Residuo') }}</label>
                    <p class="mt-1">{{ $selectedSolicitud->tipoResiduo->nombre }}</p>
                </div>
                <div>
                    <label class="font-medium text-sm">{{ __('Descripción') }}</label>
                    <p class="mt-1">{{ $selectedSolicitud->descripcion }}</p>
                </div>
                <div>
                    <label class="font-medium text-sm">{{ __('Dirección') }}</label>
                    <p class="mt-1">{{ $selectedSolicitud->direccion }}</p>
                </div>
                <div>
                    <label class="font-medium text-sm">{{ __('Peso Aproximado') }}</label>
                    <p class="mt-1">{{ $selectedSolicitud->peso_aproximado }} kg</p>
                </div>
                <div>
                    <label class="font-medium text-sm">{{ __('Fecha Preferida') }}</label>
                    <p class="mt-1">{{ $selectedSolicitud->fecha_preferida }}</p>
                </div>
                <div>
                    <label class="font-medium text-sm">{{ __('Teléfono de Contacto') }}</label>
                    <p class="mt-1">{{ $selectedSolicitud->telefono_contacto }}</p>
                </div>
                <div>
                    <label class="font-medium text-sm">{{ __('Notas Adicionales') }}</label>
                    <p class="mt-1">{{ $selectedSolicitud->notas_adicionales ?: 'N/A' }}</p>
                </div>
                <div>
                    <label class="font-medium text-sm">{{ __('Estado') }}</label>
                    <p class="mt-1">{{ ucfirst($selectedSolicitud->estado) }}</p>
                </div>
                @if ($selectedSolicitud->peso)
                    <div>
                        <label class="font-medium text-sm">{{ __('Peso Real') }}</label>
                        <p class="mt-1">{{ $selectedSolicitud->peso }} kg</p>
                    </div>
                @endif
                @if ($selectedSolicitud->puntos_ganados)
                    <div>
                        <label class="font-medium text-sm">{{ __('Puntos Ganados') }}</label>
                        <p class="mt-1">{{ $selectedSolicitud->puntos_ganados }} puntos</p>
                    </div>
                @endif
            </div>
        @endif
    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-end">
            <flux:button wire:click="$set('showViewModal', false)" variant="outline">
                {{ __('Cerrar') }}
            </flux:button>
        </div>
    </x-slot>
</x-dialog-modal>