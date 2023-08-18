<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Legalbot Compliance - DayOn</title>
</head>
<body>
    <header>
        <h1>Legalbot Compliance</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="entry.html">Nova Publicação</a></li>
                <li><a href="posts_list.php">Edição de Publicações</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Lista de Postagens</h2>
        <ul id="post-titles">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bdBlog";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM posts";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li><a href='edit_post.php?id={$row['id']}'>{$row['title']}</a> <button onclick='deletePost({$row['id']})'>Excluir</button></li>";
                }
            } else {
                echo "<li>Nenhuma postagem encontrada.</li>";
            }

            $conn->close();
            ?>
        </ul>
    </main>

    <footer>
        <p>&copy; 2023 Blog Empresarial. Todos os direitos reservados.</p>
    </footer>

    <!-- Script para deletar postagem -->
    <script>
        function deletePost(id) {
            const confirmation = confirm("Tem certeza que deseja excluir esta postagem?");
            if (confirmation) {
                fetch("delete_post.php", {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "id=" + id
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload(); // Recarrega a página após a exclusão
                })
                .catch(error => console.error("Erro:", error));
            }
        }
    </script>
</body>
</html>
