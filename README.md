<div align="center">
LitSpace

Catálogo de livros com arquitetura MVC em PHP puro

Mostrar Imagem
Mostrar Imagem
Mostrar Imagem
Mostrar Imagem
Mostrar Imagem

✨ Funcionalidades · 🚀 Como rodar · 🧩 Arquitetura · 📸 Screenshots · 🌱 Próximos passos

</div>

Sobre o projeto

O LitSpace é um sistema de catálogo de livros construído em PHP orientado a objetos, sem framework, seguindo a arquitetura MVC com separação real entre camadas.

O projeto nasceu da vontade de entender como frameworks como Laravel funcionam por dentro — antes de usar a mágica, construir a estrutura do zero.

O que foi praticado:


Arquitetura MVC implementada manualmente — sem framework
Orientação a objetos com interface, entidade e repositório
PDO com prepared statements para proteção contra SQL injection
Autoload PSR-4 com Composer
Operações CRUD completas com SQLite
CSS com design tokens (custom properties) e layout responsivo



✨ Funcionalidades


📚 Listagem de livros com filtro por categoria
➕ Cadastro de novos livros com capa
✏️ Edição de livros existentes
🗑️ Exclusão com confirmação
📄 Paginação da listagem
🎨 Interface responsiva com tema literário



🚀 Como rodar

Pré-requisitos


PHP 8.1 ou superior
Composer instalado
Extensão PDO SQLite habilitada


Passo a passo

bash# 1. Clone o repositório
git clone https://github.com/dev-miriambatista/litspace.git
cd litspace

# 2. Instale as dependências
composer install

# 3. Crie e popule o banco de dados
php criar-banco.php
php popula-banco.php

# 4. Suba o servidor
php -S localhost:8000 -t public

Acesse: http://localhost:8000


💡 Para recomeçar do zero, apague o arquivo db_book.sqlite da raiz e rode os passos 3 e 4 novamente.




📸 Screenshots


Adicione aqui prints da interface — arraste as imagens direto no editor do GitHub para inserir automaticamente.




🧩 Arquitetura

O projeto implementa o padrão MVC do zero, sem framework.

book/
├── public/
│   ├── index.php             ← Front controller — roteamento manual
│   ├── base.css
│   └── book-list.css
├── src/
│   ├── Controller/
│   │   ├── Controller.php           ← Interface base
│   │   ├── BookListController.php   ← Lista todos os livros
│   │   ├── NewBookController.php    ← Cadastra novo livro
│   │   ├── EditBookController.php   ← Edita livro existente
│   │   ├── DeleteBookController.php ← Remove livro
│   │   ├── FormBookController.php   ← Exibe formulário
│   │   └── Error404Controller.php   ← Rota não encontrada
│   ├── Entity/
│   │   └── Book.php                 ← Objeto de domínio com getters/setters
│   └── Repository/
│       └── BookRepository.php       ← Acesso ao banco via PDO
├── views/                           ← Templates PHP
├── criar-banco.php                  ← Script de criação do schema
└── popula-banco.php                 ← Script de seed de dados

Como as camadas se comunicam

Requisição HTTP
      ↓
index.php (roteamento)
      ↓
Controller (lógica de controle)
      ↓
Repository (acesso a dados via PDO)
      ↓
Entity Book (objeto de domínio)
      ↓
View (template PHP)
      ↓
Resposta HTML

Decisões técnicas

Por que PDO com bindValue tipado?
Prepared statements com tipos explícitos (PDO::PARAM_INT) protegem contra SQL injection e garantem que o banco receba o tipo correto — sem depender de cast automático do PHP.

Por que interface Controller?
O index.php chama $controller->processaRequisicao() sem saber qual controller está usando. Isso é polimorfismo — qualquer controller pode ser trocado sem alterar o front controller.

Por que hydrateBook?
Separar a construção do objeto Book dos dados brutos do banco segue o padrão Data Mapper — o repositório conhece o banco, mas a entidade não sabe que existe um banco.


🗃️ Banco de dados

CampoTipoDescriçãoidINTEGERChave primáriatitleTEXTTítulo do livrowriterTEXTAutorpublisherTEXTEditoraeditionINTEGERNúmero da ediçãogenderTEXTCategoria / gêneroimageTEXTCaminho da imagem capa


🌱 Próximos passos


 Autenticação de usuário com sessão PHP
 Upload de imagem de capa direto pelo formulário
 Busca por título e autor
 API REST com retorno JSON
 Migração do banco para MySQL
 Testes unitários com PHPUnit
 Deploy em servidor real



👩‍💻 Autora

<div align="center">
Miriam Batista

Estudante de Análise e Desenvolvimento de Sistemas no SENAC PR, em transição de carreira após mais de 10 anos na área administrativa. Construindo projetos reais para entender tecnologia de dentro para fora — não só usar o framework, mas saber o que ele resolve.

Mostrar Imagem
Mostrar Imagem

</div>

<div align="center">
Feito com 📚 e muito php -S localhost:8000

</div>
