<?php
$dbPath = __DIR__ . '/../db_book.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$perPage = 8; // 4 colunas x 2 linhas

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

// Monta o <nav> de paginação (Bootstrap), com data-attributes lidos pelo JS
function renderPagination(int $currentPage, int $totalPages, string $gender, string $writer): string
{
    if ($totalPages <= 1) {
        return '';
    }

    $genderAttr = htmlspecialchars($gender, ENT_QUOTES);
    $writerAttr = htmlspecialchars($writer, ENT_QUOTES);

    $html = '<ul class="pagination justify-content-center mt-4">';

    $prevDisabled = $currentPage <= 1 ? ' disabled' : '';
    $html .= '<li class="page-item' . $prevDisabled . '"><a class="page-link" href="#" data-page="' . ($currentPage - 1) . '" data-gender="' . $genderAttr . '" data-writer="' . $writerAttr . '">&laquo;</a></li>';

    for ($i = 1; $i <= $totalPages; $i++) {
        $active = $i === $currentPage ? ' active' : '';
        $html .= '<li class="page-item' . $active . '"><a class="page-link" href="#" data-page="' . $i . '" data-gender="' . $genderAttr . '" data-writer="' . $writerAttr . '">' . $i . '</a></li>';
    }

    $nextDisabled = $currentPage >= $totalPages ? ' disabled' : '';
    $html .= '<li class="page-item' . $nextDisabled . '"><a class="page-link" href="#" data-page="' . ($currentPage + 1) . '" data-gender="' . $genderAttr . '" data-writer="' . $writerAttr . '">&raquo;</a></li>';

    $html .= '</ul>';

    return $html;
}

// Busca livros paginados, com filtros opcionais de gênero e autor (combinados com AND). Devolve também o total de páginas.
function fetchBooksPage(PDO $pdo, string $gender, string $writer, int $page, int $perPage): array
{
    $conditions = [];
    $params = [];

    if ($gender !== '') {
        $conditions[] = 'gender = :gender';
        $params[':gender'] = $gender;
    }

    if ($writer !== '') {
        $conditions[] = 'writer = :writer';
        $params[':writer'] = $writer;
    }

    $where = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';

    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM book $where");
    $countStmt->execute($params);
    $totalItems = (int) $countStmt->fetchColumn();
    $totalPages = max(1, (int) ceil($totalItems / $perPage));
    $page = max(1, min($page, $totalPages));
    $offset = ($page - 1) * $perPage;

    $stmt = $pdo->prepare("SELECT id, title, writer, publisher, edition, page, image FROM book $where ORDER BY id DESC LIMIT :limit OFFSET :offset");
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value, PDO::PARAM_STR);
    }
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return [
        'books' => $stmt->fetchAll(PDO::FETCH_ASSOC),
        'page' => $page,
        'totalPages' => $totalPages,
    ];
}

// Requisição AJAX de filtro/paginação: responde com o HTML dos cards + o HTML da paginação,
// separados por um marcador, sem tocar no header/footer da página.
if (isset($_GET['action']) && $_GET['action'] == 'fetchBooks') {
    $gender = $_GET['gender'] ?? '';
    $writer = $_GET['writer'] ?? '';
    $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;

    $result = fetchBooksPage($pdo, $gender, $writer, $page, $perPage);

    $html = '';
    if (!empty($result['books'])) {
        foreach ($result['books'] as $book) {
            $html .= renderBookCard($book);
        }
    } else {
        $html .= '<p class="col-12 book-grid__empty">Nenhum livro encontrado com esse filtro.</p>';
    }

    $html .= '<!--PAGINATION-->' . renderPagination($result['page'], $result['totalPages'], $gender, $writer);

    echo $html;
    exit;
}

// Dados para o cabeçalho de boas-vindas e para o carregamento inicial da estante
$totalBooks = (int) $pdo->query("SELECT COUNT(*) FROM book")->fetchColumn();
$totalGenders = (int) $pdo->query("SELECT COUNT(DISTINCT gender) FROM book")->fetchColumn();

