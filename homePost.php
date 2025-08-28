<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Newsfeed</title>
</head>
<body>
    <form id="postForm" enctype="multipart/form-data">
        <textarea name="text" placeholder="What's on your mind?"></textarea>
        <input type="file" name="images[]" multiple>
        <button type="submit">Post</button>
    </form>
    <div id="newsfeed"></div>

    <script>
        document.getElementById('postForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('upload1.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            fetchPosts(); // Refresh the posts display
        })
        .catch(error => console.error('Error:', error));
    });

    function fetchPosts() {
        fetch('fetchPost.php')
        .then(response => response.json())
        .then(posts => {
            const newsfeed = document.getElementById('newsfeed');
            newsfeed.innerHTML = '';
            posts.forEach(post => {
                const postElement = document.createElement('div');
                postElement.innerHTML = `
                    <p>${post.content}</p>
                    ${post.images.map(image => `<img src="${image}" style="width: 100px; height: auto;">`).join('')}
                    <hr>
                `;
                newsfeed.appendChild(postElement);
            });
        });
    }

    window.onload = fetchPosts;

    </script>
</body>
</html>
