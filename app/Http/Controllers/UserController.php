<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request; // Importe a classe Request corretamente

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::all(); // Obtém todos os registros de usuários do banco de dados
    
        return view('users.index', ['users' => $users]); // Passa os usuários para a view
    }
    public function create()
    {
        return view('users.createUser');
    }
    public function store(Request $request)
    {
        // Validação dos dados do formulário com mensagens personalizadas
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
            'unique' => 'O campo :attribute já está em uso.',
            'min' => 'O campo :attribute deve ter no mínimo :min caracteres.',
        ]);

        // Criação de novo usuário
        $user = new User();
        $user->name = $request->input('nome');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        // Adiciona mensagem de sucesso à sessão
        session()->flash('success', 'Usuário criado com sucesso!');
        // Redirecionamento para a página de sucesso
        return redirect()->route('user.index');
    }
}
