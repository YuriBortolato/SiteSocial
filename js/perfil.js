document.addEventListener('DOMContentLoaded', function() {
    const formEmail = document.getElementById('formAtualizarDados');
    if (!formEmail) return;

    const emailAtual = formEmail.getAttribute('data-email');

    formEmail.addEventListener('submit', function(e) {
        const emailNovo = formEmail.email.value.trim();

        if (emailNovo !== '' && emailNovo !== emailAtual) {
            const confirmacao = confirm("Tem certeza que quer atualizar esse email? Você não conseguirá logar com o email antigo mais.");
            if (!confirmacao) {
                e.preventDefault();
            }
        }
    });
});
