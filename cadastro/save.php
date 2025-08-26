<?php 
    include '../config/db.php';


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome     = $_POST['nome'];
    $usuario  = $_POST['usuario'];
    $email    = $_POST['email'];
    $senha    = $_POST['senha'];
    
    //$senha    = password_hash($_POST['senha'], PASSWORD_DEFAULT);  // Hash da senha

     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: cadastro.php?error=email&msg=E-mail inválido!");
        exit; // interrompe a execução se não for válido
    }

    // Verifica se o email já está cadastrado
    $check = $conn->prepare("SELECT * FROM usuarios WHERE email=? ");
    $check->bind_param("s", $email);
    $check->execute();
    $resultEmail = $check->get_result();
    
    // Verifica se o usuário já está cadastrado
    $check = $conn->prepare("SELECT * FROM usuarios WHERE usuario=?");
    $check->bind_param("s", $usuario);
    $check->execute();
    $resultUsuario = $check->get_result();

    if ($resultEmail->num_rows > 0) {
        header("Location: cadastro.php?error=email&msg=E-mail já cadastrado!");
    } elseif ($resultUsuario->num_rows > 0) {
        header("Location: cadastro.php?error=usuario&msg=Usuário já cadastrado!");
    }else {
        $sql = $conn->prepare("INSERT INTO usuarios (nome, usuario, email, senha) VALUES (?, ?, ?, ?)");
        $sql->bind_param("ssss", $nome, $usuario, $email, $senha);
        if ($sql->execute()) {
            header("Location: cadastro.php?success=Cadastro realizado com sucesso!");
        } else {
            header("Location: cadastro.php?error=geral&msg=Erro ao cadastrar!");
        }
    }
}
    