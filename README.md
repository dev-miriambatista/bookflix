# 📚 LitSpace

![LitSpace](https://img.shields.io/badge/Projeto-LitSpace-blue)
![PHP](https://img.shields.io/badge/PHP-8%2B-purple)
![SQLite](https://img.shields.io/badge/Database-SQLite-lightgrey)
![License](https://img.shields.io/badge/license-MIT-green)

## 📖 Sobre o Projeto

O **LitSpace** é uma aplicação web desenvolvida em **PHP puro** para gerenciamento e exploração de uma estante virtual de livros.

O projeto foi criado com o objetivo de proporcionar um espaço digital organizado para descoberta de livros, permitindo visualizar um catálogo, navegar por categorias, filtrar autores e gerenciar informações dos livros.

A aplicação foi construída sem frameworks PHP, utilizando conceitos fundamentais de desenvolvimento web:

- Programação Orientada a Objetos
- Separação de responsabilidades
- Organização em camadas
- Banco de dados SQLite
- Composer para gerenciamento de dependências

---

# ✨ Funcionalidades

## 📚 Catálogo de Livros

O LitSpace apresenta uma biblioteca digital com livros organizados em cards contendo:

- Capa do livro
- Título
- Autor
- Editora
- Edição
- Categoria/Gênero

---

## 🔎 Sistema de Filtros

O usuário pode explorar o catálogo utilizando filtros por:

- Categoria
- Autor

A atualização dos resultados acontece de forma dinâmica utilizando requisições AJAX.

---

## 📄 Paginação

O catálogo possui paginação para melhorar a navegação entre os livros.

Recursos:

- Divisão dos livros em páginas
- Carregamento organizado dos registros
- Melhor experiência de navegação

---

## ✏️ Gerenciamento de Livros

O sistema possui estrutura para:

- Adicionar novos livros
- Editar informações
- Remover registros
- Consultar detalhes dos livros

---

# 🏗️ Estrutura do Projeto


litspace/
│
├── public/
│ ├── index.php
│ ├── base.css
│ ├── book-list.css
│ ├── book-form.css
│ └── image/
│ └── capas dos livros
│
├── src/
│ │
│ ├── Controller/
│ │ ├── BookListController.php
│ │ ├── NewBookController.php
│ │ ├── EditBookController.php
│ │ └── DeleteBookController.php
│ │
│ ├── Entity/
│ │ └── Book.php
│ │
│ └── Repository/
│ └── BookRepository.php
│
├── views/
│ ├── book-list.php
│ ├── book-form.php
│ └── inicio-html.php
│
├── db_book.sqlite
├── criar-banco.php
├── popula-banco.php
├── composer.json
└── composer.lock


---

# 🚀 Tecnologias Utilizadas

## Backend

- PHP 8+
- Programação Orientada a Objetos
- Composer
- SQLite

## Frontend

- HTML5
- CSS3
- JavaScript
- AJAX

## Banco de Dados

- SQLite

---

# ⚙️ Como Executar o Projeto

## 1. Clonar o repositório

```bash
git clone https://github.com/dev-miriambatista/litspace.git

Entre na pasta:

cd litspace
2. Instalar dependências
composer install
3. Criar o banco de dados

Execute:

php criar-banco.php

Depois:

php popula-banco.php
4. Executar o servidor PHP

Execute:

php -S localhost:8000 -t public

Acesse:

http://localhost:8000
🗃️ Banco de Dados

O LitSpace utiliza SQLite como banco de dados.

Entidade principal
Book
Campo	Descrição
id	Identificador
title	Título do livro
writer	Autor
publisher	Editora
edition	Edição
gender	Categoria
image	Capa
🧩 Arquitetura

O projeto segue uma organização inspirada no padrão MVC.

Controller

Responsável pelo controle das ações da aplicação:

Receber requisições
Executar operações
Controlar fluxo
Entity

Representa os objetos principais do sistema.

Exemplo:

Book
Repository

Responsável pelo acesso aos dados:

Consultas SQL
Filtros
Paginação
Persistência
🌱 Melhorias Futuras
 Sistema de login
 Perfil de usuário
 Lista de favoritos
 Avaliação de livros
 Busca avançada
 Upload de capas
 API REST
 Dashboard administrativo
👩‍💻 Desenvolvido por
Miriam Batista

Projeto desenvolvido para prática de:

PHP Orientado a Objetos
Desenvolvimento Web
Banco de Dados SQLite
Arquitetura de Sistemas
📄 Licença

Este projeto está licenciado sob a licença MIT.


Também recomendo alterar o nome do repositório no GitHub:

Atual:

https://github.com/dev-miriambatista/bookflix


Novo:

https://github.com/dev-miriambatista/litspace


No GitHub:
**Settings → General → Repository name → Rename**

Depois, localmente:

```bash
git remote set-url origin https://github.com/dev-miriambatista/litspace.git
