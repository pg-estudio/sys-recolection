<div class="space-y-6">
    <!-- Encabezado -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold">{{ __('Solicitudes de Recolección') }}</h2>

        @if (auth()->user()->role === 'user')
            <flux:button wire:click="$set('showCreateModal', true)" variant="primary">
                {{ __('Nueva Solicitud') }}
            </flux:button>
        @endif
    </div>

    <!-- Filtros -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 flex gap-4 flex-wrap">
        <div class="flex-1 min-w-[200px]">
            <flux:input wire:model.live="search" placeholder="Buscar solicitudes..." type="search"
                icon="magnifying-glass" />
        </div>

        <div class="flex gap-4">
            <flux:select wire:model.live="estado">
                <option value="">Todos los estados</option>
                <option value="pendiente">Pendientes</option>
                <option value="confirmada">Confirmadas</option>
                <option value="recolectada">Recolectadas</option>
                <option value="cancelada">Canceladas</option>
            </flux:select>

            @if (auth()->user()->isAdmin())
                <flux:select wire:model.live="tipo_residuo">
                    <option value="">Todos los tipos</option>
                    @foreach ($tiposResiduos as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                    @endforeach
                </flux:select>
            @endif
        </div>
    </div>

    <!-- Tabla de Solicitudes -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'company')
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Usuario</th>
                        @endif
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipo Residuo</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha</th>
                        @if (Auth::user()->role === 'admin')
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Peso</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Puntos</th>
                        @endif
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($solicitudes as $solicitud)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $solicitud->id }}</td>
                            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'company')
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $solicitud->user->name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $solicitud->user->email }}</div>
                                </td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $solicitud->tipoResiduo->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $solicitud->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100'
                                    : ($solicitud->estado === 'confirmada' ? 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100'
                                    : ($solicitud->estado === 'recolectada' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'
                                    : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100')) }}">
                                    {{ ucfirst($solicitud->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $solicitud->created_at->format('d/m/Y') }}</td>
                            @if (Auth::user()->role === 'admin')
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $solicitud->peso ? $solicitud->peso . ' kg' : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $solicitud->puntos_ganados ?: '-' }}</td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <flux:button wire:click="view({{ $solicitud->id }})" variant="outline" size="xs">Ver</flux:button>
                                    @if (Auth::user()->role === 'admin')
                                        <flux:button wire:click="edit({{ $solicitud->id }})" variant="primary" size="xs">Editar</flux:button>
                                    @endif
                                    @if ($solicitud->estado === 'pendiente')
                                        @if (Auth::user()->role === 'company')
                                            <flux:button wire:click="confirm({{ $solicitud->id }})" variant="primary" size="xs">Confirmar</flux:button>
                                        @endif
                                        @if (Auth::id() === $solicitud->user_id)
                                            <flux:button wire:click="cancel({{ $solicitud->id }})" variant="danger" size="xs">Cancelar</flux:button>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-400">
                                No hay solicitudes para mostrar
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $solicitudes->links() }}
        </div>
    </div>

    <!-- Modal: Nueva Solicitud -->
    @include('livewire.recolection.partials.create-modal')

    <!-- Modal: Ver Solicitud -->
    @include('livewire.recolection.partials.view-modal')

    <!-- Modal: Editar Solicitud -->
    @include('livewire.recolection.partials.edit-modal')
</div>