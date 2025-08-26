<?php
  include '../include/header.php'; 
  ?>
<?php
include '../config/db.php';

if(isset($_POST['email']) || isset($_POST['senha'])) {
    if(strlen($_POST['email']) == 0){
        echo "preencha seu email";
    } else if(strlen($_POST['senha']) == 0){
        echo "preencha sua senha";
    } else {
        $email = $conn->real_escape_string($_POST['email']);
        $senha = $conn->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM usuarios WHERE email ='$email' 
        AND senha = '$senha' ";

        $sql_query = $conn->query($sql_code) or
         die("Falha na execução do codigo SQL: " . $$conn->error);

        $quantidade = $sql_query->num_rows;
        
        if($quantidade == 1 ) {
            $ususrio = $sql_query->fetch_assoc();
            
            if(!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['id'] = $ususrio['id'];
            $_SESSION['nome'] = $ususrio['nome'];

           header("Location: ../feed/painel.php");
        }else {
            echo "Falha ao logar! E-mail ou senha incorreta";
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
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Acesse sua conta</h1>
    <form action="" method="POST">
    <p>
        <label>E-mail</label>
        <input type="text" name="email">
        
    </p>
    <p>
        <label>Senha</label>
        <input type="password" name="senha">
    </p>
    <p>
        <button type="submit">Entrar</button>
    </p> 
</form>       
</body>
</html>