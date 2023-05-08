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

  updateView(data) {
    if (filterBar.dataset.aimat == "Film") {
      const film_container = document.getElementById("film_container");

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

// This code filters the list of people on the page using the input fields
// with the class "filter-input" and the button with the class "filter-button".

window.addEventListener("load", async () => {
  const FILTERS = new Filters();
  FILTERS.update();
  FILTERS.listenForChange();
});
