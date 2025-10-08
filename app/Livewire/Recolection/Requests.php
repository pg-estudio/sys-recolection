<?php
namespace App\Livewire\Recolection;

use App\Models\Solicitud;
use App\Models\TipoResiduo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Requests extends Component
{
    use WithPagination;

    public $search            = '';
    public $estado            = '';
    public $tipo_residuo      = '';
    public $showCreateModal   = false;
    public $showViewModal     = false;
    public $showEditModal     = false;
    public $selectedSolicitud = null;

    public $form = [
        'tipo_residuo_id'   => '',
        'descripcion'       => '',
        'direccion'         => '',
        'peso_aproximado'   => '',
        'fecha_preferida'   => '',
        'telefono_contacto' => '',
        'notas_adicionales' => '',
        'peso'              => '',
        'puntos_ganados'    => '',
        'estado'            => '',
    ];

    public function mount()
    {
        // Inicializa el estado para empresas
        if (Auth::user()->role === 'company') {
            $this->estado = 'pendiente';
        }

        // Asegura que el modal esté cerrado para roles que no sean user
        if (Auth::user()->role !== 'user') {
            $this->showCreateModal = false;
        }
    }

    public function toggleCreateModal()
    {
        if (Auth::user()->role !== 'user') {
            return;
        }

        $this->showCreateModal = ! $this->showCreateModal;
        if (! $this->showCreateModal) {
            $this->resetForm();
        }
    }

    private function resetForm()
    {
        $this->form = [
            'tipo_residuo_id'   => '',
            'descripcion'       => '',
            'direccion'         => '',
            'peso_aproximado'   => '',
            'fecha_preferida'   => '',
            'telefono_contacto' => '',
            'notas_adicionales' => '',
            'peso'              => '',
            'puntos_ganados'    => '',
            'estado'            => '',
        ];
        $this->resetValidation();
    }

    protected $rules = [
        'form.tipo_residuo_id'   => 'required|exists:tipos_residuos,id',
        'form.descripcion'       => 'required|string|min:10',
        'form.direccion'         => 'required|string|min:10',
        'form.peso_aproximado'   => 'required|numeric|min:0.1',
        'form.fecha_preferida'   => 'required|date|after:today',
        'form.telefono_contacto' => 'required|string|min:10',
        'form.notas_adicionales' => 'nullable|string',
        'form.peso'              => 'nullable|numeric|min:0',
        'form.puntos_ganados'    => 'nullable|numeric|min:0',
        'form.estado'            => 'nullable|in:pendiente,confirmada,recolectada,cancelada',
    ];

    protected $messages = [
        'form.tipo_residuo_id.required'   => 'El tipo de residuo es requerido.',
        'form.tipo_residuo_id.exists'     => 'El tipo de residuo seleccionado no es válido.',
        'form.descripcion.required'       => 'La descripción del material es requerida.',
        'form.descripcion.min'            => 'La descripción debe tener al menos 10 caracteres.',
        'form.direccion.required'         => 'La dirección es requerida.',
        'form.direccion.min'              => 'La dirección debe tener al menos 10 caracteres.',
        'form.peso_aproximado.required'   => 'El peso aproximado es requerido.',
        'form.peso_aproximado.numeric'    => 'El peso aproximado debe ser un número.',
        'form.peso_aproximado.min'        => 'El peso aproximado debe ser mayor a 0.1 kg.',
        'form.fecha_preferida.required'   => 'La fecha preferida es requerida.',
        'form.fecha_preferida.date'       => 'La fecha preferida debe ser una fecha válida.',
        'form.fecha_preferida.after'      => 'La fecha preferida debe ser posterior a hoy.',
        'form.telefono_contacto.required' => 'El teléfono de contacto es requerido.',
        'form.telefono_contacto.min'      => 'El teléfono debe tener al menos 10 caracteres.',
        'form.peso.numeric'               => 'El peso debe ser un número.',
        'form.peso.min'                   => 'El peso no puede ser negativo.',
        'form.puntos_ganados.numeric'     => 'Los puntos deben ser un número.',
        'form.puntos_ganados.min'         => 'Los puntos no pueden ser negativos.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->validate([
            'form.tipo_residuo_id'   => 'required|exists:tipos_residuos,id',
            'form.descripcion'       => 'required|string|min:10',
            'form.direccion'         => 'required|string|min:10',
            'form.peso_aproximado'   => 'required|numeric|min:0.1',
            'form.fecha_preferida'   => 'required|date|after:today',
            'form.telefono_contacto' => 'required|string|min:10',
            'form.notas_adicionales' => 'nullable|string',
        ]);

        Solicitud::create([
            'user_id'           => Auth::id(),
            'tipo_residuo_id'   => $this->form['tipo_residuo_id'],
            'descripcion'       => $this->form['descripcion'],
            'direccion'         => $this->form['direccion'],
            'peso_aproximado'   => $this->form['peso_aproximado'],
            'fecha_preferida'   => $this->form['fecha_preferida'],
            'telefono_contacto' => $this->form['telefono_contacto'],
            'notas_adicionales' => $this->form['notas_adicionales'],
            'estado'            => 'pendiente',
        ]);

        $this->reset('form', 'showCreateModal');
        session()->flash('message', 'Solicitud creada exitosamente.');
    }

    public function view(Solicitud $solicitud)
    {
        $this->selectedSolicitud = $solicitud;
        $this->showViewModal     = true;
    }

    public function edit(Solicitud $solicitud)
    {
        if (! Auth::user()->role === 'admin') {
            return;
        }

        $this->selectedSolicitud = $solicitud;
        $this->form              = [
            'tipo_residuo_id' => $solicitud->tipo_residuo_id,
            'peso'            => $solicitud->peso,
            'puntos_ganados'  => $solicitud->puntos_ganados,
            'estado'          => $solicitud->estado,
        ];
        $this->showEditModal = true;
    }

    public function update()
    {
        if (! Auth::user()->role === 'admin') {
            return;
        }

        $this->validate();

        $this->selectedSolicitud->update([
            'peso'           => $this->form['peso'],
            'puntos_ganados' => $this->form['puntos_ganados'],
            'estado'         => $this->form['estado'],
        ]);

        if ($this->form['estado'] === 'recolectada' && $this->form['puntos_ganados'] > 0) {
            // Agregar puntos al usuario
            $this->selectedSolicitud->user->increment('puntos', $this->form['puntos_ganados']);
        }

        $this->reset('form', 'showEditModal', 'selectedSolicitud');
        session()->flash('message', 'Solicitud actualizada exitosamente.');
    }

    public function confirm(Solicitud $solicitud)
    {
        if (Auth::user()->role === 'company') {
            $solicitud->update([
                'estado' => 'confirmada',
            ]);
            session()->flash('message', 'Solicitud confirmada exitosamente.');
        }
    }

    public function cancel(Solicitud $solicitud)
    {
        if (Auth::id() === $solicitud->user_id && $solicitud->estado === 'pendiente') {
            $solicitud->update([
                'estado' => 'cancelada',
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
            ->when(Auth::user()->role !== 'admin', function ($query) {
                if (Auth::user()->role === 'company') {
                    $query->whereHas('ruta', function ($query) {
                        $query->where('empresa_id', Auth::user()->empresa_id);
                    });
                } else {
                    $query->where('user_id', Auth::id());
                }
            })
            ->latest();

        return view('livewire.recolection.requests', [
            'solicitudes'   => $query->paginate(10),
            'tiposResiduos' => TipoResiduo::all(),
        ]);
    }
}
