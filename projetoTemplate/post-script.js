document.addEventListener("DOMContentLoaded", function() {
    const postForm = document.getElementById("post-form");

    postForm.addEventListener("submit", function(event) {
        event.preventDefault();

        const title = document.getElementById("title").value;
        const content = document.getElementById("content").value;
        const user_id = parseInt(document.getElementById("user_id").value);

        // Enviar os dados para o servidor usando AJAX, fetch, ou outro método
        // Exemplo fictício usando fetch:

        fetch("insert_post.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ title, content, user_id }),
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            postForm.reset();
        })
        .catch(error => console.error("Erro:", error));
    });
});
