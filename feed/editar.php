<?php
session_start();
include("../config/db.php");
include("../login/protect.php");

$usuario_logado = $_SESSION['id'] ?? 0;

// Recebe o ID da postagem
$id = intval($_GET['id'] ?? 0);

// Verifica se a postagem existe e pertence ao usuário
$sql = "SELECT * FROM postagens WHERE id = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $usuario_logado);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows !== 1){
    $_SESSION['erro'] = "Postagem não encontrada ou você não tem permissão.";
    header("Location: painel.php");
    exit;
}

$postagem = $result->fetch_assoc();

// Processa atualização
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $conteudo = $_POST['conteudo'];

    // Atualiza apenas o conteúdo da postagem
    $sql_upd = "UPDATE postagens SET conteudo = ? WHERE id = ? AND usuario_id = ?";
    $stmt_upd = $conn->prepare($sql_upd);
    $stmt_upd->bind_param("sii", $conteudo, $id, $usuario_logado);
    $stmt_upd->execute();

    $_SESSION['sucesso'] = "Postagem atualizada com sucesso!";
    header("Location: painel.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Postagem</title>
</head>
<body>
    <h1>Editar Postagem</h1>

    <!-- Mostra a imagem atual -->
    <?php if ($postagem['imagem']): ?>
        <img src="../uploads/<?php echo htmlspecialchars($postagem['imagem']); ?>" alt="Imagem da postagem" style="max-width: 300px; margin-bottom: 10px;">
    <?php endif; ?>

    <!-- Formulário para editar apenas o texto/descrição -->
    <form action="" method="POST">
        <textarea name="conteudo" rows="5" cols="50" placeholder="Escreva uma descrição..."><?php echo htmlspecialchars($postagem['conteudo']); ?></textarea><br>
        <button type="submit">Atualizar</button>
        <a href="painel.php">Cancelar</a>
    </form>
</body>
</html>
