<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bdBlog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $imageFilename = $_FILES["image"]["name"]; // Alteração aqui
    $hyperlink = $_POST["hyperlink"];

    $stmt = $conn->prepare("INSERT INTO posts (title, content, image_filename, hyperlink) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        var_dump($conn->error);
        exit();
    }

    $stmt->bind_param("ssss", $title, $content, $imageFilename, $hyperlink); // Alteração aqui

    if ($stmt->execute()) {
        move_uploaded_file($_FILES["image"]["tmp_name"], "imgs/" . $imageFilename); // Salva a imagem no diretório "imgs"
        header("Location: entry.html?success=true"); // Redireciona para a página de entrada com mensagem de sucesso
    } else {
        echo "Erro ao salvar publicação: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
