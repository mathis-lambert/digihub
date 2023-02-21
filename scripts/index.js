String.prototype.removeNonChar = function () {
  return this.replace(/[^\w\s]/g, " ");
};
String.prototype.keepOnlyOneSpace = function () {
  return this.replace(/\s+/g, " ");
};
String.prototype.removeAloneLetters = function () {
  return this.replace(/\b[a-zA-Z]\b/g, "");
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
    .replace(/[éàèùêëïîôöç]/g, (match) => {
      switch (match) {
        case "é":
          return "e";
        case "à":
          return "a";
        case "è":
          return "e";
        case "ù":
          return "u";
        case "ê":
          return "e";
        case "ë":
          return "e";
        case "ï":
          return "i";
        case "î":
          return "i";
        case "ô":
          return "o";
        case "ö":
          return "o";
        case "ç":
          return "c";
      }
    })
    .removeNonChar()
    .removeAloneLetters()
    .keepOnlyOneSpace()
    .trim();

  value = value.replace(/ /g, "+");

  if (value.length > 1) {
    searchbar.classList.add("searching");
    loadSearchResults(value);
  } else {
    searchbar.classList.remove("searching");
    clearSearchResults();
  }
});

async function loadSearchResults(value) {
  console.log("searching ", value);
  document.querySelector(".search__link").href = `./results.php?s=${value}`;

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
          //max 5 results
          data = data.slice(0, 5);
          console.log("Success:", data);
          displaySearchResults(data);
        })
        .catch((error) => {
          console.error("Error:", error);
          displaySearchResults([]);
        });
    });
}

async function displaySearchResults(results) {
  searchResultsContainer.innerHTML = "";

  // display best result
  if (results.length > 0) {
    searchResultsContainer.innerHTML += "<p>✨ Meilleur résultat ✨</p>";

    searchResultsContainer.innerHTML += `
    <a class="searchbar__results__result" data-type="${results[0].media.typeName}" href="./view.php?id=${results[0].media.mediaId}">
            <div class="searchbar__results__result__icon icon_best"></div>
            <div class="searchbar__results__result__title">
                ${results[0].media.mediaName}
            </div>
            </a>
        `;
    await fetch(`./assets/img/icons/${results[0].media.typeIcon}_icon.svg`)
      .then((response) => response.text())
      .then((data) => {
        searchResultsContainer.querySelector(
          `.searchbar__results__result__icon.icon_best`
        ).innerHTML = data;
      });

    if (results.length > 1) {
      searchResultsContainer.innerHTML +=
        "D'autres résultats qui pourraient vous intéresser";
      for (let i = 1; i < results.length; i++) {
        const result = results[i].media;
        searchResultsContainer.innerHTML += `
    <a class="searchbar__results__result" data-type="${result.typeName}" href="./view.php?id=${result.mediaId}">
            <div class="searchbar__results__result__icon icon_${i}"></div>
            <div class="searchbar__results__result__title">
                ${result.mediaName}
            </div>
            </a>
        `;
        const icon = searchResultsContainer.querySelector(
          `.searchbar__results__result__icon.icon_${i}`
        );
        await fetch(`./assets/img/icons/${result.typeIcon}_icon.svg`)
          .then((response) => response.text())
          .then((data) => {
            icon.innerHTML = data;
          });
      }
    }
  } else {
    searchResultsContainer.innerHTML = `
    <div class="searchbar__results__result">
            <div class="searchbar__results__result__icon err_icon"></div>

            <div class="searchbar__results__result__title">
                Aucun résultat trouvé
            </div>
        </div>
        `;

    const icon = searchResultsContainer.querySelector(
      `.searchbar__results__result__icon.err_icon`
    );
    await fetch(`./assets/img/icons/err.svg`)
      .then((response) => response.text())
      .then((data) => {
        icon.innerHTML = data;
      });
  }
}

function clearSearchResults() {
  searchResultsContainer.innerHTML = "";
}

/////////////////////
// Searchbar - end
/////////////////////

/////////////////////
// HEADER
/////////////////////
function toggleCatalogue() {
  const catalogue = document.querySelector(".catalogue");
  catalogue.classList.toggle("active");
}
/////////////////////
// HEADER - end
/////////////////////
