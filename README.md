# AssetsProject

AssetsProject é um marketplace web de assets digitais construído em Laravel, permitindo que artistas vendam e compradores adquiram modelos 3D, artes 2D, vídeos e muito mais.

## Funcionalidades

- Cadastro e login de usuários (artistas e compradores)

- Perfis completos com portfólio, histórico de compras/vendas e avaliações

- Upload e gerenciamento de assets com pré-visualização

- Busca avançada por usuário, nome do asset e categoria

- Reviews validadas por Gemini AI (classifica o conteúdo como próprio ou impróprio)

- Controle de permissões via Policies do Laravel

## Tipos de Assets
### Tipo	Formatos	Visualização
- Modelos 3D `.obj, .fbx`	Prévia 3D interativa
- Artes 2D	`.jpeg, .jpg, .png, .gif`	Miniatura em galeria
- Vídeos	`.mp4, .avi, .mov`	Player embutido ou capa de vídeo

## Tech Stack

- Backend: Laravel + API REST

- Frontend: Livewire + TailwindCSS

- Banco de dados: SQLite

- Autenticação: Livewire + Laravel Sanctum para API

- Armazenamento de assets: público ou privado (para assets pagos)

## Status Atual

- CRUD de usuários, assets, orders e reviews

- Upload de arquivos com controle de acesso

- Barra de busca funcional

- Validação de reviews com Gemini AI

- Páginas construídas com componentes Livewire

## Instalação

Siga os passos abaixo para rodar o **AssetsProject** localmente:

### 1. Clone o repositório

```bash
git clone https://github.com/thiagocancan/AssetsProject.git
cd AssetsProject
```

### 2. Instale as dependências do PHP

```bash
composer install
```

### 3. Instale as dependências do frontend

```bash
npm install
npm run dev
```

### 4. Configure o arquivo .env

Copie o arquivo de exemplo e configure suas variáveis:

```bash
cp .env.example .env
```

Edite o .env para definir:

- APP_NAME e APP_URL

- Configurações do banco de dados (SQLite, MySQL ou PostgreSQL)

- Configurações de mail, caso necessário

- GEMINI_API_KEY

### 5. Gere a chave da aplicação

```bash
php artisan key:generate
```

### 6. Rode as migrações e seeders

```bash
php artisan migrate --seed
```

### 7. Configure o storage

Crie o link simbólico para acessar os arquivos publicamente:

```bash
php artisan storage:link
```

### 8. Inicie o servidor local

```bash
composer dev
```
