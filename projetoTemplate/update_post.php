<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bdBlog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$message = ""; // Variável para armazenar a mensagem de sucesso ou erro

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $post_id = $_POST["post_id"];
    $new_title = $_POST["new_title"];
    $new_content = $_POST["new_content"];
    $new_image = $_POST["new_image"];
    $new_hyperlink = $_POST["new_hyperlink"];

    $stmt = $conn->prepare("UPDATE posts SET title=?, content=?, image=?, hyperlink=? WHERE id=?");
    $stmt->bind_param("ssssi", $new_title, $new_content, $new_image, $new_hyperlink, $post_id);

    if ($stmt->execute()) {
        $message = "Alterado com sucesso!";
        header("Refresh: 1; url=posts_list.php"); // Redirecionar após 3 segundos
    } else {
        $message = "Erro ao atualizar a postagem: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Editar Postagem</title>
</head>
<body>
    <header>
        <h1>Blog Empresarial</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="entry.html">Nova Publicação</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Editar Postagem</h2>
        
        <?php echo $message; ?> <!-- Exibir a mensagem aqui -->
        
        <?php if (isset($post)) : ?>
        <form action="update_post.php" method="post">
            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
            
            <!-- Campos do formulário aqui -->
            
            <button type="submit">Salvar</button>
        </form>
        <?php else : ?>
        <p>Postagem não encontrada.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2023 Blog Empresarial. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
