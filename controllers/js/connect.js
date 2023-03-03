const form = document.getElementById("login_form");

form.addEventListener("submit", async (e) => {
   e.preventDefault();
   const email = document.getElementById("email").value;
   const password = document.getElementById("password").value;
   const formdata = {
      email,
      password,
   };

   const response = await fetch("./controllers/php/connect.php", {
      method: "POST",
      headers: {
         "Content-Type": "application/json",
      },
      body: JSON.stringify(formdata),
   });
   const data = await response.json();

   console.log(data);
});