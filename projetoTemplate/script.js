document.addEventListener("DOMContentLoaded", function() {
    const postForm = document.getElementById("post-form");

    postForm.addEventListener("submit", function(event) {
        event.preventDefault();

        const title = document.getElementById("title").value;
        const content = document.getElementById("content").value;
        const image = document.getElementById("image").value;
        const hyperlink = document.getElementById("hyperlink").value;

        const postData = {
            title: title,
            content: content,
            image: image,
            hyperlink: hyperlink
        };

        fetch("insert_post.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(postData)
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            postForm.reset();
        })
        .catch(error => console.error("Erro:", error));
    });
});
