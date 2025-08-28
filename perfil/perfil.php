<?php
session_start();
include("../config/db.php");
include("../login/protect.php");

$usuario_id = $_SESSION['id'] ?? 0;
if ($usuario_id == 0) {
    header("Location: ../login/index.php");
    exit;
}

// Função para buscar dados do usuário
function buscarUsuario($conn, $id) {
    $sql = "SELECT nome, usuario, email, senha FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

$usuario = buscarUsuario($conn, $usuario_id);

// Função para verificar se email existe em outro usuário
function emailExiste($conn, $email, $usuario_id) {
    $sql = "SELECT id FROM usuarios WHERE email = ? AND id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $email, $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Função para verificar se nome de usuário existe em outro usuário
function usuarioExiste($conn, $usuario_nome, $usuario_id) {
    $sql = "SELECT id FROM usuarios WHERE usuario = ? AND id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $usuario_nome, $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Validação nome pessoal: letras (com acentos), espaços e traços, mínimo 3 caracteres
function validarNomePessoal($nome) {
    if (strlen($nome) < 3) {
        return "Nome pessoal deve ter pelo menos 3 caracteres.";
    }
    // Regex: letras (incluindo acentos), espaços e traços
    if (!preg_match("/^[a-zA-ZÀ-ÿ\s\-]+$/u", $nome)) {
        return "Nome pessoal só pode conter letras, espaços e traços.";
    }
    return "";
}

// Validação nome de usuário: permite letras, números, < > _ ; não permite ^ ~ / ? ! @ # $ % & * + ) ( = " ' . ,
function validarNomeUsuario($usuario_nome) {
    if (strlen($usuario_nome) < 3) {
        return "Nome de usuário deve ter pelo menos 3 caracteres.";
    }
    // Regex: permite letras, números, < > _ ; proíbe os caracteres listados
    if (preg_match("/[\^~\/\?\!@#\$%&\*\+\)\(=\"'\.,]/", $usuario_nome)) {
        return "Nome de usuário contém caracteres inválidos.";
    }
    return "";
}

// Atualizar nome pessoal, nome de usuário e/ou email
if (isset($_POST['atualizar_dados'])) {
    $novo_nome = trim($_POST['nome'] ?? '');
    $novo_usuario = trim($_POST['usuario'] ?? '');
    $novo_email = trim($_POST['email'] ?? '');

    // Validações
    $erro = "";

    if ($novo_nome !== '') {
        $erro = validarNomePessoal($novo_nome);
        if ($erro !== "") {
            $_SESSION['erro'] = $erro;
        }
    }

    if ($erro === "" && $novo_usuario !== '') {
        $erro = validarNomeUsuario($novo_usuario);
        if ($erro !== "") {
            $_SESSION['erro'] = $erro;
        }
    }

    if ($erro === "" && $novo_email !== '') {
        if (!filter_var($novo_email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['erro'] = "Email inválido.";
        }
    }

    if (!isset($_SESSION['erro'])) {
        $atualizar_nome = false;
        $atualizar_usuario = false;
        $atualizar_email = false;

        // Verifica nome pessoal
        if ($novo_nome !== '' && $novo_nome !== $usuario['nome']) {
            $atualizar_nome = true;
        } elseif ($novo_nome === $usuario['nome']) {
            $_SESSION['erro'] = "O nome pessoal inserido já é o atual.";
        }

        // Verifica nome de usuário
        if (!isset($_SESSION['erro'])) {
            if ($novo_usuario !== '' && $novo_usuario !== $usuario['usuario']) {
                if (usuarioExiste($conn, $novo_usuario, $usuario_id)) {
                    $_SESSION['erro'] = "Nome de usuário já usado.";
                } else {
                    $atualizar_usuario = true;
                }
            } elseif ($novo_usuario === $usuario['usuario']) {
                $_SESSION['erro'] = "O nome de usuário inserido já é o atual.";
            }
        }

        // Verifica email
        if (!isset($_SESSION['erro'])) {
            if ($novo_email !== '' && $novo_email !== $usuario['email']) {
                if (emailExiste($conn, $novo_email, $usuario_id)) {
                    $_SESSION['erro'] = "Email inválido.";
                } else {
                    $atualizar_email = true;
                }
            } elseif ($novo_email === $usuario['email']) {
                $_SESSION['erro'] = "O email inserido já é o atual.";
            }
        }

        if (!isset($_SESSION['erro'])) {
            // Monta query dinamicamente conforme o que será atualizado
            $campos = [];
            $params = [];
            $tipos = "";

            if ($atualizar_nome) {
                $campos[] = "nome = ?";
                $params[] = $novo_nome;
                $tipos .= "s";
            }
            if ($atualizar_usuario) {
                $campos[] = "usuario = ?";
                $params[] = $novo_usuario;
                $tipos .= "s";
            }
            if ($atualizar_email) {
                $campos[] = "email = ?";
                $params[] = $novo_email;
                $tipos .= "s";
            }

            if (count($campos) === 0) {
                $_SESSION['erro'] = "Nenhum dado para atualizar.";
            } else {
                $sql = "UPDATE usuarios SET " . implode(", ", $campos) . " WHERE id = ?";
                $params[] = $usuario_id;
                $tipos .= "i";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param($tipos, ...$params);

                if ($stmt->execute()) {
                    $_SESSION['sucesso'] = "Dados atualizados com sucesso!";
                    header("Location: perfil.php");
                    exit;
                } else {
                    $_SESSION['erro'] = "Erro ao atualizar dados.";
                }
            }
        }
    }
}

// Atualizar senha (texto simples, sem limite mínimo)
if (isset($_POST['atualizar_senha'])) {
    $senha_atual = $_POST['senha_atual'] ?? '';
    $nova_senha = $_POST['nova_senha'] ?? '';

    if ($senha_atual === '' || $nova_senha === '') {
        $_SESSION['erro'] = "Preencha todos os campos de senha.";
    } elseif ($senha_atual !== $usuario['senha']) {
        $_SESSION['erro'] = "Senha atual incorreta.";
    } elseif ($nova_senha === $usuario['senha']) {
        $_SESSION['erro'] = "A senha inserida já é a atual.";
    } else {
        $sql = "UPDATE usuarios SET senha = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nova_senha, $usuario_id);
        if ($stmt->execute()) {
            $_SESSION['sucesso'] = "Senha alterada com sucesso!";
            header("Location: perfil.php");
            exit;
        } else {
            $_SESSION['erro'] = "Erro ao atualizar senha.";
        }
    }
    header("Location: perfil.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="../css/painel.css">
    <script src="../js/perfil.js"></script>
</head>
<body>
    <h1>Meu Perfil</h1>

    <?php if (isset($_SESSION['sucesso'])): ?>
        <p class="sucesso"><?php echo htmlspecialchars($_SESSION['sucesso']); unset($_SESSION['sucesso']); ?></p>
    <?php endif; ?>
    <?php if (isset($_SESSION['erro'])): ?>
        <p class="erro"><?php echo htmlspecialchars($_SESSION['erro']); unset($_SESSION['erro']); ?></p>
    <?php endif; ?>

    <fieldset>
        <legend>Atualizar Nome Pessoal</legend>
        <form method="POST" novalidate>
            <label for="nome">Nome pessoal:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" minlength="3" maxlength="100">
            <button type="submit" name="atualizar_dados">Atualizar Dados</button>
        </form>
    </fieldset>
    <fieldset>
        <legend>Atualizar Nome de Usuário</legend>
        <form method="POST" novalidate>
            <label for="usuario">Nome de usuário:</label>
            <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($usuario['usuario']); ?>" minlength="3" maxlength="50">
            <button type="submit" name="atualizar_dados">Atualizar Dados</button>
        </form>
    </fieldset>
    <fieldset>
        <legend>Atualizar Email</legend>
        <form method="POST" novalidate id="formAtualizarDados">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>">

            <button type="submit" name="atualizar_dados">Atualizar Dados</button>
        </form>
    </fieldset>

    <fieldset>
        <legend>Alterar Senha</legend>
        <form method="POST" novalidate>
            <label for="senha_atual">Senha atual:</label>
            <input type="password" id="senha_atual" name="senha_atual">

            <label for="nova_senha">Nova senha:</label>
            <input type="password" id="nova_senha" name="nova_senha">

            <button type="submit" name="atualizar_senha">Alterar Senha</button>
        </form>
    </fieldset>

    <br>
    <a href="../feed/painel.php">⬅ Voltar ao Painel</a>
</body>
</html>
