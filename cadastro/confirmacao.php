<?php
include '../config/db.php';
session_start();

if (!isset($_SESSION['email_recuperacao'])) {
    header("Location: recuperar.php");
    exit();
}

$mensagem = "";

if (isset($_POST['nova_senha'])) {
    $nova_senha = $_POST['nova_senha'];
    $email = $_SESSION['email_recuperacao'];

    $sql = "SELECT senha FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);
    $usuario = $result->fetch_assoc();

    if ($usuario && $usuario['senha'] === $nova_senha) {
        $mensagem = "<div class='text-danger'>A nova senha deve ser diferente da senha anterior!</div>";
    } else {
        $conn->query("UPDATE usuarios SET senha = '$nova_senha' WHERE email = '$email'");
        $mensagem = "<div class='text-success'>Senha redefinida com sucesso!</div>";

        unset($_SESSION['email_recuperacao']);

        echo "<script>
                setTimeout(function() {
                    window.location.href = '../login/index.php';
                }, 3000);
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Redefinição de Senha</title>
    <link rel="stylesheet" href="../css/confirmacao.css"> 
</head>
<body>
<div class="container mt-4">
    <h2>Redefinir Senha</h2>
    <?php if (!empty($mensagem)) echo $mensagem; ?>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="nova_senha" class="form-label">Nova Senha:</label>
            <input type="text" name="nova_senha" id="nova_senha" class="form-control" placeholder="Digite sua nova senha" required>
        </div>
        <button type="submit" class="btn btn-primary">Redefinir Senha</button>
        <button type="button" class="btn-danger" onclick="window.location.href='../login/index.php';">Cancelar</button>    </form>
    </form>
</div>
</body>
</html>
