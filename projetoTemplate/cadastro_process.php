<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recupera os valores do formulário
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // Conecta ao banco de dados (substitua pelos dados do seu banco)
    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "bdBlog";
    
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);
    
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Hash da senha (utilize uma função de hash segura, como password_hash)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insere os dados na tabela de usuários
    $sql = "INSERT INTO users (username, password, telefone) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $hashed_password, $phone);
    
    if ($stmt->execute()) {
        // Cadastro realizado com sucesso
        header("Location: login.html?success=1");
        exit();
    } else {
        // Erro ao cadastrar
        echo "Erro: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>
