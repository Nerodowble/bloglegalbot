<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Realize as validações necessárias

    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "bdBlog";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login bem-sucedido, redirecionar para a página desejada
        header("Location: index.html");
        exit();
    } else {
        echo "Usuário ou senha incorretos.";
    }

    $conn->close();
}
?>
