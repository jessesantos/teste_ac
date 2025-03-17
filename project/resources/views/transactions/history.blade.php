@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6">Histórico de Transações</h2>
    
    @if ($transactions->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Data</th>
                        <th class="px-4 py-2 text-left">Tipo</th>
                        <th class="px-4 py-2 text-left">Valor</th>
                        <th class="px-4 py-2 text-left">Descrição</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-2">
                                @if ($transaction->type == 'deposit')
                                    <span class="text-green-600">Depósito</span>
                                @elseif ($transaction->type == 'transfer_in')
                                    <span class="text-blue-600">Recebido de {{ $transaction->sender->name ?? 'Desconhecido' }}</span>
                                @elseif ($transaction->type == 'transfer_out')
                                    <span class="text-red-600">Enviado para {{ $transaction->user->name ?? 'Desconhecido' }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 font-bold {{ $transaction->type == 'transfer_out' ? 'text-red-600' : 'text-green-600' }}">
                                {{ $transaction->type == 'transfer_out' ? '-' : '+' }}R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                            </td>
                            <td class="px-4 py-2">{{ $transaction->description }}</td>
                            <td class="px-4 py-2">
                                @if ($transaction->is_reversed)
                                    <span class="text-red-600">Revertida</span>
                                @else
                                    <span class="text-green-600">Concluída</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if (!$transaction->is_reversed && ($transaction->type == 'deposit' || $transaction->type == 'transfer_out'))
                                    <form method="POST" action="{{ route('transactions.reverse', $transaction) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Tem certeza que deseja reverter esta transação?')">
                                            Reverter
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $transactions->links() }}
        </div>
    @else
        <p class="text-gray-600">Você ainda não possui transações.</p>
    @endif
    
    <div class="mt-6">
        <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Voltar para o Dashboard
        </a>
    </div>
</div>
@endsection 