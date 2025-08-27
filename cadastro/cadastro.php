<?php 
    include '../config/db.php';
    include '../include/header.php'; 
?>


<div class="container mt-4">
    <h2 class="mb-4">Cadastro</h2>

    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success" id="successMessage"> 
        <?php echo htmlspecialchars($_GET['success']); ?> 
    </div>

    <script>
        // Redireciona após 10 segundos
        setTimeout(function() {
            window.location.href = '../login/index.php';
        }, 5000); // 5000 milissegundos = 5 segundos
    </script>
<?php endif; ?>
    <form action="save.php" method="POST" id="formPessoa">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome Completo:</label>
            <input type="text" name="nome" id="nome" placeholder="Digite seu nome completo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="usuario" class="form-label">Nome de Usuário:</label>
            <input type="text" name="usuario" id="usuario" placeholder="Digite seu nome de usuário" class="form-control" required
            value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''; ?>">
            <?php if (isset($_GET['error']) && $_GET['error'] == 'usuario'): ?>
            <div class="text-danger"><?php echo htmlspecialchars($_GET['msg']); ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" name="email" id="email" placeholder="Digite seu e-mail" class="form-control" required
            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            <?php if (isset($_GET['error']) && $_GET['error'] == 'email'): ?>
            <div class="text-danger"><?php echo htmlspecialchars($_GET['msg']); ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha:</label>
            <input type="password" name="senha" id="senha" placeholder="Digite sua senha" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
        <a href="../login/index.php" class="btn btn-danger">Cancelar</a>
    </form>
</div>


<?php 
    include '../include/footer.php'; 
?>
