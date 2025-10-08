<?php

namespace App\Traits;

trait WithRoleValidation
{
    public function mount()
    {
        $this->validateRole();
        if (method_exists($this, 'parentMount')) {
            $this->parentMount();
        }
    }

    protected function validateRole()
    {
        $roles = property_exists($this, 'allowedRoles') ? $this->allowedRoles : [];
        
        if (empty($roles)) {
            return;
        }

        if (!auth()->check()) {
            abort(403, 'No has iniciado sesión.');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
    }
}