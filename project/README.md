# Carteira Digital

Uma aplicação Laravel 11 que simula uma carteira financeira digital, permitindo que os usuários realizem transferências de saldo e depósitos.

## Funcionalidades

- Cadastro e autenticação de usuários
- Depósito de dinheiro na carteira
- Transferência de dinheiro entre usuários
- Histórico completo de transações
- Reversão de transações

## Requisitos

- PHP 8.2 ou superior
- Composer
- MySQL
- Node.js e NPM

## Instalação

Siga os passos no arquivo [COMANDOS.md](COMANDOS.md) para instalar e configurar o projeto.

## Estrutura do Projeto

### Modelos

- `User`: Representa um usuário do sistema, com saldo e relacionamentos para transações.
- `Transaction`: Representa uma transação financeira (depósito ou transferência).

### Controladores

- `AuthController`: Gerencia o registro e autenticação de usuários.
- `DashboardController`: Exibe o dashboard principal do usuário.
- `TransactionController`: Gerencia as operações de depósito, transferência e reversão.

### Serviços

- `TransactionService`: Contém a lógica de negócio para as operações financeiras.

## Regras de Negócio

1. Usuários podem depositar qualquer valor positivo em suas contas.
2. Usuários só podem transferir dinheiro se tiverem saldo suficiente.
3. Todas as transações podem ser revertidas, desde que haja saldo suficiente.
4. Se o saldo do usuário estiver negativo, qualquer depósito será usado para compensar o saldo negativo primeiro.

## Licença

Este projeto está licenciado sob a [MIT License](LICENSE).
