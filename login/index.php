<?php
include '../include/header.php'; 
include '../config/db.php';

session_start();

if(isset($_POST['email']) || isset($_POST['senha'])) {

    if(strlen($_POST['email']) == 0){
        echo "Preencha seu email";
    } else if(strlen($_POST['senha']) == 0){
        echo "Preencha sua senha";
    } else {
        $email = $conn->real_escape_string($_POST['email']); // Protege contra SQL Injection
        $senha = $_POST['senha']; // Senha em texto puro

        // Busca o usuário pelo email
        $sql_code = "SELECT * FROM usuarios WHERE email ='$email'";
        $sql_query = $conn->query($sql_code) or die("Falha na execução do código SQL: " . $conn->error);

        if($sql_query->num_rows == 1 ) {
            $usuario = $sql_query->fetch_assoc(); // pega os dados do usuário

            
             if($senha === $usuario['senha']) { // Verifica a senha

                $_SESSION['id'] = $usuario['id'];
                $_SESSION['nome'] = $usuario['nome'];

                header("Location: ../feed/painel.php"); // Redireciona para a página do feed
                exit;
            } else {
                echo "<div class='text-danger'>Senha incorreta!</div>";
            }
        } else {
            echo "<div class='text-danger'>E-mail não encontrado!</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/sitesocial/css/login.css">

</head>
<body> 
<div class="container mt-4">
    <h2>Acesse sua conta</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Digite seu e-mail" required>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" name="senha" id="senha" class="form-control" placeholder="Digite sua senha" required>
        </div>
        <button type="submit" class="btn btn-primary">Entrar</button>
        <a href="../cadastro/cadastro.php" class="btn btn-secondary">Cadastrar</a>

        <div class="mt-2">
            <a href="../cadastro/recuperar.php">Recuperar Senha</a> 
        </div>

    </form>
</div>
</body>
</html>