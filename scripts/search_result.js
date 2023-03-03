(async () => {
  const value = new URLSearchParams(window.location.search).get("q");
  const searchResult = document.querySelector(".search-result");

  if (value) {
    await fetch(
      "./controllers/php/normalizeQuery.php?method=searching&q=" + value
    )
      .then((response) => response.json())
      .then(async (data) => {
        let query = data.url;

        await fetch("./controllers/php/" + query)
          .then((response) => response.json())
          .then((data) => {
            data = data.sort((a, b) => {
              return b._score - a._score;
            });
            data.forEach((media) => {
              let mediaData = media.media;
              searchResult.innerHTML += `
            <div class="search-result__item">
                <a href="./?view&id=${mediaData.mediaId}" class="cover">
                    <img src="https://image.tmdb.org/t/p/w500${mediaData.mediaCoverImage}" alt="${mediaData.title}" class="search-result__item__image">
                </a>
            </div>
            `;
            });
          })
          .catch((error) => {
            console.error("Error:", error);
          });
      });
  }
})();
