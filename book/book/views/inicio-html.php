<?php $currentPath = $_SERVER['PATH_INFO'] ?? '/'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/image/favicon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/base.css">
    <link rel="stylesheet" href="/book-list.css">
    <link rel="stylesheet" href="/book-form.css">
    <title>Book</title>
</head>
<body>
<header class="site-header">
    <div class="site-header__brand">
        <i class="bi bi-book-half"></i>
        <span>Book</span>
    </div>
    <nav class="site-header__nav">
        <a href="/" class="<?= $currentPath === '/' ? 'is-active' : '' ?>">
            <i class="bi bi-grid"></i> Estante
        </a>
        <a href="/novo-book" class="is-primary">
            <i class="bi bi-plus-lg"></i> Novo Livro
        </a>
    </nav>
</header>
<main class="site-main">