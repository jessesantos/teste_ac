<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
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