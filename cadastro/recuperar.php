<?php
include '../config/db.php';
session_start();

$mensagem = "";

if (isset($_POST['email'])) {
    $email = $conn->real_escape_string($_POST['email']);

    $sql_code = "SELECT * FROM usuarios WHERE email = '$email'";
    $sql_query = $conn->query($sql_code);

    if ($sql_query->num_rows == 1) {
        $_SESSION['email_recuperacao'] = $email;
        header("Location: confirmacao.php");
        exit();
    } else {
        $mensagem = "<div class='text-danger'>E-mail inexistente.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="../css/recuperar.css"> 
</head>
<body>
<div class="container mt-4">
    <h2>Recuperar Senha</h2>
    <?php if (!empty($mensagem)) echo $mensagem; ?>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Digite o e-mail da conta" required>
        </div>
        <button type="submit" class="btn btn-primary">Verificar E-mail</button>
        <button type="button" class="btn-danger" onclick="window.location.href='../login/index.php';">Cancelar</button>    </form>
</div>
</body>
</html>
