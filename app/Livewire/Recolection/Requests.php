<?php

namespace App\Livewire\Recolection;

use App\Models\Solicitud;
use App\Models\TipoResiduo;
use Livewire\Component;
use Livewire\WithPagination;

class Requests extends Component
{
    use WithPagination;

    public $search = '';
    public $estado = '';
    public $tipo_residuo = '';
    public $showCreateModal = false;
    public $showViewModal = false;
    public $selectedSolicitud = null;
    
    public $form = [
        'tipo_residuo_id' => '',
    ];

    protected $rules = [
        'form.tipo_residuo_id' => 'required|exists:tipos_residuos,id',
    ];

    protected $messages = [
        'form.tipo_residuo_id.required' => 'El tipo de residuo es requerido.',
        'form.tipo_residuo_id.exists' => 'El tipo de residuo seleccionado no es válido.',
    ];

    public function mount()
    {
        if (auth()->user()->isCompany()) {
            $this->estado = 'pendiente';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->validate();

        Solicitud::create([
            'user_id' => auth()->id(),
            'tipo_residuo_id' => $this->form['tipo_residuo_id'],
            'estado' => 'pendiente',
        ]);

        $this->reset('form', 'showCreateModal');
        session()->flash('message', 'Solicitud creada exitosamente.');
    }

    public function view(Solicitud $solicitud)
    {
        $this->selectedSolicitud = $solicitud;
        $this->showViewModal = true;
    }

    public function confirm(Solicitud $solicitud)
    {
        if (auth()->user()->isCompany()) {
            $solicitud->update([
                'estado' => 'confirmada',
                'ruta_id' => null, // Aquí se asignaría la ruta correspondiente
            ]);
            session()->flash('message', 'Solicitud confirmada exitosamente.');
        }
    }

    public function cancel(Solicitud $solicitud)
    {
        if (auth()->id() === $solicitud->user_id && $solicitud->estado === 'pendiente') {
            $solicitud->update([
                'estado' => 'cancelada'
            ]);
            session()->flash('message', 'Solicitud cancelada exitosamente.');
        }
    }

    public function render()
    {
        $query = Solicitud::query()
            ->with(['user', 'tipoResiduo'])
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->estado, function ($query) {
                $query->where('estado', $this->estado);
            })
            ->when($this->tipo_residuo, function ($query) {
                $query->where('tipo_residuo_id', $this->tipo_residuo);
            })
            ->when(!auth()->user()->isAdmin(), function ($query) {
                if (auth()->user()->isCompany()) {
                    $query->whereHas('ruta', function ($query) {
                        $query->where('empresa_id', auth()->user()->empresa_id);
                    });
                } else {
                    $query->where('user_id', auth()->id());
                }
            })
            ->latest();

        return view('livewire.recolection.requests', [
            'solicitudes' => $query->paginate(10),
            'tiposResiduos' => TipoResiduo::all(),
        ]);
    }
}