// Login form
const login_form = document.getElementById("login_form");

login_form.addEventListener("submit", async (e) => {
   e.preventDefault();
   const email = document.getElementById("email").value;
   const password = document.getElementById("password").value;

   if (email.length !== 0 && password.length !== 0) {
      if (email.match(/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/)) {
         if (password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/)) {
            const formdata = {
               email,
               password,
            };

            const response = await fetch("./controllers/php/login.php", {
               method: "POST",
               headers: {
                  "Content-Type": "application/json",
               },
               body: JSON.stringify(formdata),
            });
            const data = await response.json();

            // get data array from php
            if (data[0] === "error") {
               alert(data[1]);
            }

            console.log(data);
         } else {
            alert("Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial");
         }
      } else {
         alert("Veuillez entrer une adresse mail valide");
      }
   } else {
      alert("Veuillez remplir tous les champs");
   }
});