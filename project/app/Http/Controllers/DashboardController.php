<?php

namespace App\Http\Controllers;

use App\Http\Traits\ControllerMiddlewareTrait;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use ControllerMiddlewareTrait;
    
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
        $transactions = Transaction::where('user_id', $user->id)
            ->orWhere('sender_id', $user->id)
            ->latest()
            ->paginate(10);
        
        return view('dashboard', compact('user', 'transactions'));
    }
} 