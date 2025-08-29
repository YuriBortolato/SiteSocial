<?php
// Verifica se a sessão já está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../config/db.php");
include("../login/protect.php");

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_id = $_SESSION['id'];
    $conteudo   = trim($conn->real_escape_string($_POST['conteudo']));
    $imagem_nome = null;
    // Verifica se uma imagem foi enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagem = $_FILES['imagem'];
        $imagem_nome = uniqid() . '-' . basename($imagem['name']);
        $imagem_destino = "../uploads/" . $imagem_nome;

        if (!move_uploaded_file($imagem['tmp_name'], $imagem_destino)) {
            $erro = "Erro ao fazer upload da imagem.";
        }
    }

    // Valida se há conteúdo ou imagem
    if (empty($conteudo) && !$imagem_nome) {
        $erro = "Você deve inserir pelo menos texto ou uma imagem.";
    }

    // Se não houver erro, salva no banco
    if (empty($erro)) {
        if (!empty($conteudo) && $imagem_nome) {
            $sql = "INSERT INTO postagens (usuario_id, conteudo, imagem) VALUES ('$usuario_id', '$conteudo', '$imagem_nome')";
        } elseif (!empty($conteudo)) {
            $sql = "INSERT INTO postagens (usuario_id, conteudo) VALUES ('$usuario_id', '$conteudo')";
        } elseif ($imagem_nome) {
            $sql = "INSERT INTO postagens (usuario_id, imagem) VALUES ('$usuario_id', '$imagem_nome')";
        }

        if ($conn->query($sql)) {
            $_SESSION['sucesso'] = "Sua publicação foi enviada com sucesso!";
            header("Location: ../feed/painel.php");
            exit();
        } else {
            $erro = "Erro ao salvar no banco: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Postagem</title>
    <link rel="stylesheet" href="../css/posts.css">
</head>
<body>
<div class="container">
    <h1>Criar Postagem</h1>

    <?php if ($erro): ?>
        <div class="error-box"><?= htmlspecialchars($erro); ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <textarea name="conteudo" placeholder="O que você está pensando?"></textarea>

        <div class="file-upload">
            <label for="imagem" class="btn-file">Escolher arquivo</label>
            <input type="file" id="imagem" name="imagem" accept="image/*">
            <span id="file-chosen">Nenhum arquivo selecionado</span>
        </div>

        <button type="submit" class="btn-primary">Publicar</button>
        <a href="../feed/painel.php" class="btn-danger">Sair</a>
    </form>
</div>
<script src="../js/posts.js"></script>
</body>
</html>
