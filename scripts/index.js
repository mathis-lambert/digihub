String.prototype.removeNonChar = function () {
  return this.replace(/[^\w\s]/g, "");
};
/////////////
// Searchbar
/////////////
const searchbar = document.querySelector(".searchbar");
const searchbarBackground = document.querySelector(".searchbar__background");
const searchbarInput = document.querySelector(
  ".searchbar__container__input input"
);
const searchbarBackButton = document.querySelector(".searchbar__back");
const searchButton = document.querySelector(".search-button");
const searchResultsContainer = document.querySelector(".searchbar__results");

searchButton.addEventListener("click", () => {
  searchbar.classList.add("active");
  searchbarInput.focus();
});
searchbarBackButton.addEventListener("click", () => {
  searchbar.classList.remove("active");
});

searchbarBackground.addEventListener("click", () => {
  searchbar.classList.remove("active");
});

searchbarInput.addEventListener("input", () => {
  let value = searchbarInput.value
    .trim()
    .toLowerCase()
    .removeNonChar()
    .replace(" ", "+");
  if (value.length > 0) {
    searchbar.classList.add("searching");
    loadSearchResults(value);
  } else {
    searchbar.classList.remove("searching");
    clearSearchResults();
  }
});

async function loadSearchResults(value) {
  console.log("searching ", value);
  await fetch("./controllers/php/search.php?q=" + value)
    .then((response) => response.json())
    .then((data) => {
      data;
      console.log(data);
      displaySearchResults(data);
    })
    .catch((error) => {
      console.error("Error:", error);
      displaySearchResults([]);
    });
}

function displaySearchResults(results) {
  searchResultsContainer.innerHTML = "";
  if (results.length > 0) {
    for (let i = 0; i < results.length; i++) {
      const result = results[i];
      searchResultsContainer.innerHTML += `
    <div class="searchbar__results__result">
            <div class="searchbar__results__result__title">
                ${result.mediaName}
            </div>
            </div>
        `;
    }
  } else {
    searchResultsContainer.innerHTML = `
    <div class="searchbar__results__result">
            <div class="searchbar__results__result__title">
                Aucun résultat trouvé
            </div>
        </div>
        `;
  }
}

function clearSearchResults() {
  searchResultsContainer.innerHTML = "";
}

/////////////////////
