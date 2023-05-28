const add_button = document.getElementById("add_comment");

add_button.addEventListener("click", async (e) => {
	e.preventDefault();

	const commentMediaId = document.getElementById("commentMediaId").value;
	const commentUserId = document.getElementById("commentUserId").value;
	const commentRating = document.getElementById("commentRating").value;
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
			window.location.href = "./?view=" + commentMediaId;
		} else if (data.error) {
			alert(data.error);
		} else {
			alert("Erreur lors de l'ajout du commentaire");
		}
	} else {
		alert("Veuillez remplir tous les champs");
	}
});
