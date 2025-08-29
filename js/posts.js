// Atualiza o nome do arquivo escolhido
const inputFile = document.getElementById("imagem");
const fileChosen = document.getElementById("file-chosen");

inputFile.addEventListener("change", function () {
    if (this.files && this.files.length > 0) {
        fileChosen.textContent = this.files[0].name;
    } else {
        fileChosen.textContent = "Nenhum arquivo selecionado";
    }
});

// Remove mensagens de erro após 5 segundos
document.addEventListener("DOMContentLoaded", () => {
    const mensagensErro = document.querySelectorAll(".error-box");
    mensagensErro.forEach(msg => {
        setTimeout(() => {
            msg.remove();
        }, 5000); // 5 segundos
    });
});
