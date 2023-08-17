document.addEventListener("DOMContentLoaded", function() {
    const blogContainer = document.getElementById("blog-container");

    // Buscar as publicações do servidor usando fetch
    fetch("get_post.php")
        .then(response => response.json())
        .then(data => {
            data.forEach(post => {
                const article = document.createElement("article");
                article.innerHTML = `
                    <h2>${post.title}</h2>
                    <p>${post.content}</p>
                `;
                blogContainer.appendChild(article);
            });
        })
        .catch(error => console.error("Erro:", error));
});
