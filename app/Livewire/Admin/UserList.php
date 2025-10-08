<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Traits\WithRoleValidation;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination, WithRoleValidation;

    protected $allowedRoles = ['admin'];

    public $selectedRole = [];

    protected $listeners = ['refreshUsers' => '$refresh'];

    public function parentMount()
    {
        $users = User::all();
        foreach ($users as $user) {
            $this->selectedRole[$user->id] = $user->role;
        }
    }

    public function updateRole($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($user->id !== auth()->id()) {
            $this->validate([
                "selectedRole.{$userId}" => ['required', 'in:user,admin,company'],
            ]);

            $user->update([
                'role' => $this->selectedRole[$userId]
            ]);

            $this->dispatch('role-updated');
        }
    }

    public function render()
    {
        return view('livewire.admin.user-list', [
            'users' => User::paginate(10),
        ]);
    }
}