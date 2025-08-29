<?php
session_start();
include("../config/db.php");
include("../login/protect.php");

$usuario_logado = $_SESSION['id'] ?? 0;

header('Content-Type: application/json');

if(isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $sql = "SELECT imagem FROM postagens WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $usuario_logado);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $imagem = $row['imagem'];

        $sql_del = "DELETE FROM postagens WHERE id = ?";
        $stmt_del = $conn->prepare($sql_del);
        $stmt_del->bind_param("i", $id);

        if($stmt_del->execute()) {
            if($imagem && file_exists("../uploads/".$imagem)){
                unlink("../uploads/".$imagem);
            }

            echo json_encode([
                'status' => 'sucesso',
                'mensagem' => 'Postagem excluída com sucesso!'
            ]);
        } else {
            echo json_encode([
                'status' => 'erro',
                'mensagem' => 'Erro ao excluir postagem: ' . $conn->error
            ]);
        }
    } else {
        http_response_code(403);
        echo json_encode([
            'status' => 'erro',
            'mensagem' => 'Você não pode excluir esta postagem.'
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'ID não informado.'
    ]);
}
