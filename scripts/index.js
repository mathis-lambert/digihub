String.prototype.removeNonChar = function () {
  return this.replace(/[^\w\s]/g, " ");
};
String.prototype.keepOnlyOneSpace = function () {
  return this.replace(/\s+/g, " ");
};
String.prototype.removeAloneLetters = function () {
  return this.replace(/\b[a-zA-Z]\b/g, "");
};

try {
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

  // if echap pressed  => remove active class
  document.addEventListener("keydown", (e) => {
    if (e.code === "Escape") {
      searchbar.classList.remove("active");
    }
  });

  let searchTimeout;
  let currentSearch = "";

  searchbarInput.addEventListener("input", () => {
    clearTimeout(searchTimeout);

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
      .keepOnlyOneSpace()
      .trim();

    // TODO: see if it's better to remove non char or not
    /*     .removeNonChar()
    .removeAloneLetters() */

    value = value.replace(/ /g, "+");

    if (value.length > 1) {
      searchbar.classList.add("searching");
      if (currentSearch != value) {
        searchTimeout = setTimeout(() => {
          loadSearchResults(value);
          currentSearch = value;
        }, 300);
      }
    } else {
      searchbar.classList.remove("searching");
      clearSearchResults();
    }
  });

  async function loadSearchResults(value) {
    console.log("searching ", value);
    document.querySelector(".search__link").href = `./?results&q=${value}`;

    await fetch(
      "./controllers/php/normalizeQuery.php?method=searching&q=" + value
    )
      .then((response) => response.json())
      .then(async (data) => {
        let query = data.url;

        await fetch("./controllers/php/" + query)
          .then((response) => response.json())
          .then((data) => {
            console.log(data);
            data.medias = data.medias.sort((a, b) => {
              return b._score - a._score;
            });

            //max 5 results
            data.medias = data.medias.slice(0, 5);
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
    console.log(results);
    // display best result
    if (results.medias.length > 0 || results.peoples.length > 0) {
      // if results contains the key "people"
      if (Object.hasOwn(results, "peoples") && results.peoples.length > 0) {
        let peoples = results.peoples;

        searchResultsContainer.innerHTML += "<p>✨ Meilleurs résultats ✨</p>";

        peoples.forEach((people) => {
          people = people.people;
          console.log(people);
          searchResultsContainer.innerHTML += `
    <a class="searchbar__results__result" data-type="people" href="./?people&id=${people.peopleId}">
            <div class="searchbar__results__result__title">
                ${people.peopleFullname}
            </div>
            </a>
        `;
        });
      } else {
        searchResultsContainer.innerHTML += "<p>✨ Meilleur résultat ✨</p>";

        searchResultsContainer.innerHTML += `
    <a class="searchbar__results__result" data-type="${results.medias[0].media.typeName}" href="./?view&id=${results.medias[0].media.mediaId}">
            <div class="searchbar__results__result__icon icon_best"></div>
            <div class="searchbar__results__result__title">
                ${results.medias[0].media.mediaName}
            </div>
            </a>
        `;
        await fetch(
          `./assets/img/icons/${results.medias[0].media.typeIcon}_icon.svg`
        )
          .then((response) => response.text())
          .then((data) => {
            searchResultsContainer.querySelector(
              `.searchbar__results__result__icon.icon_best`
            ).innerHTML = data;
          });

        // remove best result from results
        results.medias.shift();
      }

      if (results.medias.length > 0) {
        results = results.medias;
        searchResultsContainer.innerHTML +=
          "D'autres résultats qui pourraient vous intéresser";
        for (let i = 0; i < results.length; i++) {
          const result = results[i].media;
          searchResultsContainer.innerHTML += `
    <a class="searchbar__results__result" data-type="${result.typeName}" href="./?view&id=${result.mediaId}">
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

  /////////////////////
  /* TABLE EDITING */
  ////////////////////
  const editTable = document.querySelectorAll(".editTable");

  async function sendData(data) {
    const response = await fetch("./controllers/php/editTable.php", {
      method: "POST",
      body: JSON.stringify(data),
    });

    const json = await response.json();

    console.log(json);
    return json;
  }

  if (editTable) {
    const editButtons = document.querySelectorAll(".editButton");
    const deleteButtons = document.querySelectorAll(".deleteButton");

    /* 
    tempInputsValues is used to store inputs values to undo changes
  */
    let tempInputsValues = [];

    /* 
    edit buttons event listener
  */
    editButtons.forEach((button) => {
      button.addEventListener("click", (e) => {
        // get parent table row
        let parentTableRow = button.parentElement.parentElement;

        // get userid
        let commentId = parentTableRow.dataset.commentid || null;
        let userId = parentTableRow.dataset.userid || null;

        // get all inputs in parent table row
        let inputs = parentTableRow.querySelectorAll(
          "input:not(.userId), select, textarea"
        );

        // get target table
        let target = button.parentElement.parentElement.dataset.target;

        let inputsValues = [];

        inputs.forEach((input) => {
          inputsValues.push(input.value);
        });

        console.log(target, userId, commentId, inputsValues);

        parentTableRow
          .querySelector(".deleteButton")
          .classList.toggle("disabled");

        if (parentTableRow.classList.contains("editMode")) {
          parentTableRow.classList.toggle("editMode");

          inputs.forEach((input) => {
            //reset inputs values
            input.value = tempInputsValues.shift();
            input.toggleAttribute("disabled");
            input.classList.remove("invalid");
          });
        } else {
          let data = {};
          if (target == "user") {
            data = {
              edit: {
                target: target,
                id: userId,
                nom: inputsValues[0],
                prenom: inputsValues[1],
                naissance: inputsValues[2],
                email: inputsValues[3],
                role: inputsValues[4],
              },
            };
          } else if (target == "comments") {
            data = {
              edit: {
                target: target,
                id: commentId,
                contenu: inputsValues[0],
                note: inputsValues[1],
                statut: inputsValues[2],
              },
            };
          }

          parentTableRow.classList.toggle("editMode");
          inputs.forEach((input) => {
            input.toggleAttribute("disabled");
            tempInputsValues.push(input.value);

            /* if value of input changes */
            input.addEventListener("input", (e) => {
              parentTableRow
                .querySelector(".validateButton")
                .classList.add("validate");
              inputsValues = [];
              inputs.forEach((input) => {
                inputsValues.push(input.value);
              });

              if (target == "user") {
                data = {
                  edit: {
                    target: target,
                    id: userId,
                    nom: inputsValues[0],
                    prenom: inputsValues[1],
                    naissance: inputsValues[2],
                    email: inputsValues[3],
                    role: inputsValues[4],
                  },
                };
              } else if (target == "comments") {
                data = {
                  edit: {
                    target: target,
                    id: commentId,
                    contenu: inputsValues[0],
                    note: inputsValues[1],
                    statut: inputsValues[2],
                  },
                };
              }

              parentTableRow.querySelector(".validateButton").onclick =
                async () => {
                  parentTableRow
                    .querySelector(".validateButton")
                    .classList.remove("validate");
                  parentTableRow
                    .querySelector(".validateButton")
                    .classList.add("loading");
                  const response = await sendData(data);
                  if (response.error == false) {
                    parentTableRow
                      .querySelector(".validateButton")
                      .classList.remove("loading");
                    parentTableRow.classList.toggle("editMode");
                    inputs.forEach((input) => {
                      input.toggleAttribute("disabled");
                    });
                    parentTableRow
                      .querySelector(".deleteButton")
                      .classList.toggle("disabled");
                  }
                };
            });
          });
        }
      });
    });

    deleteButtons.forEach((button) => {
      button.addEventListener("click", async (e) => {
        if (!button.classList.contains("disabled")) {
          let parentTableRow = button.parentElement.parentElement;
          let target = parentTableRow.dataset.target;

          let id =
            target == "user"
              ? parentTableRow.dataset.userid
              : parentTableRow.dataset.commentid;

          let data = {
            delete: {
              target: target,
              id: id,
            },
          };

          const response = await sendData(data);
          if (response.error == false) {
            parentTableRow.remove();
          }
        }
      });
    });
  }
} catch (error) {
  console.error(error);
}
