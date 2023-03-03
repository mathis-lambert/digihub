const API_KEY = "5adcad38cc39757e9c61c0350b37326a";
const BASE_URL = "https://api.themoviedb.org/3/";

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

sendAuthors = async (authors) => {
  const response = await fetch("http://localhost/digihub/send_data.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ authors: authors }),
  });
  const data = await response.text();
  console.debug(data);
};

sendMovies = async (movies) => {
  const response = await fetch("http://localhost/digihub/send_data.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ movies: movies }),
  });
  const data = await response.text();
  console.debug(data);
};

computeData = async (data_array) => {
  const filmArray = [];
  const directorArray = [];

  for (let i = 0; i < data_array.length; i++) {
    const page = data_array[i];

    for (let j = 0; j < page.results.length; j++) {
      const result = page.results[j];
      const credits = await fetchCredits(result.id);
      const directors = credits.crew.filter((crew) => crew.job === "Director");

      for (let k = 0; k < directors.length; k++) {
        const director = directors[k];
        const directorDetails = await fetchCreditsDetails(director.id);

        let directorExists = directorArray.find(
          (director) => director.directorId === directorDetails.id
        );
        if (directorExists) {
          continue;
        }

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
      if (filmExists) {
        continue;
      }

      filmArray.push({
        mediaId: result.id,
        mediaTitle: result.title,
        mediaCoverImage: result.poster_path,
        mediaBackdropImage: result.backdrop_path,
        mediaDescription: result.overview,
        mediaPublishingDate: result.release_date,
        mediaYear: result.release_date.split("-")[0],
        mediaTypeId: 1,
        mediaGenres: [...result.genre_ids],
        mediaDirectors: directors.map((director) => director.id),
      });
    }
  }
  sendAuthors(directorArray);
  sendMovies(filmArray);
};

fetchFilms(25);
