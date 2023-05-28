const add_button = document.getElementById("add_comment");

window.onload = () => {
  const commentsContainer = document.querySelector(".comment_container");
  commentsContainer.scrollTop = commentsContainer.scrollHeight;
};

add_button.addEventListener("click", async (e) => {
  e.preventDefault();

  const commentMediaId = document.getElementById("commentMediaId").value;
  const commentUserId = document.getElementById("commentUserId").value;
  const commentRating = document.querySelector(
    "input[name='rating']:checked"
  ).value;
  const commentText = document.getElementById("commentText").value;
  const commentStatus = "ok";
  const commentDate = new Date().toISOString().slice(0, 19).replace("T", " ");

  if (commentRating.length !== 0 && commentText.length !== 0) {
    const formData = {
      commentMediaId,
      commentUserId,
      commentRating,
      commentText,
      commentStatus,
      commentDate,
    };

    const response = await fetch("./controllers/php/comments.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(formData),
    });
    const data = await response.json();
    console.log(data);

    if (data.success) {
      const comment = document.querySelector(".comments");
      const commentCount = document.querySelectorAll(".comment");

      if (commentCount.length === 0) {
        comment.innerHTML = "";
      }

      comment.innerHTML += `
	  <div class="comment">
	                    <div class="profile_pic">
                            <img src="./assets/img/icons/user.jpg" alt="user" width="50px" style="border-radius: 25px;">
                        </div>
                        <div class="comment_body" style="display:flex;flex-direction:column;">
                            <div class="comment_info" style="display:flex;gap:1rem;">
                                <p class="username" style="color:#555;">${
                                  data.user
                                }</p>
                                <p class="comment_date" style="color:#888;">${new Date(
                                  formData.commentDate
                                ).toLocaleDateString("fr-FR", {
                                  year: "numeric",
                                  month: "numeric",
                                  day: "numeric",
                                })}</p>
                            </div>
                            <div class="comment_rating">
								${
                  "<i class='full-star'></i>".repeat(formData.commentRating) +
                  "<i class='empty-star'></i>".repeat(
                    5 - formData.commentRating
                  )
                }
							</div>
                            <p class="comment_text" style="font-size: 18px;">${
                              formData.commentText
                            }</p>
                        </div>
		</div>
						`;
      document.getElementById("commentText").value = "";
      document.querySelector("input[name='rating']:checked").checked = false;
      document.querySelector(".comment_container").scrollTop =
        document.querySelector(".comment_container").scrollHeight;
    } else if (data.error) {
      alert(data.error);
    } else {
      alert("Erreur lors de l'ajout du commentaire");
    }
  } else {
    alert("Veuillez remplir tous les champs");
  }
});
