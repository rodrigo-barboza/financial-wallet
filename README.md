# 🚀 Projeto Laravel com Docker

Este projeto fornece um ambiente Docker completo para desenvolvimento Laravel.

## 📋 Pré-requisitos

- Docker
- Docker Compose

## 🚀 Como executar

### 1. Inicie os containers
```bash
docker compose up -d

### 2. Acesse o container da aplicação
```bash
docker compose exec app bash

### 3. Execute os comandos do Laravel (dentro do container)
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build

### 🌐 Acessando a aplicação
Frontend disponível em: http://localhost:8080

A aplicação estará rodando após a execução dos comandos acima.

