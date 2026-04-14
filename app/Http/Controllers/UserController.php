<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Exibe a lista de usuários e o formulário de cadastro.
     * Apenas o Erick (admin) tem acesso.
     */
    public function index()
    {
        if (Auth::user()->email !== 'erickfanka@gmail.com') {
            abort(403, 'Acesso negado.');
        }

        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Salva um novo usuário no banco de dados.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Remove um usuário do sistema.
     * Impede que o administrador se delete.
     */
    public function destroy(User $user)
    {
        // 1. Segurança: Só o Erick entra aqui
        if (Auth::user()->email !== 'erickfanka@gmail.com') {
            abort(403);
        }

        // 2. Segurança: Impede que você delete seu próprio usuário
        if ($user->email === 'erickfanka@gmail.com') {
            return redirect()->back()->with('error', 'Ação proibida: Você não pode remover sua própria conta de administrador!');
        }

        $user->delete();
        return redirect()->back()->with('success', 'Usuário removido com sucesso!');
    }
}