const form = document.getElementById('login_form');

form.addEventListener('submit', (e) => {
   e.preventDefault();
   const email = document.getElementById('email').value;
   const password = document.getElementById('password').value;
   const data = {
      email,
      password
   };

   fetch('../php/connect.php', {
      method: 'POST',
      headers: {
         'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
   })
      .then(res => res.json())
      .then(data => console.log(data));
});