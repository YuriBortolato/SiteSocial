<?php
// Verifica se a sessão já está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../config/db.php"); // Conexão com o banco de dados
include("../login/protect.php"); // Protege a página

// ID do usuário logado
$usuario_logado = $_SESSION['id'] ?? 0;

// Redireciona para login se não estiver logado
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

// Busca postagens
$sql_postagens = "SELECT p.*, u.nome FROM postagens p JOIN usuarios u ON p.usuario_id = u.id ORDER BY p.data_criacao DESC";
$result_postagens = $conn->query($sql_postagens);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
    <!-- Inclui o arquivo CSS externo -->
    <link rel="stylesheet" href="../css/painel.css">
    <!-- Inclui o arquivo JS externo -->
    <script src="../js/painel.js"></script>
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
                    <input type="hidden" name="id" value="<?php echo $usuario_logado; ?>">
                    <button type="submit" class="btn-perfil" title="Perfil">👤</button>
                </form>
            </div>
        </header>

        <h2>Postagens Recentes</h2>

        <?php while ($postagem = $result_postagens->fetch_assoc()): ?>
            <div id="post-<?php echo $postagem['id']; ?>" class="postagem">
                <h3><?php echo htmlspecialchars($postagem['nome']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($postagem['conteudo'])); ?></p>

                <?php if ($postagem['imagem']): ?>
                    <img src="../uploads/<?php echo htmlspecialchars($postagem['imagem']); ?>" alt="Imagem da postagem">
                <?php endif; ?>

                <p><em><?php echo $postagem['data_criacao']; ?></em></p>

                <?php if ($postagem['usuario_id'] == $usuario_logado): ?>
                    <form action="editar.php" method="GET" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $postagem['id']; ?>">
                        <button type="submit">Editar</button>
                    </form>

                    <button onclick="excluirPost(<?php echo $postagem['id']; ?>)">Excluir</button>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
