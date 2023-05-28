const filterBar = document.getElementById("filterBar");

/* Filter inputs */
const publishingDate = document.getElementById("publishing_date_filter");
const genre = document.getElementById("genre_filter");
const year = document.getElementById("year_filter");

// Filters class is used to filter the data on the main page according to the filters that are applied.

class Filters {
  constructor() {
    // get the current filters from the DOM
    this.options = this.getFilters();
  }

  async update() {
    // get the current filters from the DOM
    this.options = this.getFilters();
    // get the filtered data from the API
    let data = await this.getFilteredData();
    // update the view with the filtered data
    this.updateView(data);
  }

  getFilters() {
    const filters = {};

    // get the publishing date filter from the DOM
    const publishingDateChecked =
      publishingDate.querySelectorAll("input:checked");

    if (publishingDateChecked.length > 0) {
      filters.publishing_date = publishingDateChecked[0].value;
    }

    // get the year filter from the DOM
    const yearValue = year.querySelector("input").value;
    if (yearValue) {
      filters.year = yearValue;
    }

    // get the genre filter from the DOM
    const genreValue = genre.querySelector("select").value;
    if (genreValue) {
      filters.genre = genreValue;
    }

    // Set the filters to be used by the query
    filters.favorite = filterBar.dataset.favorite;
    filters.userid = filterBar.dataset.userid;
    filters.fromResults = filterBar.dataset.results;
    filters.query = filterBar.dataset.query;

    return filters;
  }

  listenForChange() {
    // listen to changes in the filters
    const filterInputs = document.querySelectorAll(".filter-input");
    filterInputs.forEach((input) => {
      input.addEventListener("change", () => {
        // when a change occurs, update the filters
        this.update();
      });
    });
  }

  async getFilteredData() {
    if (this.options.fromResults == "true") {
      if (this.options.query) {
        let q = this.options.query;

        const response = await fetch(
          "./controllers/php/normalizeQuery.php?method=searching&q=" + q
        );
        const data = await response.json();
        let query = data.url;

        const response2 = await fetch("./controllers/php/" + query);
        const data2 = await response2.json();

        if (data2.medias.length == 0) {
          return [];
        }
        return data2.medias;
      }
    } else {
      // get the filtered data from the API
      const response = await fetch(`./controllers/php/filter.php`, {
        method: "POST",
        body: JSON.stringify({
          aim_at: filterBar.dataset.aimat,
          filterArray: this.options,
        }),
      });
      const data = await response.json();
      return data;
    }
  }

  async updateView(data) {
    if (filterBar.dataset.aimat == "Film") {
      const film_container = document.getElementById("film_container");

      if (this.options.fromResults == "true") {
        if (data.length == 0) {
          film_container.innerHTML = `
          <div class="search-result__item">
            <h1 class="search-result__item__title">Aucun résultat trouvé</h1>
          </div>
          `;
        } else {
          let medias = data.map((film) => film.media);

          /* Sort medias from current filters */
          if (this.options.publishing_date == "DESC") {
            medias.sort((a, b) => {
              return (
                new Date(b.mediaPublishingDate) -
                new Date(a.mediaPublishingDate)
              );
            });
          } else if (this.options.publishing_date == "ASC") {
            medias.sort((a, b) => {
              return (
                new Date(a.mediaPublishingDate) -
                new Date(b.mediaPublishingDate)
              );
            });
          }

          if (this.options.year) {
            medias = medias.filter((media) => {
              return media.mediaPublishingDate.includes(this.options.year);
            });
          }

          if (this.options.genre != "all") {
            console.log(this.options.genre);
            const genres = await fetch("./controllers/php/get_genres.php");
            const genresData = await genres.json();

            let genreName = genresData.find(
              (genre) => genre.genreId == this.options.genre
            ).genreName;

            medias = medias.filter((media) => {
              return media.genreName.includes(genreName);
            });
          }

          console.log(medias);

          if (film_container) {
            if (medias.length == 0) {
              film_container.innerHTML = `
              <div class="search-result__item">
                <h1 class="search-result__item__title">Aucun résultat trouvé</h1>
              </div>
              `;
            } else {
              // update the film container with the filtered data
              film_container.innerHTML = "";
              medias.forEach((film) => {
                film_container.innerHTML += `
                <div class="search-result__item">
                  <a href="./?view&id=${film.mediaId}" class="cover">
                    <img src="https://image.tmdb.org/t/p/w500${film.mediaCoverImage}" alt="${film.mediaName}" class="search-result__item__image">
                  </a>
                </div>
            `;
              });
            }
          }
        }
      } else {
        if (film_container) {
          // update the film container with the filtered data
          film_container.innerHTML = "";
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
      }
    }
  }
}

// This code filters the list of people on the page using the input fields
// with the class "filter-input" and the button with the class "filter-button".

window.addEventListener("load", async () => {
  const FILTERS = new Filters();
  FILTERS.update();
  FILTERS.listenForChange();
});
