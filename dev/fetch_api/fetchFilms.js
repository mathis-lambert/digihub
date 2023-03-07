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

  for (let i = 0; i < data_array.length; i++) {
    const page = data_array[i];

    document.querySelector("#status_page").innerHTML = `page ${i + 1}/${
      data_array.length
    }`;

    for (let j = 0; j < page.results.length; j++) {
      document.querySelector("#status_film").innerHTML = `film ${j + 1}/${
        data_array.length * page.results.length
      }`;

      range.style.width = `${
        ((i * page.results.length + j) /
          (data_array.length * page.results.length)) *
        100
      }%`;

      const filmArray = [];
      const directorArray = [];
      const actorsArray = [];

      const result = page.results[j];
      const credits = await fetchCredits(result.id);
      const directors = credits.crew.filter((crew) => crew.job === "Director");
      const actors = credits.cast;

      for (let k = 0; k < actors.length; k++) {
        const actor = actors[k];
        const actorDetails = await fetchCreditsDetails(actor.id);

        let actorExists = actorsArray.find(
          (actor) => actor.actorId === actorDetails.id
        );
        if (actorExists) continue;

        actorsArray.push({
          actorId: actorDetails.id,
          actorFullname: actorDetails.name,
          actorBiography: actorDetails.biography,
          actorBirthDate: actorDetails.birthday,
          actorDeathDate: actorDetails.deathday,
          actorBirthPlace: actorDetails.place_of_birth,
          actorProfileImage: actorDetails.profile_path,
          actorDepartment: actorDetails.known_for_department,
        });
      }

      for (let k = 0; k < directors.length; k++) {
        const director = directors[k];
        const directorDetails = await fetchCreditsDetails(director.id);

        let directorExists = directorArray.find(
          (director) => director.directorId === directorDetails.id
        );
        if (directorExists) continue;

        // split director name into first and last name with the first space
        let directorName = directorDetails.name.split(" ");
        let firstName = directorName[0];
        let lastName = "";
        for (let i = 1; i < directorName.length; i++) {
          if (i === directorName.length - 1) lastName += directorName[i];
          else lastName += directorName[i] + " ";
        }

        directorArray.push({
          directorId: directorDetails.id,
          directorFirstname: firstName,
          directorLastname: lastName,
          directorBiography: directorDetails.biography,
          directorBirthDate: directorDetails.birthday,
          directorBirthPlace: directorDetails.place_of_birth,
          directorProfileImage: directorDetails.profile_path,
          directorDepartment: directorDetails.known_for_department,
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
        mediaDirectors: directors.map((director) => director.id),
        mediaActors: [
          actors.map((actor) => actor.id),
          actors.map((actor) => actor.character),
        ],
      });
      await sendData("authors", directorArray);
      await sendData("actors", actorsArray);
      await sendData("movies", filmArray);
      console.log(directorArray, actorsArray, filmArray);
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
