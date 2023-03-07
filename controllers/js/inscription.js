// Register form
const register_form = document.getElementById("register_form");

register_form.addEventListener("submit", async (e) => {
   e.preventDefault();
   const firstname = document.getElementById("firstname").value;
   const lastname = document.getElementById("lastname").value;
   const birthdate = document.getElementById("birthdate").value;
   const email = document.getElementById("email").value;
   const password = document.getElementById("password").value;
   const confirm_password = document.getElementById("confirm_password").value;

   if (firstname.length !== 0 && lastname.length !== 0 && birthdate.length !== 0 && email.length !== 0 && password.length !== 0 && confirm_password.length !== 0) {
      if (email.match(/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/)) {
         if (password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/)) {
            if (password === confirm_password) {
               const formdata = {
                  firstname,
                  lastname,
                  birthdate,
                  email,
                  password,
                  confirm_password
               };

               const response = await fetch("./controllers/php/register.php", {
                  method: "POST",
                  headers: {
                     "Content-Type": "application/json",
                  },
                  body: JSON.stringify(formdata),
               });
               const data = await response.json();
               console.log(data);

               if (data.success) {
                  window.location.href = "./?";
               } else if (data.error) {
                  alert(data.error);
               } else {
                  alert("Erreur lors de l'inscription");
               }

            } else {
               alert("Les mots de passe ne correspondent pas");
            }
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