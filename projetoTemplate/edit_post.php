<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bdBlog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["id"])) {
        $post_id = $_GET["id"];
        $sql = "SELECT * FROM posts WHERE id = $post_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $post = $result->fetch_assoc();
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["post_id"])) {
        $post_id = $_POST["post_id"];
        $new_title = $_POST["new_title"];
        $new_content = $_POST["new_content"];
        $new_hyperlink = $_POST["new_hyperlink"];

        // Verificar se uma nova imagem foi enviada
        if (isset($_FILES["new_image"]) && $_FILES["new_image"]["error"] === UPLOAD_ERR_OK) {
            $image_filename = $_FILES["new_image"]["name"];
            $image_path = "imgs/" . $image_filename;
            move_uploaded_file($_FILES["new_image"]["tmp_name"], $image_path);
            
            // Atualizar o campo image_filename no banco de dados
            $stmt = $conn->prepare("UPDATE posts SET title=?, content=?, hyperlink=?, image_filename=? WHERE id=?");
            $stmt->bind_param("ssssi", $new_title, $new_content, $new_hyperlink, $image_filename, $post_id);
        } else {
            // Caso não tenha uma nova imagem, execute a atualização sem o campo image_filename
            $stmt = $conn->prepare("UPDATE posts SET title=?, content=?, hyperlink=? WHERE id=?");
            $stmt->bind_param("sssi", $new_title, $new_content, $new_hyperlink, $post_id);
        }

        if ($stmt->execute()) {
            // Redirecionar para a página de edição com mensagem de sucesso
            header("Location: edit_post.php?id=$post_id&success=1");
            exit();
        } else {
            echo "Erro ao editar a postagem: " . $stmt->error;
        }
    }
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
                <li><a href="posts_list.php">Edição de Publicações</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Editar Postagem</h2>

        <?php if (isset($post)) : ?>
        <form action="edit_post.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">

            <label for="new_title">Título:</label>
            <input type="text" id="new_title" name="new_title" value="<?php echo $post['title']; ?>"><br>

            <label for="new_content">Conteúdo:</label>
            <textarea id="new_content" name="new_content" rows="4"><?php echo $post['content']; ?></textarea><br>

            <label for="new_image">Nova Imagem:</label>
            <input type="file" id="new_image" name="new_image"><br>
            <?php if ($post['image_filename']) : ?>
                <p>Imagem atual: <img src="imgs/<?php echo $post['image_filename']; ?>" alt="Imagem"></p>
            <?php endif; ?>

            <label for="new_hyperlink">Hyperlink:</label>
            <input type="text" id="new_hyperlink" name="new_hyperlink" value="<?php echo $post['hyperlink']; ?>"><br>

            <button type="submit">Salvar</button>
        </form>
        <?php if (isset($_GET["success"]) && $_GET["success"] == 1) : ?>
            <p>Alterado com sucesso!</p>
            <script>
                setTimeout(function() {
                    window.location.href = "index.html";
                }, 3000); // Redirecionar após 3 segundos
            </script>
        <?php endif; ?>
        <?php else : ?>
        <p>Postagem não encontrada.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2023 Blog Empresarial. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
