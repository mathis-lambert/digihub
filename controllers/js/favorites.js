const toggleFavorite = async (e, mediaId, userId) => {
  // log calling object
  console.log(e);

  const response = await fetch(`./controllers/php/toggleFavorite.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ mediaId: mediaId, userId: userId }),
  });
  const data = await response.json();

  if (data.success) {
    if (data.favorite) {
      e.classList.add("favorite");
      e.classList.remove("not-favorite");
      e.innerHTML = "Retirer des favoris";
    } else {
      e.classList.add("not-favorite");
      e.classList.remove("favorite");
      e.innerHTML = "Ajouter aux favoris";
    }
  } else {
    console.log("error");
  }

  return data;
};
