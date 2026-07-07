<?php
$dbPath = __DIR__ . '/../db_book.sqlite';
$pdo = new PDO("sqlite:$dbPath");

// Monta o HTML de um card de livro (reaproveitado no carregamento inicial e no filtro AJAX)
function renderBookCard(array $book): string
{
    $title = htmlspecialchars($book['title']);
    $writer = htmlspecialchars($book['writer']);
    $publish = htmlspecialchars($book['publisher']);
    $edition = htmlspecialchars($book['edition']);
    $page = htmlspecialchars($book['page']);
    $image = !empty($book['image']) ? '/' . ltrim(htmlspecialchars($book['image']), '/') : '/image/favicon/book.svg';
    $id = (int) $book['id'];

    return '
    <div class="col">
        <div class="card book-card book-card--horizontal shadow-sm">
            <div class="row g-0 h-100">
                <div class="col-4 col-sm-4">
                    <img src="' . $image . '" alt="' . $title . '" class="book-card__img" onerror="this.onerror=null;this.src=\'/image/favicon/book.svg\';">
                </div>
                <div class="col-8 col-sm-8">
                    <div class="card-body d-flex flex-column h-100">
                        <h3 class="card-title book-card__title" id="h3_title">' . $title . '</h3>

                        <ul class="list-unstyled book-card__meta mb-2">
                            <li><i class="bi bi-person"></i><span id="p_writer">' . $writer . '</span></li>
                            <li><i class="bi bi-building"></i><span id="p_publish">' . $publish . '</span></li>
                            <li><i class="bi bi-bookmark"></i><span id="p_edition">' . $edition . '</span></li>
                            <li><i class="bi bi-file-earmark-text"></i><span id="p_page">' . $page . ' pág.</span></li>
                        </ul>

                        <div class="book-card__actions mt-auto d-flex justify-content-end gap-2">
                            <a href="/editar-book?id=' . $id . '" class="btn btn-sm btn-outline-secondary book-card__btn" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="/delete-book?id=' . $id . '" class="btn btn-sm btn-outline-danger book-card__btn" title="Excluir">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>';
}

// Requisição AJAX de filtro: responde só com o HTML dos cards,
// sem tocar no header/footer da página (evita duplicar o layout).
if (isset($_GET['action']) && $_GET['action'] == 'fetchBooks' && isset($_GET['gender'])) {
    $gender = $_GET['gender'];

    if ($gender === '') {
        $stmt = $pdo->query("SELECT id, title, writer, publisher, edition, page, image FROM book ORDER BY id DESC");
    } else {
        $stmt = $pdo->prepare("SELECT id, title, writer, publisher, edition, page, image FROM book WHERE gender = :gender ORDER BY id DESC");
        $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $stmt->execute();
    }
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = '';
    if (!empty($books)) {
        foreach ($books as $book) {
            $html .= renderBookCard($book);
        }
    } else {
        $html .= '<p class="col-12 book-grid__empty">Nenhum livro encontrado nesse gênero.</p>';
    }

    echo $html;
    exit;
}

// Dados para o cabeçalho de boas-vindas e para o carregamento inicial da estante
$totalBooks = (int) $pdo->query("SELECT COUNT(*) FROM book")->fetchColumn();
$totalGenders = (int) $pdo->query("SELECT COUNT(DISTINCT gender) FROM book")->fetchColumn();
$initialBooks = $pdo->query("SELECT id, title, writer, publisher, edition, page, image FROM book ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once __DIR__ . '/../views/inicio-html.php'; ?>

<section class="estante-hero">
    <div class="estante-hero__text">
        <span class="estante-hero__eyebrow"><i class="bi bi-stars"></i> Bem-vinda de volta</span>
        <h1 class="estante-hero__title">Sua estante digital</h1>
        <p class="estante-hero__subtitle">Organize, filtre e acompanhe todos os seus livros em um só lugar.</p>
    </div>
    <div class="estante-hero__stats">
        <div class="estante-stat">
            <span class="estante-stat__value"><?= $totalBooks ?></span>
            <span class="estante-stat__label"><i class="bi bi-book"></i> Livro<?= $totalBooks === 1 ? '' : 's' ?></span>
        </div>
        <div class="estante-stat">
            <span class="estante-stat__value"><?= $totalGenders ?></span>
            <span class="estante-stat__label"><i class="bi bi-tags"></i> Gênero<?= $totalGenders === 1 ? '' : 's' ?></span>
        </div>
    </div>
    <i class="bi bi-book-half estante-hero__icon"></i>
</section>

<div class="page-list">
    <aside class="sidebar">
        <p class="sidebar__eyebrow">Sua estante</p>

        <label for="gender-select">Filtrar por gênero</label>
            <select id="gender-select" class="form-select">
            <option value="">Todos os gêneros</option>
            <option value="Ficção">Ficção</option>
            <option value="Fantasia">Fantasia</option>
            <option value="Romance">Romance</option>
            <option value="Mistério">Mistério</option>
            <option value="Suspense">Suspense</option>
            <option value="Biografia">Biografia</option>
            <option value="Terror">Terror/Horror</option>
            <option value="Autoajuda">Des. Pessoal</option>
            <option value="Cristão">Cristão</option>
            <option value="Policial">Policial</option>
            <option value="Aventura">Aventura</option>
            <option value="Clássico">Clássico</option>
            <option value="Dramáticos">Dramáticos</option>
            <option value="Ficção Científica">Ficção Científica</option>
            <option value="Literatura Infantil">Literatura Infantil</option>
            <option value="Juvenil">Juvenil</option>
            <option value="Romance Histórico">Romance Histórico</option>
            <option value="Técnico">Técnico</option>
            <option value="Programação">Programação</option>
        </select>

        <i class="bi bi-book-half sidebar__icon"></i>
    </aside>

    <div id="bookDisplay" class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
        <?php if (!empty($initialBooks)): ?>
            <?php foreach ($initialBooks as $book): ?>
                <?= renderBookCard($book) ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="col-12 book-grid__empty">Sua estante ainda está vazia. Que tal adicionar o primeiro livro?</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../views/fim-html.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('gender-select').addEventListener('change', function() {
            var gender = this.value;

            var xhr = new XMLHttpRequest();
            xhr.open('GET', '?action=fetchBooks&gender=' + encodeURIComponent(gender), true);

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    document.getElementById('bookDisplay').innerHTML = xhr.responseText;
                } else {
                    console.error('Erro na solicitação:', xhr.statusText);
                }
            };

            xhr.onerror = function() {
                console.error('Erro na solicitação.');
            };

            xhr.send();
        });
    });
</script>