<?php

use Dsw\Blog\DAO\PostDAO;
use Dsw\Blog\DAO\UserDAO;

require_once '../bootstrap.php';

// Podemos permitir la búsqueda sin estar logueado,
// pero si quisieras que solo busquen los usuarios registrados, descomentas:
// accessControl($user);

$postDAO = new PostDAO($conn);
$userDAO = new UserDAO($conn);

// 🔹 1. Leemos el término de búsqueda desde GET (?q=algo)
$q = $_GET['q'] ?? '';

// 🔹 2. Array de resultados (por defecto vacío)
$results = [];

if ($q !== '') {
    // Si hay texto de búsqueda, llamamos al DAO para obtener posts que lo contengan
    $results = $postDAO->searchByKeyword($q);
}

// Título de la página (para el header)
$titulo = "Buscar artículos";

include '../includes/header.php';
?>

<h1>Buscar artículos</h1>

<!-- 🔹 3. Formulario de búsqueda (método GET) -->
<form method="get" action="searchPost.php">
    <label for="q">Buscar por título o contenido:</label>
    <input
        type="text"
        name="q"
        id="q"
        value="<?= htmlspecialchars($q); ?>"
        required
    >
    <button type="submit">Buscar</button>
</form>

<hr>

<?php if ($q === ''): ?>

    <!-- Si el usuario todavía no ha buscado nada -->
    <p>Escribe algo en la caja de búsqueda y pulsa “Buscar”.</p>

<?php else: ?>

    <h2>Resultados para: "<?= htmlspecialchars($q); ?>"</h2>

    <?php if (empty($results)): ?>

        <!-- No se encontró ningún post -->
        <p>No se han encontrado artículos que coincidan con la búsqueda.</p>

    <?php else: ?>

        <ul>
            <?php foreach ($results as $post): ?>
                <?php
                    // Obtenemos el autor del post
                    $autor = $userDAO->get($post->getUserId());
                    $autorName = $autor ? $autor->getName() : 'Autor desconocido';

                    // Hacemos un pequeño resumen del cuerpo (primeros 150 caracteres)
                    $resumen = mb_substr($post->getBody(), 0, 150) . '...';
                ?>
                <li>
                    <h3>
                        <!-- Enlace al detalle del artículo -->
                        <a href="post.php?id=<?= $post->getId(); ?>">
                            <?= htmlspecialchars($post->getTitle()); ?>
                        </a>
                    </h3>
                    <p>
                        <strong>Autor:</strong>
                        <?= htmlspecialchars($autorName); ?>
                        <br>
                        <strong>Fecha:</strong>
                        <?= $post->getPublicationDate()->format('d/m/Y'); ?>
                    </p>
                    <p><?= nl2br(htmlspecialchars($resumen)); ?></p>
                    <hr>
                </li>
            <?php endforeach; ?>
        </ul>

    <?php endif; ?>

<?php endif; ?>

<?php include '../includes/footer.php'; ?>
