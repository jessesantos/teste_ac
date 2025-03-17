<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class TransactionController extends Controller
{
    protected $transactionService;

    /**
     * Criar uma nova instância do controlador.
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Mostrar o formulário de depósito.
     */
    public function showDepositForm()
    {
        return view('transactions.deposit');
    }

    /**
     * Processar o depósito.
     */
    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $user = Auth::user();
            $this->transactionService->deposit($user, $request->amount, $request->description);

            return redirect()->route('dashboard')->with('success', 'Depósito realizado com sucesso!');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Mostrar o formulário de transferência.
     */
    public function showTransferForm()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('transactions.transfer', compact('users'));
    }

    /**
     * Processar a transferência.
     */
    public function transfer(Request $request)
    {
        $request->validate([
            'receiver_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $sender = Auth::user();
            $receiver = User::findOrFail($request->receiver_id);

            $this->transactionService->transfer($sender, $receiver, $request->amount, $request->description);

            return redirect()->route('dashboard')->with('success', 'Transferência realizada com sucesso!');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Mostrar o histórico de transações.
     */
    public function history()
    {
        $user = Auth::user();
        $transactions = $user->transactions()->latest()->paginate(15);
        
        return view('transactions.history', compact('transactions'));
    }

    /**
     * Reverter uma transação.
     */
    public function reverse(Transaction $transaction)
    {
        try {
            // Verificar se o usuário é o proprietário da transação
            if ($transaction->user_id !== Auth::id()) {
                return back()->withErrors(['error' => 'Você não tem permissão para reverter esta transação.']);
            }

            $this->transactionService->reverseTransaction($transaction);

            return back()->with('success', 'Transação revertida com sucesso!');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
} 