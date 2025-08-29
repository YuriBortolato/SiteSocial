function excluirPost(id) {
    if (!confirm('Tem certeza que deseja excluir esta postagem?')) return;

    fetch('excluir_post.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + id
    })
    .then(response => response.json())
    .then(data => {
        const div = document.getElementById('post-' + id);
        if(div) div.remove();

        const mensagensContainer = document.querySelector('.mensagens');
        if(mensagensContainer) {
            mensagensContainer.innerHTML = ''; // limpa mensagens antigas

            const popup = document.createElement('div');
            popup.className = data.status === 'sucesso' ? 'alert-success' : 'error-box';
            popup.textContent = data.mensagem;
            mensagensContainer.appendChild(popup);

            // Remove automaticamente depois do tempo
            const tempo = data.status === 'sucesso' ? 3000 : 5000;
            setTimeout(() => { popup.remove(); }, tempo);
        }
    })
    .catch(error => {
        const mensagensContainer = document.querySelector('.mensagens');
        if(mensagensContainer) {
            mensagensContainer.innerHTML = '';
            const popup = document.createElement('div');
            popup.className = 'error-box';
            popup.textContent = 'Erro ao excluir postagem.';
            mensagensContainer.appendChild(popup);
            setTimeout(() => { popup.remove(); }, 5000);
        }
    });
}


// Remove mensagens de sucesso/erro automaticamente ao carregar a página
document.addEventListener("DOMContentLoaded", () => {
    const mensagens = document.querySelectorAll(".alert-success, .error-box");
    mensagens.forEach(msg => {
        const tempo = msg.classList.contains("alert-success") ? 3000 : 5000; // 3s sucesso, 5s erro
        setTimeout(() => {
            msg.remove();
        }, tempo);
    });
});
