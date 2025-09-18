# AssetsProject

AssetsProject é um marketplace web de assets digitais construído em Laravel, permitindo que artistas vendam e compradores adquiram modelos 3D, artes 2D, vídeos e muito mais.

## Screenshots

<img src="https://github.com/user-attachments/assets/2a9eb5e3-a932-452d-a972-17a3f0b1c0ca" width="800" />

<img src="https://github.com/user-attachments/assets/129920df-778f-4cfd-b4c2-a7dd502f86e7" width="800" />

<img src="https://github.com/user-attachments/assets/1b165d34-8d94-4918-b05e-22eb3c9c4b18" width="800" />

<img width="800" alt="image" src="https://github.com/user-attachments/assets/5943f241-163a-4089-9736-da7747792f67" />


## Funcionalidades

- Cadastro e login de usuários (artistas e compradores)

- Perfis com assets criados, histórico de compras e avaliações

- Upload e gerenciamento de assets com pré-visualização

- Busca avançada por usuário, nome do asset, descrição e categoria

- Reviews validadas por Gemini AI (classifica o conteúdo como próprio ou impróprio)

- Controle de permissões via Policies do Laravel

- Integração com Mercado Pago para pagamentos de assets digitais

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

- Pagamentos integrados via **Mercado Pago**

## Instalação

Siga os passos abaixo para rodar o **AssetsProject** localmente:

### Pré-requisitos

- Node.js
- PHP ^8.2
- Laravel 12.0
- npm 

### Clone o repositório

```bash
git clone https://github.com/thiagocancan/AssetsProject.git
cd AssetsProject
```

### Instale as dependências do PHP

```bash
composer install
```

### Instale as dependências do frontend

```bash
npm install
npm run dev
```

### Configure o arquivo `.env`

```bash
cp .env.example .env
```

Edite o `.env` e defina:

- APP_NAME e APP_URL  
- Configurações do banco de dados (SQLite, MySQL ou PostgreSQL)  
- Configurações de mail, caso necessário  
- GEMINI_API_KEY  
- MERCADO_PAGO_ACCESS_TOKEN (obrigatório para pagamentos)

### Gere a chave da aplicação

```bash
php artisan key:generate
```

### Rode as migrações

```bash
php artisan migrate
```

### Configure o storage

```bash
php artisan storage:link
```

### Inicie o servidor local

```bash
composer dev
```

## Configuração Gemini IA

O projeto utiliza a API do Google Gemini AI para analisar o conteúdo das avaliações (reviews) feitas por usuários. O objetivo é 
identificar se o texto é apropriado ou impróprio, garantindo um ambiente seguro e profissional para artistas e compradores.

Configure a chave da API no .env:

```env
GEMINI_API_KEY=SUA_GEMINI_KEY
```

O serviço responsável pela moderação de reviews está localizado em `app\Services\ContentModerator.php`. Nesse arquivo, é possível personalizar o conteúdo enviado à API, ajustar parâmetros de entrada e configurar opções adicionais como verificação SSL, headers personalizados e outros comportamentos da requisição.

Como gerar sua chave da API Gemini?

- Acesse o Google AI Studio e siga as instruções

## Configuração do Mercado Pago

O projeto utiliza a API oficial do Mercado Pago para processar pagamentos.

### 1. Obter credenciais

Acesse Mercado Pago Developers  
Crie uma aplicação e copie o Access Token de teste

No `.env`:

```env
MERCADO_PAGO_ACCESS_TOKEN=SEU_ACCESS_TOKEN
```

### 2. Webhooks

O Mercado Pago envia notificações de pagamento via webhook, que deve estar acessível publicamente.  
Não é possível utilizar `localhost` diretamente.

#### Opções para testar:

- Usar um tunnel como ngrok ou cloudflared para expor o servidor local  
- Implantar em um servidor acessível na internet

##### Passe a url pública em:

```env
APP_URL=sua_url
```

Assim, o Mercado Pago poderá enviar notificações corretamente para:

```bash
/payment/webhook
```
