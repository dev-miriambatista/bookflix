# 📚 LitSpace

Sistema de catálogo de livros desenvolvido em PHP Orientado a Objetos, seguindo uma
organização inspirada no padrão MVC, com persistência em SQLite.

## 🚀 Como rodar o projeto

### 1. Clonar o repositório

​```bash
git clone https://github.com/dev-miriambatista/litspace.git
cd litspace
​```

### 2. Instalar dependências

​```bash
composer install
​```

### 3. Criar e popular o banco de dados

O arquivo do banco (`db_book.sqlite`) **não é versionado** — ele é gerado localmente.

​```bash
php criar-banco.php
php popula-banco.php
​```

> Se você já rodou esses comandos antes e quiser recomeçar do zero, apague o
> arquivo `db_book.sqlite` da raiz do projeto e rode os dois comandos novamente.

### 4. Executar o servidor PHP

​```bash
php -S localhost:8000 -t public
​```

Acesse: [http://localhost:8000](http://localhost:8000)

## 🗃️ Banco de Dados

O LitSpace utiliza **SQLite** como banco de dados.

### Entidade principal — `Book`

| Campo     | Descrição      |
|-----------|----------------|
| id        | Identificador  |
| title     | Título do livro|
| writer    | Autor          |
| publisher | Editora        |
| edition   | Edição         |
| gender    | Categoria      |
| image     | Capa           |

## 🧩 Arquitetura

O projeto segue uma organização inspirada no padrão MVC.

**Controller**
Responsável pelo controle das ações da aplicação:
- Receber requisições
- Executar operações
- Controlar fluxo

**Entity**
Representa os objetos principais do sistema. Exemplo: `Book`.

**Repository**
Responsável pelo acesso aos dados:
- Consultas SQL
- Filtros
- Paginação
- Persistência

## 🌱 Melhorias Futuras

- [ ] Sistema de login
- [ ] Perfil de usuário
- [ ] Lista de favoritos
- [ ] Avaliação de livros
- [ ] Busca avançada
- [ ] Upload de capas
- [ ] API REST
- [ ] Dashboard administrativo

## 👩‍💻 Desenvolvido por

**Miriam Batista**

Projeto desenvolvido para prática de:
- PHP Orientado a Objetos
- Desenvolvimento Web
- Banco de Dados SQLite
- Arquitetura de Sistemas

## 📄 Licença

Este projeto está licenciado sob a licença MIT.
