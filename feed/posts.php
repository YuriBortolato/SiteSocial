<?php
// Verifica se a sessão já está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../config/db.php"); // Conexão com o banco de dados
include("../login/protect.php"); // Protege a página

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_id = $_SESSION['id'];
    $conteudo   = trim($conn->real_escape_string($_POST['conteudo']));
    $imagem_nome = null;

    // Verifica se uma imagem foi enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagem = $_FILES['imagem'];
        $imagem_nome = uniqid() . '-' . basename($imagem['name']);
        $imagem_destino = "../uploads/" . $imagem_nome;

        // Move a imagem para o diretório de uploads
        if (!move_uploaded_file($imagem['tmp_name'], $imagem_destino)) {
            $_SESSION['erro'] = "Erro ao fazer upload da imagem.";
            header("Location: painel.php");
            exit();
        }
    }
    // Verifica se tem algo para postar (texto ou imagem)
    if (!empty($conteudo) || $imagem_nome) {
        if (!empty($conteudo) && $imagem_nome) {
            $sql = "INSERT INTO postagens (usuario_id, conteudo, imagem) VALUES ('$usuario_id', '$conteudo', '$imagem_nome')";
        } elseif (!empty($conteudo)) {
            $sql = "INSERT INTO postagens (usuario_id, conteudo) VALUES ('$usuario_id', '$conteudo')";
        } elseif ($imagem_nome) {
            $sql = "INSERT INTO postagens (usuario_id, imagem) VALUES ('$usuario_id', '$imagem_nome')";
        }
        $conn->query($sql);

        // Mensagem de sucesso
        $_SESSION['sucesso'] = "Sua publicação foi enviada com sucesso!";
    } else {
        $_SESSION['erro'] = "Você deve inserir pelo menos texto ou uma imagem.";
    }

    // Redireciona sempre para o painel
    header("Location: painel.php");
    exit();
}
?>
<?php
// Verifica se a sessão já está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../config/db.php"); // Conexão com o banco de dados
include("../login/protect.php"); // Protege a página

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_id = $_SESSION['id'];
    $conteudo   = trim($conn->real_escape_string($_POST['conteudo']));
    $imagem_nome = null;

    // Verifica se uma imagem foi enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagem = $_FILES['imagem'];
        $imagem_nome = uniqid() . '-' . basename($imagem['name']);
        $imagem_destino = "../uploads/" . $imagem_nome;

        // Move a imagem para o diretório de uploads
        if (!move_uploaded_file($imagem['tmp_name'], $imagem_destino)) {
            $_SESSION['erro'] = "Erro ao fazer upload da imagem.";
            header("Location: painel.php");
            exit();
        }
    }
    // Verifica se tem algo para postar (texto ou imagem)
    if (!empty($conteudo) || $imagem_nome) {
        if (!empty($conteudo) && $imagem_nome) {
            $sql = "INSERT INTO postagens (usuario_id, conteudo, imagem) VALUES ('$usuario_id', '$conteudo', '$imagem_nome')";
        } elseif (!empty($conteudo)) {
            $sql = "INSERT INTO postagens (usuario_id, conteudo) VALUES ('$usuario_id', '$conteudo')";
        } elseif ($imagem_nome) {
            $sql = "INSERT INTO postagens (usuario_id, imagem) VALUES ('$usuario_id', '$imagem_nome')";
        }
        $conn->query($sql);

        // Mensagem de sucesso
        $_SESSION['sucesso'] = "Sua publicação foi enviada com sucesso!";
    } else {
        $_SESSION['erro'] = "Você deve inserir pelo menos texto ou uma imagem.";
    }

    // Redireciona sempre para o painel
    header("Location: painel.php");
    exit();
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

    <!-- Mensagens -->
    <?php if (isset($_SESSION['erro'])): ?>
        <div class="text-danger"><?= $_SESSION['erro']; unset($_SESSION['erro']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['sucesso'])): ?>
        <div class="text-success"><?= $_SESSION['sucesso']; unset($_SESSION['sucesso']); ?></div>
    <?php endif; ?>

    <!-- Formulário Publicar -->
    <form action="" method="POST" enctype="multipart/form-data">
        <textarea name="conteudo" placeholder="O que você está pensando?"></textarea>
        <input type="file" name="imagem" accept="image/*">
        <button type="submit" class="btn-primary">Publicar</button>
        <a href="../feed/painel.php" class="btn-danger">Sair</a>
    </form>
</div>
</body>
</html>

