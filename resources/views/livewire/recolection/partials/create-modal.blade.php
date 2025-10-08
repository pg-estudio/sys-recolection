<x-dialog-modal wire:model="showCreateModal">
    <x-slot name="title">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-medium">
                {{ __('Nueva Solicitud de Recolección') }}
            </h2>
            <flux:button wire:click="$set('showCreateModal', false)" variant="ghost" size="sm" icon="x-mark">
                <span class="sr-only">{{ __('Cerrar') }}</span>
            </flux:button>
        </div>
    </x-slot>

    <x-slot name="content">
        <div class="space-y-6">
            <div class="grid grid-cols-1 gap-6">
                <!-- Tipo de Residuo -->
                <div>
                    <flux:label for="tipo_residuo_id" value="{{ __('Tipo de Residuo') }}" />
                    <flux:select id="tipo_residuo_id" wire:model.defer="form.tipo_residuo_id" class="mt-1 w-full">
                        <option value="">Seleccione un tipo</option>
                        @foreach ($tiposResiduos as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </flux:select>
                    <x-input-error for="form.tipo_residuo_id" class="mt-2" />
                </div>

                <!-- Descripción -->
                <div>
                    <flux:label for="descripcion" value="{{ __('Descripción del Residuo') }}" />
                    <flux:textarea id="descripcion" wire:model.defer="form.descripcion" rows="3"
                        placeholder="Describa el tipo y cantidad aproximada de residuos" />
                    <x-input-error for="form.descripcion" class="mt-2" />
                </div>

                <!-- Dirección -->
                <div>
                    <flux:label for="direccion" value="{{ __('Dirección de Recolección') }}" />
                    <flux:textarea id="direccion" wire:model.defer="form.direccion" rows="2"
                        placeholder="Dirección completa donde se recogerán los residuos" />
                    <x-input-error for="form.direccion" class="mt-2" />
                </div>

                <!-- Peso Aproximado -->
                <div>
                    <flux:label for="peso_aproximado" value="{{ __('Peso Aproximado (kg)') }}" />
                    <flux:input id="peso_aproximado" type="number" wire:model.defer="form.peso_aproximado"
                        placeholder="Ej: 10" />
                    <x-input-error for="form.peso_aproximado" class="mt-2" />
                </div>

                <!-- Fecha Preferida -->
                <div>
                    <flux:label for="fecha_preferida" value="{{ __('Fecha Preferida de Recolección') }}" />
                    <flux:input id="fecha_preferida" type="date" wire:model.defer="form.fecha_preferida" />
                    <x-input-error for="form.fecha_preferida" class="mt-2" />
                </div>

                <!-- Teléfono de Contacto -->
                <div>
                    <flux:label for="telefono_contacto" value="{{ __('Teléfono de Contacto') }}" />
                    <flux:input id="telefono_contacto" type="tel" wire:model.defer="form.telefono_contacto"
                        placeholder="300 123 4567" />
                    <x-input-error for="form.telefono_contacto" class="mt-2" />
                </div>

                <!-- Notas adicionales -->
                <div>
                    <flux:label for="notas_adicionales" value="{{ __('Notas adicionales') }}" />
                    <flux:textarea id="notas_adicionales" wire:model.defer="form.notas_adicionales" rows="2"
                        placeholder="Instrucciones especiales, horario preferido, etc." />
                    <x-input-error for="form.notas_adicionales" class="mt-2" />
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-end gap-4">
            <flux:button wire:click="$set('showCreateModal', false)" variant="outline">
                {{ __('Cancelar') }}
            </flux:button>

            <flux:button wire:click="create" variant="primary">
                {{ __('Crear Solicitud') }}
            </flux:button>
        </div>
    </x-slot>
</x-dialog-modal>