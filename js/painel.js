function excluirPost(id) {
    if (!confirm('Tem certeza que deseja excluir esta postagem?')) return;

    fetch('excluir_post.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + id
    })
    .then(response => response.text())
    .then(data => {
        const div = document.getElementById('post-' + id);
        if(div) div.remove();
    })
    .catch(error => alert('Erro ao excluir postagem.'));
}