$initialGender = $_GET['gender'] ?? '';
$initialWriter = $_GET['writer'] ?? '';
$initialPage = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$initialResult = fetchBooksPage($pdo, $initialGender, $initialWriter, $initialPage, $perPage);
$initialBooks = $initialResult['books'];
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
        <?php
        $genderOptions = [
            'Ficção',
            'Fantasia',
            'Romance',
            'Mistério',
            'Suspense',
            'Biografia',
            'Terror' => 'Terror/Horror',
            'Autoajuda' => 'Des. Pessoal',
            'Cristão',
            'Policial',
            'Aventura',
            'Clássico',
            'Dramáticos',
            'Ficção Científica',
            'Literatura Infantil',
            'Juvenil',
            'Romance Histórico',
            'Técnico',
            'Programação',
        ];
        ?>
        <select id="gender-select" class="form-select">
            <option value="">Todos os gêneros</option>
            <?php foreach ($genderOptions as $value => $label): ?>
                <?php $value = is_int($value) ? $label : $value; ?>
                <option value="<?= htmlspecialchars($value) ?>"
                               <?= $value === $initialGender ? 'selected' : '' ?>
                               >
                               <?= htmlspecialchars($label) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="writer-select" class="mt-3">Filtrar por Autor</label>
        <select id="writer-select" class="form-select">
            <option value="">Todos os autores</option>
            <?php
            $writers = $pdo->query("SELECT DISTINCT writer FROM book ORDER BY writer ASC")->fetchAll(PDO::FETCH_COLUMN);
            foreach ($writers as $writer):
            ?>
                <option value="<?= htmlspecialchars($writer) ?>"
                               <?= $writer === $initialWriter ? 'selected' : '' ?>
                               >
                               <?= htmlspecialchars($writer) ?></option>
             <?php endforeach; ?>
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

<nav id="bookPagination" aria-label="Paginação de livros" style="padding: 0 var(--space-6) var(--space-4);">
    <?= renderPagination($initialResult['page'],
    $initialResult['totalPages'],
    $initialGender, $initialWriter) ?>
</nav>

<?php require_once __DIR__ . '/../views/fim-html.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var bookDisplay = document.getElementById('bookDisplay');
        var bookPagination = document.getElementById('bookPagination');
        var genderSelect = document.getElementById('gender-select');
        var writerSelect = document.getElementById('writer-select');

        function loadBooks(gender, writer, page) {
            var url = '?action=fetchBooks'
                + '&gender=' + encodeURIComponent(gender)
                + '&writer=' + encodeURIComponent(writer)
                + '&page=' + page;

            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);

            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    var parts = xhr.responseText.split('<!--PAGINATION-->');
                    bookDisplay.innerHTML = parts[0];
                    bookPagination.innerHTML = parts[1] || '';
                } else {
                    console.error('Erro na solicitação:', xhr.statusText);
                }
            };

            xhr.onerror = function () {
                console.error('Erro na solicitação.');
            };

            xhr.send();
        }

        // Trocar qualquer um dos dois filtros sempre volta para a página 1,
        // e mantém o valor atual do outro filtro (gênero + autor combinados).
        genderSelect.addEventListener('change', function () {
            loadBooks(this.value, writerSelect.value, 1);
        });

        writerSelect.addEventListener('change', function () {
            loadBooks(genderSelect.value, this.value, 1);
        });

        // Delegação de evento: os links de página são recriados a cada resposta AJAX
        bookPagination.addEventListener('click', function (e) {
            var link = e.target.closest('a[data-page]');
            if (!link || link.closest('.page-item.disabled') || link.closest('.page-item.active')) {
                e.preventDefault();
                return;
            }
            e.preventDefault();
            loadBooks(link.dataset.gender || '', link.dataset.writer || '', parseInt(link.dataset.page, 10));
        });
    });
</script>