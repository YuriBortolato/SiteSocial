<?php
include '../config/db.php';
session_start();

// Verifica se o e-mail está na sessão
if (!isset($_SESSION['email_recuperacao'])) {
    header("Location: recuperar.php");
    exit();
}

if (isset($_POST['nova_senha'])) {
    $nova_senha = $_POST['nova_senha'];
    $email = $_SESSION['email_recuperacao'];

    // Atualiza a senha no banco de dados
    $conn->query("UPDATE usuarios SET senha = '$nova_senha' WHERE email = '$email'");
    echo "<div class='alert alert-success'>Senha redefinida com sucesso!</div>";

    // Limpa a sessão
    unset($_SESSION['email_recuperacao']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Redefinição de Senha</title>
    <link rel="stylesheet" href="../css/login.css"> 
</head>
<body>
<div class="container mt-4">
    <h2>Redefinir Senha</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="nova_senha" class="form-label">Nova Senha</label>
            <input type="text" name="nova_senha" id="nova_senha" class="form-control" placeholder="Digite sua nova senha" required>
        </div>
        <button type="submit" class="btn btn-primary">Redefinir Senha</button>
    </form>
</div>
</body>
</html>
