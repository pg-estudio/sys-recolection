<x-dialog-modal wire:model="showEditModal">
    <x-slot name="title">
        {{ __('Editar Solicitud de Recolección') }}
    </x-slot>

    <x-slot name="content">
        <div class="space-y-4">
            <div>
                <flux:label for="tipo_residuo_id" value="{{ __('Tipo de Residuo') }}" />
                <flux:select id="tipo_residuo_id" wire:model.defer="form.tipo_residuo_id">
                    <option value="">Seleccione un tipo</option>
                    @foreach ($tiposResiduos as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                    @endforeach
                </flux:select>
                <x-input-error for="form.tipo_residuo_id" class="mt-2" />
            </div>

            <div>
                <flux:label for="descripcion" value="{{ __('Descripción') }}" />
                <flux:textarea id="descripcion" wire:model.defer="form.descripcion" rows="3" />
                <x-input-error for="form.descripcion" class="mt-2" />
            </div>

            <div>
                <flux:label for="direccion" value="{{ __('Dirección') }}" />
                <flux:textarea id="direccion" wire:model.defer="form.direccion" rows="2" />
                <x-input-error for="form.direccion" class="mt-2" />
            </div>

            <div>
                <flux:label for="peso_aproximado" value="{{ __('Peso Aproximado (kg)') }}" />
                <flux:input id="peso_aproximado" type="number" wire:model.defer="form.peso_aproximado" />
                <x-input-error for="form.peso_aproximado" class="mt-2" />
            </div>

            <div>
                <flux:label for="fecha_preferida" value="{{ __('Fecha Preferida') }}" />
                <flux:input id="fecha_preferida" type="date" wire:model.defer="form.fecha_preferida" />
                <x-input-error for="form.fecha_preferida" class="mt-2" />
            </div>

            <div>
                <flux:label for="telefono_contacto" value="{{ __('Teléfono de Contacto') }}" />
                <flux:input id="telefono_contacto" type="tel" wire:model.defer="form.telefono_contacto" />
                <x-input-error for="form.telefono_contacto" class="mt-2" />
            </div>

            <div>
                <flux:label for="notas_adicionales" value="{{ __('Notas Adicionales') }}" />
                <flux:textarea id="notas_adicionales" wire:model.defer="form.notas_adicionales" rows="2" />
                <x-input-error for="form.notas_adicionales" class="mt-2" />
            </div>

            @if (auth()->user()->isAdmin())
                <div>
                    <flux:label for="estado" value="{{ __('Estado') }}" />
                    <flux:select id="estado" wire:model.defer="form.estado">
                        <option value="pendiente">Pendiente</option>
                        <option value="confirmada">Confirmada</option>
                        <option value="recolectada">Recolectada</option>
                        <option value="cancelada">Cancelada</option>
                    </flux:select>
                    <x-input-error for="form.estado" class="mt-2" />
                </div>

                <div>
                    <flux:label for="peso" value="{{ __('Peso Real (kg)') }}" />
                    <flux:input id="peso" type="number" wire:model.defer="form.peso" />
                    <x-input-error for="form.peso" class="mt-2" />
                </div>

                <div>
                    <flux:label for="puntos_ganados" value="{{ __('Puntos a Otorgar') }}" />
                    <flux:input id="puntos_ganados" type="number" wire:model.defer="form.puntos_ganados" />
                    <x-input-error for="form.puntos_ganados" class="mt-2" />
                </div>
            @endif
        </div>
    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-end gap-4">
            <flux:button wire:click="$set('showEditModal', false)" variant="outline">
                {{ __('Cancelar') }}
            </flux:button>

            <flux:button wire:click="update" variant="primary">
                {{ __('Guardar Cambios') }}
            </flux:button>
        </div>
    </x-slot>
</x-dialog-modal>