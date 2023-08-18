document.addEventListener("DOMContentLoaded", function() {
    const blogContainer = document.getElementById("blog-container");

    // Buscar as publicações do servidor usando fetch
    fetch("get_posts.php")
        .then(response => response.json())
        .then(data => {
            data.forEach(post => {
                const article = document.createElement("article");
                article.innerHTML = `
                    <h2>${post.title}</h2>
                    <p>${post.content}</p>
                    <img src="${post.image}" alt="Imagem">
                    <a href="${post.hyperlink}" target="_blank">${post.hyperlink}</a>
                `;
                blogContainer.appendChild(article);
            });
        })
        .catch(error => console.error("Erro:", error));
});
