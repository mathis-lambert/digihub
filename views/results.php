<!DOCTYPE html>
<html lang="fr">

<?php
require_once './includes/head.php';

$words = $_GET['q'];
?>

<body>
    <?php
    require_once './includes/searchbar.php';
    require_once './includes/header.php';
    ?>

    <h1 class="container">Résultats de la recherche pour : <?= $words ?></h1>
    <h2 class="container">Essayez avec :</h2>
    <div class="try_with"></div>
    <div class="container search-result">

    </div>
    <script src="./scripts/search_result.js"></script>


    <?php require_once './includes/footer.php'; ?>
    <script>
        /////////////////////
        // Spellcheck
        /////////////////////
        (async (values = "<?= $words ?>") => {

            const options = {
                method: 'GET',
                headers: {
                    'X-RapidAPI-Key': '615566017amshd1d229748a9bc78p1d3d2bjsn4d40aec1fa5a',
                    'X-RapidAPI-Host': 'bing-spell-check2.p.rapidapi.com'
                }
            };

            await fetch(`https://bing-spell-check2.p.rapidapi.com/spellcheck?mode=spell&text=${values}`, options)
                .then(response => response.json())
                .then(response => {
                    let errors = response.flaggedTokens;
                    errors.forEach((error) => {
                        const tryWith = document.querySelector('.try_with');
                        tryWith.innerHTML += `${error.suggestions[0].suggestion} `;
                    });

                })
                .catch(err => console.error(err));

        })();
        /////////////////////
        // Spellcheck - end
        /////////////////////
    </script>
</body>

</html>