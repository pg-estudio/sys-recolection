<div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">{{ __('Rutas de Recolección') }}</h2>

            <flux:button wire:click="$set('showCreateModal', true)" variant="primary">
                {{ __('Nueva Ruta') }}
            </flux:button>
        </div>

        <!-- Filtros -->
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl p-4 flex gap-4 flex-wrap">
            <div class="flex-1 min-w-[200px]">
                <flux:input wire:model.live="search" placeholder="Buscar rutas..." type="search"
                    icon="magnifying-glass" />
            </div>

            <div class="flex gap-4">
                <flux:select wire:model.live="localidad">
                    <option value="">Todas las localidades</option>
                    @foreach ($localidades as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->nombre }}</option>
                    @endforeach
                </flux:select>
            </div>
        </div>

        <!-- Lista de Rutas -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Localidad
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Día
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Turno
                            </th>
                            @if (auth()->user()->isAdmin())
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Empresa
                                </th>
                            @endif
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800">
                        @forelse ($rutas as $ruta)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $ruta->localidad->nombre }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $ruta->localidad->codigo_postal }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $ruta->dia_recoleccion }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $ruta->turno }}
                                </td>
                                @if (auth()->user()->isAdmin())
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $ruta->empresa->nombre }}
                                        </div>
                                    </td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <flux:button wire:click="edit({{ $ruta->id }})" variant="secondary"
                                            size="xs">
                                            Editar
                                        </flux:button>
                                        <flux:button wire:click="delete({{ $ruta->id }})" variant="danger"
                                            size="xs">
                                            Eliminar
                                        </flux:button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-400">
                                    No hay rutas para mostrar
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4">
                {{ $rutas->links() }}
            </div>
        </div>
    </div>

    <!-- Modal de Nueva/Editar Ruta -->
    <x-dialog-modal wire:model="showCreateModal">
        <x-slot name="title">
            {{ __('Nueva Ruta de Recolección') }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <flux:label for="localidad_id" value="{{ __('Localidad') }}" />
                    <flux:select id="localidad_id" wire:model="form.localidad_id" class="mt-1 w-full">
                        <option value="">Seleccione una localidad</option>
                        @foreach ($localidades as $localidad)
                            <option value="{{ $localidad->id }}">{{ $localidad->nombre }}</option>
                        @endforeach
                    </flux:select>
                    <x-input-error for="form.localidad_id" class="mt-2" />
                </div>

                <div>
                    <flux:label for="dia_recoleccion" value="{{ __('Día de Recolección') }}" />
                    <flux:select id="dia_recoleccion" wire:model="form.dia_recoleccion" class="mt-1 w-full">
                        <option value="">Seleccione un día</option>
                        @foreach ($dias as $dia)
                            <option value="{{ $dia }}">{{ $dia }}</option>
                        @endforeach
                    </flux:select>
                    <x-input-error for="form.dia_recoleccion" class="mt-2" />
                </div>

                <div>
                    <flux:label for="turno" value="{{ __('Turno') }}" />
                    <flux:select id="turno" wire:model="form.turno" class="mt-1 w-full">
                        <option value="">Seleccione un turno</option>
                        @foreach ($turnos as $turno)
                            <option value="{{ $turno }}">{{ $turno }}</option>
                        @endforeach
                    </flux:select>
                    <x-input-error for="form.turno" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-4">
                <flux:button wire:click="$set('showCreateModal', false)" variant="secondary">
                    {{ __('Cancelar') }}
                </flux:button>

                <flux:button wire:click="create" variant="primary">
                    {{ __('Guardar Ruta') }}
                </flux:button>
            </div>
        </x-slot>
    </x-dialog-modal>

    <!-- Modal de Editar Ruta -->
    <x-dialog-modal wire:model="showEditModal">
        <x-slot name="title">
            {{ __('Editar Ruta de Recolección') }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <flux:label for="edit_localidad_id" value="{{ __('Localidad') }}" />
                    <flux:select id="edit_localidad_id" wire:model="form.localidad_id" class="mt-1 w-full">
                        <option value="">Seleccione una localidad</option>
                        @foreach ($localidades as $localidad)
                            <option value="{{ $localidad->id }}">{{ $localidad->nombre }}</option>
                        @endforeach
                    </flux:select>
                    <x-input-error for="form.localidad_id" class="mt-2" />
                </div>

                <div>
                    <flux:label for="edit_dia_recoleccion" value="{{ __('Día de Recolección') }}" />
                    <flux:select id="edit_dia_recoleccion" wire:model="form.dia_recoleccion" class="mt-1 w-full">
                        <option value="">Seleccione un día</option>
                        @foreach ($dias as $dia)
                            <option value="{{ $dia }}">{{ $dia }}</option>
                        @endforeach
                    </flux:select>
                    <x-input-error for="form.dia_recoleccion" class="mt-2" />
                </div>

                <div>
                    <flux:label for="edit_turno" value="{{ __('Turno') }}" />
                    <flux:select id="edit_turno" wire:model="form.turno" class="mt-1 w-full">
                        <option value="">Seleccione un turno</option>
                        @foreach ($turnos as $turno)
                            <option value="{{ $turno }}">{{ $turno }}</option>
                        @endforeach
                    </flux:select>
                    <x-input-error for="form.turno" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-4">
                <flux:button wire:click="$set('showEditModal', false)" variant="secondary">
                    {{ __('Cancelar') }}
                </flux:button>

                <flux:button wire:click="update" variant="primary">
                    {{ __('Actualizar Ruta') }}
                </flux:button>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
