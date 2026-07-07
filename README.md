# 📚 BookFlix

![BookFlix](https://img.shields.io/badge/Projeto-BookFlix-blue)
![PHP](https://img.shields.io/badge/PHP-8%2B-purple)
![SQLite](https://img.shields.io/badge/Database-SQLite-lightgrey)
![License](https://img.shields.io/badge/license-MIT-green)

## 📖 Sobre o Projeto

O **BookFlix** é uma aplicação web desenvolvida em **PHP puro** para gerenciamento e visualização de uma estante virtual de livros.

O objetivo do projeto é disponibilizar um catálogo organizado de livros, permitindo navegação, filtros por categoria e autor, paginação e gerenciamento dos registros.

A aplicação foi construída sem frameworks PHP, utilizando:

- Programação Orientada a Objetos
- Separação de responsabilidades
- Arquitetura organizada em camadas
- Banco de dados SQLite
- Composer para gerenciamento de dependências

---

# ✨ Funcionalidades

## 📚 Catálogo de Livros

- Exibição dos livros em cards
- Visualização das capas
- Informações dos livros:
  - Título
  - Autor
  - Editora
  - Edição
  - Categoria
  - Imagem

---

## 🔎 Filtros

O sistema permite filtrar livros por:

- Categoria/Gênero
- Autor

Os filtros utilizam requisições AJAX para atualizar o catálogo sem necessidade de recarregar toda a página.

---

## 📄 Paginação

O catálogo possui sistema de paginação para organizar grandes volumes de livros.

Recursos:

- Navegação entre páginas
- Carregamento dinâmico
- Controle de quantidade de registros exibidos

---

## ✏️ Gerenciamento de Livros

A aplicação possui estrutura para:

- Cadastro de livros
- Edição de informações
- Exclusão de registros
- Consulta de livros

---

# 🏗️ Estrutura do Projeto


bookflix/
│
├── book/
│ │
│ ├── public/
│ │ ├── index.php
│ │ ├── base.css
│ │ ├── book-list.css
│ │ ├── book-form.css
│ │ └── image/
│ │ └── capas dos livros
│ │
│ ├── src/
│ │ │
│ │ ├── Controller/
│ │ │ ├── BookListController.php
│ │ │ ├── NewBookController.php
│ │ │ ├── EditBookController.php
│ │ │ └── DeleteBookController.php
│ │ │
│ │ ├── Entity/
│ │ │ └── Book.php
│ │ │
│ │ └── Repository/
│ │ └── BookRepository.php
│ │
│ ├── views/
│ │ ├── book-list.php
│ │ ├── book-form.php
│ │ └── inicio-html.php
│ │
│ ├── db_book.sqlite
│ ├── criar-banco.php
│ ├── popula-banco.php
│ ├── composer.json
│ └── composer.lock
│
└── README.md


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
git clone https://github.com/dev-miriambatista/bookflix.git

Acesse a pasta:

cd bookflix
2. Instalar dependências

Execute:

composer install
3. Criar o banco de dados

Execute:

php criar-banco.php

Depois:

php popula-banco.php

Esses comandos criam e populam o banco SQLite com os livros iniciais.

4. Executar o servidor PHP

Dentro da pasta pública:

php -S localhost:8000 -t public

Acesse:

http://localhost:8000
🗃️ Banco de Dados

O projeto utiliza SQLite por ser uma solução simples, leve e eficiente para aplicações locais.

Entidade principal
Book
Campo	Descrição
id	Identificador do livro
title	Título
writer	Autor
publisher	Editora
edition	Edição
gender	Categoria
image	Caminho da capa
🧩 Arquitetura do Projeto

O BookFlix segue uma organização baseada no padrão MVC.

Controller

Responsável por:

Receber requisições
Controlar ações
Coordenar o fluxo da aplicação
Entity

Representa as entidades do sistema.

Exemplo:

Book

Responsável pelos objetos de livro.

Repository

Responsável pela comunicação com o banco de dados:

Consultas SQL
Filtros
Paginação
Persistência
📌 Melhorias Futuras
 Sistema de autenticação
 Área administrativa
 Lista de favoritos
 Avaliação dos livros
 Pesquisa por título
 Upload de capas
 API REST
 Migração para framework PHP
👩‍💻 Desenvolvido por
Miriam Batista

Projeto desenvolvido para prática de:

PHP Orientado a Objetos
Banco de dados SQLite
Desenvolvimento Web
Organização de sistemas
Arquitetura de aplicações
📄 Licença

Este projeto está licenciado sob a licença MIT.


Depois de criar o arquivo no GitHub, faça:

```bash
git add README.md
git commit -m "docs: adiciona README do projeto BookFlix"
git push
