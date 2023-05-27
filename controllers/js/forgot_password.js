// Forgot password form
const forgot_password_form = document.getElementById("forgot_password_form");

forgot_password_form.addEventListener("submit", async (e) => {
	e.preventDefault();
	const email = document.getElementById("email").value;

	if (email.length !== 0) {
		if (email.match(/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/)) {
			const formdata = {
				email: email,
			};

			const response = await fetch(
				"./controllers/php/forgot_password.contr.php",
				{
					method: "POST",
					headers: {
						"Content-Type": "application/json",
					},
					body: JSON.stringify(formdata),
				}
			);
			const data = await response.json();
			console.log(data);

			if (data.success) {
				window.location.href = "./?";
			} else if (data.error) {
				alert(data.error);
			} else {
				alert("Erreur lors de la réinitialisation du mot de passe");
			}
		} else {
			alert(
				"L'adresse mail doit contenir au moins un @ et un point après le @"
			);
		}
	} else {
		alert("Veuillez entrer une adresse mail valide");
	}
});
