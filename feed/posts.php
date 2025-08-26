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
    $conteudo = $conn->real_escape_string($_POST['conteudo']);
    $imagem = null;

    // Verifica se uma imagem foi enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagem = $_FILES['imagem'];
        $imagem_nome = uniqid() . '-' . basename($imagem['name']);
        $imagem_destino = "../uploads/" . $imagem_nome;

        // Move a imagem para o diretório de uploads
        if (move_uploaded_file($imagem['tmp_name'], $imagem_destino)) {
            // Insere a nova postagem no banco de dados
            $sql = "INSERT INTO postagens (usuario_id, conteudo, imagem) VALUES ('$usuario_id', '$conteudo', '$imagem_nome')";
            $conn->query($sql);
        } else {
            echo "Erro ao fazer upload da imagem.";
        }
    }
    // Verifica se o conteúdo não está vazio e se não é apenas espaços em branco
    if (!empty($conteudo) || isset($imagem)) {
        // Insere a nova postagem no banco de dados se houver conteúdo ou imagem
        if (!empty($conteudo) && isset($imagem)) {
            // Se ambos estão presentes
            $sql = "INSERT INTO postagens (usuario_id, conteudo, imagem) VALUES ('$usuario_id', '$conteudo', '$imagem_nome')";
        } elseif (!empty($conteudo)) {
            // Se apenas o conteúdo está presente
            $sql = "INSERT INTO postagens (usuario_id, conteudo) VALUES ('$usuario_id', '$conteudo')";
        } elseif (isset($imagem)) {
            // Se apenas a imagem está presente
            $sql = "INSERT INTO postagens (usuario_id, imagem) VALUES ('$usuario_id', '$imagem_nome')";
        }
        $conn->query($sql);
    } else {
        echo "Você deve inserir pelo menos texto ou uma imagem.";
    }
}
?>
<!-- Botão Publicar -->
<form action="" method="POST" enctype="multipart/form-data">
    <textarea name="conteudo" placeholder="O que você está pensando?" required></textarea>
    <input type="file" name="imagem" accept="image/*">
    <button type="submit">Publicar</button>
</form>
<!-- Botão Sair -->
<form action="../login/index.php" method="get" style="display: inline;">
    <button type="submit" class="logout-button">Sair</button>
</form>
