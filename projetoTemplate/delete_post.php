<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bdBlog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    parse_str(file_get_contents("php://input"), $data); // Captura dados do corpo da requisição
    $post_id = $data["id"];

    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {
        $response = array("message" => "Postagem excluída com sucesso!");
    } else {
        $response = array("message" => "Erro ao excluir postagem: " . $stmt->error);
    }

    header("Content-Type: application/json");
    echo json_encode($response);
}

$conn->close();
?>
