<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Criar uma nova instância do controlador.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar o dashboard do usuário.
     */
    public function index()
    {
        $user = Auth::user();
        $transactions = $user->transactions()->latest()->paginate(10);
        
        return view('dashboard', compact('user', 'transactions'));
    }
} 