<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bdBlog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtenha os valores dos campos do formulário
$title = $_POST['title'];
$content = $_POST['content'];
$image = $_POST['image'];
$hyperlink = $_POST['hyperlink'];

// Prepare e execute a consulta SQL para inserir a publicação
$stmt = $conn->prepare("INSERT INTO posts (title, content, image, hyperlink) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $title, $content, $image, $hyperlink);

if ($stmt->execute()) {
    $conn->close();
    header("Location: entry.html?success=true"); // Redirecionar com um parâmetro de sucesso
    exit();
} else {
    $conn->close();
    header("Location: entry.html?error=true"); // Redirecionar com um parâmetro de erro, se necessário
    exit();
}
?>
