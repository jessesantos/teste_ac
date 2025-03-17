@extends('layouts.app')

@section('content')
<div class="text-center">
    <h1 class="text-4xl font-bold mb-6">Bem-vindo à Carteira Digital</h1>
    <p class="text-xl mb-8">A maneira mais fácil de gerenciar seu dinheiro e fazer transferências.</p>
    
    <div class="flex justify-center space-x-4">
        @guest
            <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">Criar Conta</a>
            <a href="{{ route('login') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg">Entrar</a>
        @else
            <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">Ir para Dashboard</a>
        @endguest
    </div>
    
    <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">Depósitos Fáceis</h2>
            <p>Adicione fundos à sua conta de forma rápida e segura.</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">Transferências Instantâneas</h2>
            <p>Envie dinheiro para outros usuários em segundos.</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">Histórico Completo</h2>
            <p>Acompanhe todas as suas transações com detalhes.</p>
        </div>
    </div>
</div>
@endsection
