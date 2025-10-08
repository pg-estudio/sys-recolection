<?php

namespace App\Livewire\Recolection;

use App\Models\Ruta;
use App\Models\Localidad;
use Livewire\Component;
use Livewire\WithPagination;

class Routes extends Component
{
    use WithPagination;

    public $search = '';
    public $localidad = '';
    public $showCreateModal = false;
    public $showEditModal = false;
    
    public $form = [
        'localidad_id' => '',
        'dia_recoleccion' => '',
        'turno' => '',
    ];

    protected $rules = [
        'form.localidad_id' => 'required|exists:localidades,id',
        'form.dia_recoleccion' => 'required|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
        'form.turno' => 'required|in:Mañana,Tarde,Noche',
    ];

    protected $messages = [
        'form.localidad_id.required' => 'La localidad es requerida.',
        'form.localidad_id.exists' => 'La localidad seleccionada no es válida.',
        'form.dia_recoleccion.required' => 'El día de recolección es requerido.',
        'form.dia_recoleccion.in' => 'El día de recolección no es válido.',
        'form.turno.required' => 'El turno es requerido.',
        'form.turno.in' => 'El turno no es válido.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->validate();

        Ruta::create([
            'empresa_id' => auth()->user()->isCompany() ? auth()->user()->empresa_id : null,
            'localidad_id' => $this->form['localidad_id'],
            'dia_recoleccion' => $this->form['dia_recoleccion'],
            'turno' => $this->form['turno'],
        ]);

        $this->reset('form', 'showCreateModal');
        session()->flash('message', 'Ruta creada exitosamente.');
    }

    public function edit(Ruta $ruta)
    {
        $this->form = [
            'localidad_id' => $ruta->localidad_id,
            'dia_recoleccion' => $ruta->dia_recoleccion,
            'turno' => $ruta->turno,
        ];
        
        $this->showEditModal = true;
    }

    public function update(Ruta $ruta)
    {
        $this->validate();

        $ruta->update([
            'localidad_id' => $this->form['localidad_id'],
            'dia_recoleccion' => $this->form['dia_recoleccion'],
            'turno' => $this->form['turno'],
        ]);

        $this->reset('form', 'showEditModal');
        session()->flash('message', 'Ruta actualizada exitosamente.');
    }

    public function delete(Ruta $ruta)
    {
        $ruta->delete();
        session()->flash('message', 'Ruta eliminada exitosamente.');
    }

    public function render()
    {
        $query = Ruta::query()
            ->with(['localidad', 'empresa'])
            ->when($this->search, function ($query) {
                $query->whereHas('localidad', function ($query) {
                    $query->where('nombre', 'like', '%' . $this->search . '%');
                })->orWhere('dia_recoleccion', 'like', '%' . $this->search . '%');
            })
            ->when($this->localidad, function ($query) {
                $query->where('localidad_id', $this->localidad);
            })
            ->when(auth()->user()->isCompany(), function ($query) {
                $query->where('empresa_id', auth()->user()->empresa_id);
            });

        return view('livewire.recolection.routes', [
            'rutas' => $query->paginate(10),
            'localidades' => Localidad::all(),
            'dias' => ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
            'turnos' => ['Mañana', 'Tarde', 'Noche'],
        ]);
    }
}