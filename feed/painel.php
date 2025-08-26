<?php
// Verifica se a sessão já está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../config/db.php"); // Conexão com o banco de dados
include("../login/protect.php"); // Protege a página

// Busca todas as postagens
$sql_postagens = "SELECT p.*, u.nome FROM postagens p JOIN usuarios u ON p.usuario_id = u.id ORDER BY p.data_criacao DESC";
$result_postagens = $conn->query($sql_postagens);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
</head>
<body>
    <h1>Painel de Postagens</h1>

    <!-- Botão Sair -->
    <form action="../login/index.php" method="get" style="display: inline;">
        <button type="submit" class="logout-button">Sair</button>
    </form>
    
    <form action="posts.php" method = "GET">
        <button type="submit">Nova Postagem</button>
    </form>
    
    <h2>Postagens Recentes</h2>
    <?php while ($postagem = $result_postagens->fetch_assoc()): ?>
        <div>
            <h3><?php echo htmlspecialchars($postagem['nome']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($postagem['conteudo'])); ?></p>
            <?php if ($postagem['imagem']): ?>
                <img src="../uploads/<?php echo htmlspecialchars($postagem['imagem']); ?>" alt="Imagem da postagem" style="max-width: 100%;">
            <?php endif; ?>
            <p><em><?php echo $postagem['data_criacao']; ?></em></p>
        </div>
    <?php endwhile; ?>
</body>
</html>
