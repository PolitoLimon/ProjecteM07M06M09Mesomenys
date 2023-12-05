<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        // Lógica para mostrar la lista de usuarios
    }

    public function create()
    {
        $this->authorize('create', User::class);

        // Lógica para mostrar el formulario de creación de usuario
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        // Lógica para almacenar un nuevo usuario
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        // Lógica para mostrar el formulario de edición de usuario
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        // Lógica para actualizar la información del usuario
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        // Lógica para mostrar la información de un usuario específico
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        // Lógica para eliminar un usuario
    }
}
