
document.getElementById('formAtualizarDados').addEventListener('submit', function(e) {
    // Pega o valor atual do email e o valor novo do campo email
    const emailAtual = "<?php echo addslashes($usuario['email']); ?>";
    const emailNovo = this.email.value.trim();
    if (emailNovo !== '' && emailNovo !== emailAtual) {
        const confirmacao = confirm("Tem certeza que quer atualizar esse email? Você não conseguirá logar com o email antigo mais.");
        if (!confirmacao) {
            e.preventDefault(); // cancela o envio do formulário
        }
    }
});
