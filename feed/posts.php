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
<!-- Botão Publicar -->
<form action="" method="POST" enctype="multipart/form-data">
    <textarea name="conteudo" placeholder="O que você está pensando?"></textarea>
    <input type="file" name="imagem" accept="image/*">
    <button type="submit">Publicar</button>
</form>
<!-- Botão Sair -->
<form action="../feed/painel.php" method="get" style="display: inline;">
    <button type="submit" class="logout-button">Sair</button>
</form>
