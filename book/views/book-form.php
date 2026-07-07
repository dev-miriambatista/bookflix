<?php require_once __DIR__ . '/../views/inicio-html.php'; ?>

<div class="page-form">
    <div class="form-card">
        <h1>
            <i class="bi bi-book-half"></i>
            <?= isset($book) ? 'Editar Livro' : 'Novo Livro' ?>
        </h1>

        <form method="post">
            <div class="field">
                <label for="gender">Gênero</label>
                <select name="gender" id="gender" class="form-control" required>
                    <option value="" disabled <?= !isset($book) ? 'selected' : '' ?>>Escolha um gênero</option>
                    <option value="Ficção" <?= isset($book) && $book->getGender() === 'Ficção' ? 'selected' : '' ?>>Ficção</option>
                    <option value="Fantasia" <?= isset($book) && $book->getGender() === 'Fantasia' ? 'selected' : '' ?>>Fantasia</option>
                    <option value="Romance" <?= isset($book) && $book->getGender() === 'Romance' ? 'selected' : '' ?>>Romance</option>
                    <option value="Mistério" <?= isset($book) && $book->getGender() === 'Mistério' ? 'selected' : '' ?>>Mistério</option>
                    <option value="Suspense" <?= isset($book) && $book->getGender() === 'Suspense' ? 'selected' : '' ?>>Suspense</option>
                    <option value="Biografia" <?= isset($book) && $book->getGender() === 'Biografia' ? 'selected' : '' ?>>Biografia</option>
                    <option value="Aventura" <?= isset($book) && $book->getGender() === 'Aventura' ? 'selected' : '' ?>>Aventura</option>
                </select>
            </div>

            <div class="field">
                <label for="title">Título</label>
                <input name="title" class="form-control" required id="title"
                       value="<?= isset($book) ? htmlspecialchars($book->getTitle()) : '' ?>">
            </div>

            <div class="field">
                <label for="writer">Autor</label>
                <input name="writer" class="form-control" required id="writer"
                       value="<?= isset($book) ? htmlspecialchars($book->getWriter()) : '' ?>">
            </div>

            <div class="field">
                <label for="publisher">Editora</label>
                <input name="publisher" class="form-control" id="publisher"
                       value="<?= isset($book) ? htmlspecialchars($book->getPublisher()) : '' ?>">
            </div>

            <div class="field">
                <label for="edition">Edição</label>
                <input name="edition" class="form-control" id="edition"
                       value="<?= isset($book) ? htmlspecialchars($book->getEdition()) : '' ?>">
            </div>

            <div class="field">
                <label for="page">Páginas</label>
                <input name="page" type="number" class="form-control" id="page"
                       value="<?= isset($book) ? htmlspecialchars((string) $book->getPage()) : '' ?>">
            </div>

            <div class="field">
                <label for="image">Imagem (caminho)</label>
                <input name="image" type="text" class="form-control" id="image"
                       value="<?= isset($book) && $book->getImage() !== null ? htmlspecialchars($book->getImage()) : '' ?>">
            </div>

            <?php if (isset($book)): ?>
                <button type="submit" class="edit-button">Salvar Alterações</button>
            <?php else: ?>
                <button type="submit" class="add-button">Adicionar Livro</button>
            <?php endif; ?>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../views/fim-html.php'; ?>
