<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("../config/db.php");
include("../login/protect.php");

$usuario_logado = $_SESSION['id'] ?? 0;

$sql_postagens = "SELECT p.*, u.nome FROM postagens p JOIN usuarios u ON p.usuario_id = u.id ORDER BY p.data_criacao DESC";
$result_postagens = $conn->query($sql_postagens);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Painel</title>
    <link rel="stylesheet" href="../css/painel.css" />
    <script src="../js/painel.js" defer></script>
</head>
<body>
<div class="container">
    <header>
        <form action="../login/index.php" method="get" style="margin:0;">
            <button type="submit" class="logout-button">Sair</button>
        </form>

        <h1>Painel de Postagens</h1>

        <div class="header-buttons">
            <form action="posts.php" method="GET" style="margin:0;">
                <button type="submit" class="nova-postagem-button" title="Nova Postagem">+</button>
            </form>

            <form action="../perfil/perfil.php" method="GET" class="perfil-form" style="margin:0;">
                <input type="hidden" name="id" value="<?= htmlspecialchars($usuario_logado); ?>">
                <button type="submit" class="btn-perfil" title="Perfil">👤</button>
            </form>
        </div>
    </header>

    <!-- Mensagens -->
 <div class="mensagens">
    <?php if (isset($_SESSION['sucesso'])): ?>
        <div class="alert-success"><?= htmlspecialchars($_SESSION['sucesso']); ?></div>
        <?php unset($_SESSION['sucesso']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['erro'])): ?>
        <div class="error-box"><?= htmlspecialchars($_SESSION['erro']); ?></div>
        <?php unset($_SESSION['erro']); ?>
    <?php endif; ?>
</div>


    <h2>Postagens Recentes</h2>

    <?php while ($postagem = $result_postagens->fetch_assoc()): ?>
        <div id="post-<?= htmlspecialchars($postagem['id']); ?>" class="postagem">
            <h3><?= htmlspecialchars($postagem['nome']); ?></h3>
            <p><?= nl2br(htmlspecialchars($postagem['conteudo'])); ?></p>

            <?php if ($postagem['imagem']): ?>
                <img src="../uploads/<?= htmlspecialchars($postagem['imagem']); ?>" alt="Imagem da postagem" />
            <?php endif; ?>

            <p class="data-postagem"><?= htmlspecialchars($postagem['data_criacao']); ?></p>

            <?php if ($postagem['usuario_id'] == $usuario_logado): ?>
                <form action="editar.php" method="GET" style="display:inline;">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($postagem['id']); ?>">
                    <button type="submit">Editar</button>
                </form>
                <button onclick="excluirPost(<?= (int)$postagem['id']; ?>)">Excluir</button>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>
</body>
</html>
