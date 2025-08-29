<?php
include '../include/header.php'; 
include '../config/db.php';

session_start();

// inicializa as variáveis de erro
$email_error = '';
$senha_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['email'])) {
        $email_error = "Preencha seu e-mail";
    } elseif (empty($_POST['senha'])) {
        $senha_error = "Preencha sua senha";
    } else {
        $email = $conn->real_escape_string($_POST['email']); 
        $senha = $_POST['senha']; 

        $sql_code = "SELECT * FROM usuarios WHERE email ='$email'";
        $sql_query = $conn->query($sql_code) or die("Falha no SQL: " . $conn->error);

        if ($sql_query->num_rows == 1) {
            $usuario = $sql_query->fetch_assoc();

            if ($senha === $usuario['senha']) {
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['nome'] = $usuario['nome'];

                header("Location: ../feed/painel.php"); 
                exit;
            } else {
                $senha_error = "Senha incorreta!";
            }
        } else {
            $email_error = "E-mail não encontrado!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body> 
<div class="login-container">
    <h2>Acesse sua conta</h2>

    <form action="" method="POST">

        <div class="input-group">
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" placeholder="Digite seu e-mail" 
                value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required />
            <?php if ($email_error): ?>
                <div class="text-danger"><?= $email_error ?></div>
            <?php endif; ?>
        </div>

        <div class="input-group">
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required />
            <?php if ($senha_error): ?>
                <div class="text-danger"><?= $senha_error ?></div>
            <?php endif; ?>
        </div>

        <input type="submit" value="Entrar" />
    </form>

    <button onclick="window.location.href='../cadastro/cadastro.php'" type="button" class="btn-cadastrar">Cadastrar</button>

    <div class="recuperar-senha">
        <a href="../cadastro/recuperar.php">Recuperar Senha</a>
    </div>
</div>
</body>
</html>
