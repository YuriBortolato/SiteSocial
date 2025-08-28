<?php
include '../config/db.php';
session_start();

if (isset($_POST['email'])) {
    $email = $conn->real_escape_string($_POST['email']);

    // Verifica se o e-mail existe
    $sql_code = "SELECT * FROM usuarios WHERE email = '$email'";
    $sql_query = $conn->query($sql_code);

    if ($sql_query->num_rows == 1) {
        // Se o e-mail existir, armazena o e-mail na sessão e redireciona para confirmacao.php
        $_SESSION['email_recuperacao'] = $email;
        header("Location: confirmacao.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>E-mail inexistente.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="../css/cadastro.css"> 
</head>
<body>
<div class="container mt-4">
    <h2>Recuperar Senha</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Digite o e-mail da conta" required>
        </div>
        <button type="submit" class="btn btn-primary">Verificar E-mail</button>
        <a href="../login/index.php" class="btn btn-secondary">Cancelar</a>

    </form>
</div>
</body>
</html>
