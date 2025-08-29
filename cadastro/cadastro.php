<?php 
    include '../config/db.php';
    include '../include/header.php'; 
?>

    <!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mensagem de Erro</title>
    <link rel="stylesheet" href="../css/cadastro.css" />
<div class="cadastro-container">
    <h2 class="mb-4">Cadastro</h2>
    <link rel="stylesheet" href="../css/cadastro.css"> 

    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success" id="successMessage"> 
        <?php echo htmlspecialchars($_GET['success']); ?> 
    </div>

    <script>
        // Redireciona após 5 segundos
        setTimeout(function() {
            window.location.href = '../login/index.php';
        }, 5000);
    </script>
    <?php endif; ?>


</head>
<body>
    <form action="save.php" method="POST" id="formPessoa">

        <div class="input-group">
            <label for="nome" class="form-label">Nome Completo:</label>
            <input type="text" name="nome" id="nome" placeholder="Digite seu nome completo" class="form-control" required>
        </div>

        <div class="input-group">
            <label for="usuario" class="form-label">Nome de Usuário:</label>
            <input type="text" name="usuario" id="usuario" placeholder="Digite seu nome de usuário" class="form-control" required
            value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''; ?>">
            <?php if (isset($_GET['error']) && $_GET['error'] == 'usuario'): ?>
                <div class="text-danger"><?php echo htmlspecialchars($_GET['msg']); ?></div>
            <?php endif; ?>
        </div>

        <div class="input-group">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" name="email" id="email" placeholder="Digite seu e-mail" class="form-control" required
            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            <?php if (isset($_GET['error']) && $_GET['error'] == 'email'): ?>
                <div class="text-danger"><?php echo htmlspecialchars($_GET['msg']); ?></div>
            <?php endif; ?>
        </div>

        <div class="input-group">
            <label for="senha" class="form-label">Senha:</label>
            <input type="password" name="senha" id="senha" placeholder="Digite sua senha" class="form-control" required>
            <?php if (isset($_GET['error']) && $_GET['error'] == 'senha'): ?>
                <div class="text-danger"><?php echo htmlspecialchars($_GET['msg']); ?></div>
            <?php endif; ?>
        </div>

        <div class="botoes-container">
            <button type="submit" class="btn-cadastrar">Cadastrar</button>
            <button type="button" class="btn-cancelar" onclick="window.location.href='../login/index.php'">Cancelar</button>
        </div>

    </form>
</div>
    <?php if (!empty($errorMessage)): ?>
        <div class="error-box" role="alert" aria-live="assertive">
            <p><?php echo htmlspecialchars($errorMessage); ?></p>
            <code><?php echo htmlspecialchars($errorCode); ?></code>
        </div>
    <?php endif; ?>
    </body>
</html>

<?php 
    include '../include/footer.php'; 
?>
