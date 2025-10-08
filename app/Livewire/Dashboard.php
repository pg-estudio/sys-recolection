<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Solicitud;
use Livewire\Component;

class Dashboard extends Component
{
    public function getStats()
    {
        return [
            'total_users' => User::count(),
            'total_companies' => User::where('role', 'company')->count(),
            'pending_requests' => Solicitud::where('estado', 'pendiente')->count(),
        ];
    }

    public function render()
    {
        $stats = $this->getStats();
        return view('livewire.dashboard', [
            'stats' => $stats,
        ]);
    }
}