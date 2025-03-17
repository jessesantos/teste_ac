@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Fazer Transferência</h2>
    
    <form method="POST" action="{{ route('transactions.transfer') }}">
        @csrf
        
        <div class="mb-4">
            <label for="receiver_id" class="block text-gray-700 font-bold mb-2">Destinatário</label>
            <select name="receiver_id" id="receiver_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="">Selecione um usuário</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('receiver_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-4">
            <label for="amount" class="block text-gray-700 font-bold mb-2">Valor (R$)</label>
            <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required step="0.01" min="0.01"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>
        
        <div class="mb-6">
            <label for="description" class="block text-gray-700 font-bold mb-2">Descrição (opcional)</label>
            <input type="text" name="description" id="description" value="{{ old('description') }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>
        
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Transferir
            </button>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection 