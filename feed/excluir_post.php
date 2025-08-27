<?php
session_start();
include("../config/db.php");
include("../login/protect.php");

$usuario_logado = $_SESSION['id'] ?? 0;

if(isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Verifica se a postagem pertence ao usuário logado
    $sql = "SELECT imagem FROM postagens WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $usuario_logado);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $imagem = $row['imagem'];

        // Deleta a postagem do banco
        $sql_del = "DELETE FROM postagens WHERE id = ?";
        $stmt_del = $conn->prepare($sql_del);
        $stmt_del->bind_param("i", $id);
        $stmt_del->execute();

        // Deleta a imagem do servidor
        if($imagem && file_exists("../uploads/".$imagem)){
            unlink("../uploads/".$imagem);
        }

        echo "ok";
    } else {
        http_response_code(403);
        echo "Você não pode excluir esta postagem.";
    }
} else {
    http_response_code(400);
    echo "ID não informado.";
}
