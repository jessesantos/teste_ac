<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class TransactionService
{
    /**
     * Depositar dinheiro na conta do usuário.
     *
     * @param User $user
     * @param float $amount
     * @param string|null $description
     * @return Transaction
     */
    public function deposit(User $user, float $amount, ?string $description = null): Transaction
    {
        return DB::transaction(function () use ($user, $amount, $description) {
            // Atualizar o saldo do usuário
            $user->balance += $amount;
            $user->save();

            // Criar a transação
            return Transaction::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => 'deposit',
                'description' => $description ?? 'Depósito',
            ]);
        });
    }

    /**
     * Transferir dinheiro entre usuários.
     *
     * @param User $sender
     * @param User $receiver
     * @param float $amount
     * @param string|null $description
     * @return array<Transaction>
     * @throws Exception
     */
    public function transfer(User $sender, User $receiver, float $amount, ?string $description = null): array
    {
        if ($sender->balance < $amount) {
            throw new Exception('Saldo insuficiente para realizar a transferência.');
        }

        return DB::transaction(function () use ($sender, $receiver, $amount, $description) {
            // Atualizar o saldo do remetente
            $sender->balance -= $amount;
            $sender->save();

            // Atualizar o saldo do destinatário
            $receiver->balance += $amount;
            $receiver->save();

            // Criar a transação de saída
            $outTransaction = Transaction::create([
                'user_id' => $sender->id,
                'sender_id' => $sender->id,
                'amount' => $amount,
                'type' => 'transfer_out',
                'description' => $description ?? 'Transferência enviada para ' . $receiver->name,
            ]);

            // Criar a transação de entrada
            $inTransaction = Transaction::create([
                'user_id' => $receiver->id,
                'sender_id' => $sender->id,
                'amount' => $amount,
                'type' => 'transfer_in',
                'description' => $description ?? 'Transferência recebida de ' . $sender->name,
            ]);

            return [$outTransaction, $inTransaction];
        });
    }

    /**
     * Reverter uma transação.
     *
     * @param Transaction $transaction
     * @param string|null $description
     * @return Transaction|array<Transaction>
     * @throws Exception
     */
    public function reverseTransaction(Transaction $transaction, ?string $description = null)
    {
        if ($transaction->is_reversed) {
            throw new Exception('Esta transação já foi revertida.');
        }

        return DB::transaction(function () use ($transaction, $description) {
            // Marcar a transação como revertida
            $transaction->is_reversed = true;
            $transaction->save();

            if ($transaction->type === 'deposit') {
                $user = $transaction->user;
                
                // Verificar se o usuário tem saldo suficiente
                if ($user->balance < $transaction->amount) {
                    throw new Exception('Saldo insuficiente para reverter o depósito.');
                }
                
                // Atualizar o saldo do usuário
                $user->balance -= $transaction->amount;
                $user->save();
                
                // Criar a transação de reversão
                $reverseTransaction = Transaction::create([
                    'user_id' => $user->id,
                    'amount' => $transaction->amount,
                    'type' => 'deposit',
                    'description' => $description ?? 'Reversão de depósito',
                    'is_reversed' => false,
                    'reversed_transaction_id' => $transaction->id,
                ]);
                
                return $reverseTransaction;
            } elseif ($transaction->type === 'transfer_out') {
                $sender = $transaction->user;
                $receiver = User::find($transaction->sender_id);
                
                // Verificar se o destinatário tem saldo suficiente
                if ($receiver->balance < $transaction->amount) {
                    throw new Exception('O destinatário não tem saldo suficiente para reverter a transferência.');
                }
                
                // Atualizar o saldo do remetente
                $sender->balance += $transaction->amount;
                $sender->save();
                
                // Atualizar o saldo do destinatário
                $receiver->balance -= $transaction->amount;
                $receiver->save();
                
                // Criar as transações de reversão
                $reverseOutTransaction = Transaction::create([
                    'user_id' => $receiver->id,
                    'sender_id' => $receiver->id,
                    'amount' => $transaction->amount,
                    'type' => 'transfer_out',
                    'description' => $description ?? 'Reversão de transferência enviada',
                    'is_reversed' => false,
                    'reversed_transaction_id' => $transaction->id,
                ]);
                
                $reverseInTransaction = Transaction::create([
                    'user_id' => $sender->id,
                    'sender_id' => $receiver->id,
                    'amount' => $transaction->amount,
                    'type' => 'transfer_in',
                    'description' => $description ?? 'Reversão de transferência recebida',
                    'is_reversed' => false,
                    'reversed_transaction_id' => $transaction->id,
                ]);
                
                return [$reverseOutTransaction, $reverseInTransaction];
            } elseif ($transaction->type === 'transfer_in') {
                // Não fazemos nada aqui, pois a reversão é tratada na transação de saída
                return null;
            }
            
            return null;
        });
    }
} 