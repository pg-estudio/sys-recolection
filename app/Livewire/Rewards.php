<?php

namespace App\Livewire;

use App\Models\Recompensa;
use App\Models\Canje;
use App\Models\Punto;
use App\Exceptions\InsufficientPointsException;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Rewards extends Component
{
    use WithPagination;

    public $showCanjearModal = false;
    public $selectedRecompensa = null;
    public $puntos = 0;

    public function mount()
    {
        $this->updatePuntos();
    }

    public function updatePuntos()
    {
        $punto = Punto::where('user_id', auth()->id())->first();
        $this->puntos = $punto ? $punto->total : 0;
    }

    public function render()
    {
        $recompensas = Recompensa::query()
            ->when(!auth()->user()->isAdmin(), function ($query) {
                $query->where('disponible', true);
            })
            ->orderBy('puntos_requeridos')
            ->paginate(9);

        $canjes = Canje::where('user_id', auth()->id())
            ->with('recompensa')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.rewards', [
            'recompensas' => $recompensas,
            'canjes' => $canjes,
        ]);
    }

    public function canjear($recompensaId)
    {
        $recompensa = Recompensa::findOrFail($recompensaId);
        $this->selectedRecompensa = $recompensa;

        if ($this->puntos < $recompensa->puntos_requeridos) {
            $this->dispatch('notify', [
                'message' => __('No tienes suficientes puntos para esta recompensa.'),
                'type' => 'error'
            ]);
            return;
        }

        $this->showCanjearModal = true;
    }

    public function confirmarCanje()
    {
        $this->showCanjearModal = false;

        if (!$this->selectedRecompensa) {
            return;
        }

        try {
            DB::beginTransaction();

            // Verificar que el usuario tenga suficientes puntos
            $punto = Punto::where('user_id', auth()->id())->lockForUpdate()->first();
            
            if (!$punto || $punto->total < $this->selectedRecompensa->puntos_requeridos) {
                throw new InsufficientPointsException();
            }

            // Crear el canje
            Canje::create([
                'user_id' => auth()->id(),
                'recompensa_id' => $this->selectedRecompensa->id,
                'puntos_canjeados' => $this->selectedRecompensa->puntos_requeridos,
                'fecha_canje' => now(),
                'estado' => 'pendiente'
            ]);

            // Actualizar los puntos del usuario
            $punto->update([
                'total' => $punto->total - $this->selectedRecompensa->puntos_requeridos
            ]);

            DB::commit();

            $this->updatePuntos();
            $this->reset('selectedRecompensa');
            
            $this->dispatch('notify', [
                'message' => __('¡Recompensa canjeada exitosamente! Pronto nos pondremos en contacto contigo.'),
                'type' => 'success'
            ]);

        } catch (InsufficientPointsException $e) {
            DB::rollBack();
            $this->dispatch('notify', [
                'message' => $e->getMessage(),
                'type' => 'error'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', [
                'message' => __('Ha ocurrido un error al procesar tu solicitud.'),
                'type' => 'error'
            ]);
        }
    }
}