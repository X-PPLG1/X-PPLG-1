document.getElementById("sendComment").addEventListener("click", function() {
    const username = document.getElementById("username").value;
    const message = document.getElementById("message").value;
  
    if (username && message) {
      // Kirim data ke server menggunakan fetch
      fetch("submit_comment.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "username=" + username + "&message=" + message
      })
      .then(response => response.text())
      .then(data => {
        if (data === "success") {
          alert("Komentar berhasil dikirim!");
          loadComments(); // Reload comments after posting
        } else {
          alert("Gagal mengirim komentar.");
        }
      });
    } else {
      alert("Nama dan komentar harus diisi!");
    }
  });
  
  // Fungsi untuk memuat komentar
  function loadComments() {
    fetch("get_comments.php")
      .then(response => response.json())
      .then(data => {
        const commentsContainer = document.getElementById("comments-container");
        commentsContainer.innerHTML = "";  // Clear the container before adding new comments
        data.forEach(comment => {
          const commentDiv = document.createElement("div");
          commentDiv.classList.add("comment");
          commentDiv.innerHTML = `<strong>${comment.username}</strong>: ${comment.message}`;
          commentsContainer.appendChild(commentDiv);
        });
      });
  }
  
  // Memuat komentar saat halaman pertama kali dimuat
  loadComments();
  