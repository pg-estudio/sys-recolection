<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        @if (auth()->user()->isAdmin())
            <x-admin-panel :stats="$stats" />
        @endif

        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <!-- Aquí irá el contenido específico según el rol del usuario -->
            @if (auth()->user()->isCompany())
                <!-- Panel para empresas -->
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <h3 class="p-4 text-lg font-semibold">Rutas Asignadas</h3>
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <h3 class="p-4 text-lg font-semibold">Recolecciones Pendientes</h3>
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <h3 class="p-4 text-lg font-semibold">Estadísticas</h3>
                </div>
            @else
                <!-- Panel para usuarios normales -->
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <h3 class="p-4 text-lg font-semibold">Mis Solicitudes</h3>
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <h3 class="p-4 text-lg font-semibold">Puntos Acumulados</h3>
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <h3 class="p-4 text-lg font-semibold">Recompensas Disponibles</h3>
                </div>
            @endif
        </div>

        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
            <h2 class="text-xl font-semibold mb-4">Actividad Reciente</h2>
            <!-- Aquí irá la actividad reciente según el rol -->
        </div>
    </div>
</div>
