<?php
// Verifica se a sessão já está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../config/db.php"); // Conexão com o banco de dados
include("../login/protect.php"); // Protege a página

// ID do usuário logado
$usuario_logado = $_SESSION['id'] ?? 0;

// Exibe mensagens de sessão (sucesso/erro)
if (isset($_SESSION['sucesso'])) {
    echo "<div style='color: green;'>" . $_SESSION['sucesso'] . "</div>";
    unset($_SESSION['sucesso']);
    echo "<script>
            setTimeout(function() {
                document.querySelector('div[style]').style.display = 'none';
            }, 2000);
          </script>";
}
if (isset($_SESSION['erro'])) {
    echo "<div style='color: red;'>" . $_SESSION['erro'] . "</div>";
    unset($_SESSION['erro']);
    echo "<script>
            setTimeout(function() {
                document.querySelector('div[style]').style.display = 'none';
            }, 4000);
          </script>";
}

// Busca todas as postagens
$sql_postagens = "SELECT p.*, u.nome FROM postagens p JOIN usuarios u ON p.usuario_id = u.id ORDER BY p.data_criacao DESC";
$result_postagens = $conn->query($sql_postagens);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
    <!-- Inclui o arquivo JS externo -->
    <script src="../js/painel.js"></script>
</head>
<body>
    <h1>Painel de Postagens</h1>

    <!-- Botão Sair -->
    <form action="../login/index.php" method="get" style="display: inline;">
        <button type="submit" class="logout-button">Sair</button>
    </form>

    <!-- Botão Nova Postagem -->
    <form action="posts.php" method="GET" style="display: inline;">
        <button type="submit">Nova Postagem</button>
    </form>
    
    <h2>Postagens Recentes</h2>

    <?php while ($postagem = $result_postagens->fetch_assoc()): ?>
        <div id="post-<?php echo $postagem['id']; ?>" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
            <h3><?php echo htmlspecialchars($postagem['nome']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($postagem['conteudo'])); ?></p>

            <?php if ($postagem['imagem']): ?>
                <img src="../uploads/<?php echo htmlspecialchars($postagem['imagem']); ?>" alt="Imagem da postagem" style="max-width: 100%;">
            <?php endif; ?>

            <p><em><?php echo $postagem['data_criacao']; ?></em></p>

            <?php if ($postagem['usuario_id'] == $usuario_logado): ?>
                <!-- Botão editar -->
                <form action="editar.php" method="GET" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $postagem['id']; ?>">
                    <button type="submit">Editar</button>
                </form>

                <!-- Botão excluir via JS -->
                <button onclick="excluirPost(<?php echo $postagem['id']; ?>)">Excluir</button>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</body>
</html>
