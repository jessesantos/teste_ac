@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Fazer Depósito</h2>
    
    <form method="POST" action="{{ route('transactions.deposit') }}">
        @csrf
        
        <div class="mb-4">
            <label for="amount" class="block text-gray-700 font-bold mb-2">Valor (R$)</label>
            <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required autofocus step="0.01" min="0.01"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>
        
        <div class="mb-6">
            <label for="description" class="block text-gray-700 font-bold mb-2">Descrição (opcional)</label>
            <input type="text" name="description" id="description" value="{{ old('description') }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>
        
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Depositar
            </button>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection 