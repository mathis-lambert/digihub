const aimat = document.getElementById("aimat");
const filterBar = document.getElementById("filterBar");

aimat.innerHTML = filterBar.dataset.aimat;

getFilteredData = async (aim_at, filterArray) => {
  const response = await fetch(`./controllers/php/filter.php`, {
    method: "POST",
    body: JSON.stringify({
      aim_at: aim_at,
      filterArray: filterArray,
    }),
  });
  const data = await response.json();
  return data;
};

window.addEventListener("load", async () => {
  const film_container = document.getElementById("film_container");

  if (film_container) {
    const data = await getFilteredData(filterBar.dataset.aimat, []);
    data.forEach((film) => {
      film_container.innerHTML += `
            <div class="gallery__item">
            <a href="./?view&id=${film.mediaId}">
            <img src="https://image.tmdb.org/t/p/w500${film.mediaCoverImage}" alt="${film.title}">
            </a>
            </div>
        `;
    });
  }
});
