const API_KEY = "5adcad38cc39757e9c61c0350b37326a";
const BASE_URL = "https://api.themoviedb.org/3/";

const range = document.querySelector(".range_bar");

fetchFilms = async (page) => {
  const data_array = [];
  for (let i = 1; i <= page; i++) {
    const response = await fetch(
      `${BASE_URL}movie/popular?api_key=${API_KEY}&language=fr-FR&page=${i}`
    );
    const data = await response.json();
    data_array.push(data);
  }
  computeData(data_array);
};

fetchGenres = async () => {
  const response = await fetch(
    `${BASE_URL}genre/movie/list?api_key=${API_KEY}&language=fr-FR`
  );
  const data = await response.json();
  return data;
};

fetchCredits = async (id) => {
  const response = await fetch(
    `${BASE_URL}movie/${id}/credits?api_key=${API_KEY}&language=fr-FR`
  );
  const data = await response.json();
  return data;
};

fetchCreditsDetails = async (id) => {
  const response = await fetch(
    `${BASE_URL}person/${id}?api_key=${API_KEY}&language=fr-FR`
  );
  const data = await response.json();
  return data;
};

sendData = async (name, data) => {
  const response = await fetch(
    "http://localhost/digihub/dev/fetch_api/send_data.php",
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ [name]: data }),
    }
  );
  const returnedData = await response.text();
  console.debug(returnedData);
};

computeData = async (data_array) => {
  const genreArray = [];

  const genres = await fetchGenres();

  for (let i = 0; i < genres.genres.length; i++) {
    const genre = genres.genres[i];
    genreArray.push({
      genreId: genre.id,
      genreName: genre.name,
    });
  }

  //sendGenres("genres",genreArray);

  let filmNumber = 0;

  for (let i = 0; i < data_array.length; i++) {
    const page = data_array[i];

    document.querySelector("#status_page").innerHTML = `page ${i + 1}/${
      data_array.length
    }`;

    for (let j = 0; j < page.results.length; j++) {
      filmNumber++;
      document.querySelector("#status_film").innerHTML = `film ${filmNumber}/${
        data_array.length * page.results.length
      }`;

      range.style.width = `${
        (filmNumber / (data_array.length * page.results.length)) * 100
      }%`;

      const filmArray = [];
      const peoplesArray = [];
      const appartientArray = [];

      const result = page.results[j];
      const credits = await fetchCredits(result.id);
      const directors = credits.crew.filter((crew) => crew.job === "Director");
      const peoples = [...credits.cast, ...directors];

      console.log(peoples);

      const appartientModel = {
        mediaId: result.id,
        peopleId: null,
        departmentName: null,
        characterName: null,
      };

      for (let k = 0; k < peoples.length; k++) {
        const people = peoples[k];
        const peopleDetails = await fetchCreditsDetails(people.id);

        if (people.job) {
          appartientArray.push({
            ...appartientModel,
            peopleId: peopleDetails.id,
            departmentName: "Director",
          });
        } else {
          appartientArray.push({
            ...appartientModel,
            peopleId: peopleDetails.id,
            departmentName: "Actor",
            characterName: people.character,
          });
        }

        let peopleExists = peoplesArray.find(
          (people) => people.peopleId === peopleDetails.id
        );
        if (peopleExists) continue;

        let peopleName = peopleDetails.name.split(" ");
        let firstName = peopleName[0];
        let lastName = "";
        for (let i = 1; i < peopleName.length; i++) {
          if (i === peopleName.length - 1) lastName += peopleName[i];
          else lastName += peopleName[i] + " ";
        }

        peoplesArray.push({
          peopleId: peopleDetails.id,
          peopleFirstname: firstName,
          peopleLastname: lastName,
          peopleFullname: peopleDetails.name,
          peopleBiography: peopleDetails.biography,
          peopleBirthday: peopleDetails.birthday,
          peopleDeathday: peopleDetails.deathday,
          peopleBirthplace: peopleDetails.place_of_birth,
          peoplePicture: peopleDetails.profile_path,
          peopleKnownForDepartment: peopleDetails.known_for_department,
        });
      }

      let filmExists = filmArray.find((film) => film.mediaId === result.id);
      if (filmExists) continue;

      filmArray.push({
        mediaId: result.id,
        mediaTitle: result.title,
        mediaCoverImage: result.poster_path,
        mediaBackdropImage: result.backdrop_path,
        mediaDescription: result.overview,
        mediaPublishingDate: result.release_date,
        mediaYear: result.release_date.split("-")[0],
        mediaTypeId: 2,
        mediaGenres: [...result.genre_ids],
      });
      console.log(appartientArray);

      await sendData("peoples", peoplesArray);
      await sendData("movies", filmArray);
      await sendData("appartient", appartientArray);
      //console.log(filmArray, peoplesArray, appartientArray);
    }
  }
  console.info("done");
};

const button = document.getElementById("btn");
const pageNumber = document.getElementById("page_number");
button.addEventListener("click", () => {
  button.disabled = true;
  button.innerHTML = "Chargement...";
  fetchFilms(pageNumber.value);
});
