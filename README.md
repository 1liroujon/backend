# CRUD JS Project - Backend

Backend API para um sistema CRUD de usuários, desenvolvido com Node.js e Express. Este repositório contém apenas o backend — o frontend está disponível em outro repositório.

## Sumário

- Visão Geral
- Como Rodar o Backend
- Especificação da API
  - Base URL
  - Modelo de Dados
  - Endpoints
  - Formato de Erro
  - CORS
- Exemplos de Requisição e Resposta
- Checklist de Implementação

## Visão Geral

O backend expõe uma API RESTful que gerencia usuários. O frontend faz requisições HTTP via Fetch API usando JSON para criar, listar, atualizar e deletar usuários.

Tecnologias do backend:

- Node.js
- Express.js
- JSON (formato de dados)
- Docker (Node.js Alpine)

## Como Rodar o Backend

### Com Docker

```bash
docker compose up --build

O backend estará disponível em http://localhost:8000.
Sem Docker
bash

npm install
npm start

O backend rodará na porta 8000 por padrão.

Importante: O frontend espera que a API esteja rodando em http://localhost:8000.
Especificação da API

Este é o contrato que sua API deve seguir para funcionar com o frontend.
Base URL
Code

http://localhost:8000/api/users

Sua API deve escutar na porta 8000 e expor o recurso no caminho /api/users.
Modelo de Dados

A entidade gerenciada é User com os seguintes campos:
Campo	Tipo	Descrição	Obrigatório
id	number	Identificador único	Gerado pela API
name	string	Nome do usuário	Sim
age	number	Idade (número inteiro)	Sim
email	string	E-mail do usuário	Sim
Endpoints

Sua API deve implementar os 5 endpoints abaixo:
1. Listar usuários
Code

GET /api/users

Resposta (200):
JSON

{
  "users": [
    { "id": 1, "name": "Ana", "age": 25, "email": "ana@email.com" },
    { "id": 2, "name": "Carlos", "age": 30, "email": "carlos@email.com" }
  ]
}

    A resposta deve ser um objeto com a chave users contendo um array.
    Se não houver usuários, retorne { "users": [] }.

2. Criar usuário
Code

POST /api/users
Content-Type: application/json

Corpo da requisição:
JSON

{
  "name": "Ana",
  "age": 25,
  "email": "ana@email.com"
}

Resposta de sucesso (201): retorne o usuário criado (com id gerado).
JSON

{
  "id": 1,
  "name": "Ana",
  "age": 25,
  "email": "ana@email.com"
}

Resposta de erro (400/422):
JSON

{
  "error": "Descrição do erro"
}

3. Atualizar usuário (substituição total)
Code

PUT /api/users?id={id}
Content-Type: application/json

Corpo da requisição (todos os campos):
JSON

{
  "name": "Ana Silva",
  "age": 26,
  "email": "ana.silva@email.com"
}

Resposta de sucesso (200): retorne o usuário atualizado.

Resposta de erro (404):
JSON

{
  "error": "User not found"
}

    O id é passado como query parameter (?id=1), não no corpo da requisição.

4. Atualizar usuário (parcial)
Code

PATCH /api/users?id={id}
Content-Type: application/json

Corpo da requisição (apenas os campos alterados):
JSON

{
  "age": 27
}

    O corpo pode conter 1 ou 2 campos (nunca os 3 — nesse caso o frontend usa PUT).
    Os campos não enviados devem permanecer inalterados.

Resposta de sucesso (200): retorne o usuário atualizado.

Resposta de erro (404):
JSON

{
  "error": "User not found"
}

5. Deletar usuário
Code

DELETE /api/users?id={id}

Sem corpo na requisição.

Resposta de sucesso (200):
JSON

{
  "message": "User deleted"
}

Resposta de erro (404):
JSON

{
  "error": "User not found"
}

    O id é passado como query parameter (?id=1).

Formato de Erro

Em caso de erro, a API deve retornar um JSON com a chave error:
JSON

{
  "error": "Mensagem descrevendo o erro"
}

O frontend lê data.error para exibir a mensagem ao usuário. Use um status HTTP adequado (400, 404, 422, 500, etc).
CORS

Como o frontend roda em localhost:8080 e a API em localhost:8000, sua API deve configurar os headers CORS para permitir requisições cross-origin:
Code

Access-Control-Allow-Origin: *
Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS
Access-Control-Allow-Headers: Content-Type

Sem CORS configurado, o navegador bloqueará todas as requisições.
Exemplos de Requisição e Resposta
Criar
bash

curl -X POST http://localhost:8000/api/users \
  -H "Content-Type: application/json" \
  -d '{"name": "Maria", "age": 22, "email": "maria@email.com"}'

Listar
bash

curl http://localhost:8000/api/users

Atualizar (PUT)
bash

curl -X PUT "http://localhost:8000/api/users?id=1" \
  -H "Content-Type: application/json" \
  -d '{"name": "Maria Santos", "age": 23, "email": "maria.santos@email.com"}'

Atualizar (PATCH)
bash

curl -X PATCH "http://localhost:8000/api/users?id=1" \
  -H "Content-Type: application/json" \
  -d '{"age": 24}'

Deletar
bash

curl -X DELETE "http://localhost:8000/api/users?id=1"

Checklist de Implementação

Use esta lista para verificar se sua API atende a todos os requisitos:

    API rodando na porta 8000
    Rota base: /api/users
    GET retorna { "users": [...] }
    POST cria usuário com name, age (number) e email
    PUT atualiza todos os campos (id via query param)
    PATCH atualiza campos parciais (id via query param)
    DELETE remove usuário (id via query param)
    Respostas em JSON com Content-Type: application/json
    Erros retornam { "error": "mensagem" } com status HTTP adequado
    CORS configurado para aceitar requisições de localhost:8080
    Campo id gerado automaticamente pela API
    Campo age armazenado como número (não string)
