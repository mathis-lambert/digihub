<!DOCTYPE html>
<html lang="fr">

<?php
require_once './assets/includes/head.php';

$words = $_GET['q'];
?>

<body>
    <?php
    require_once './assets/includes/searchbar.php';
    require_once './assets/includes/header.php';
    ?>

    <div class="container">
        <h1>Résultats de la recherche pour : <?= $words ?></h1>
        <div class="try_with" style="display: none;">
            <h2>Essayez avec :</h2>
            <div id="try_with"></div>
        </div>
        <div class="search-result-container">
            <div class="search-result">
            </div>
        </div>

        <div class="other">
            <h2>D'autres résultats pourraient vous intéresser !</h2>
        </div>
    </div>
    <script src="./scripts/search_result.js"></script>


    <?php require_once './assets/includes/footer.php'; ?>
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
                    const tryWith = document.querySelector('.try_with');
                    const tryWithId = document.querySelector('#try_with');
                    if (errors.length > 0) {
                        tryWith.style.display = 'block';
                        errors.forEach((error) => {
                            tryWithId.innerHTML += `<a href="./?results&q=${error.suggestions[0].suggestion}" class="btn btn-primary">${error.suggestions[0].suggestion} `;
                        });
                    }
                })
                .catch(err => console.error(err));

        })();
        /////////////////////
        // Spellcheck - end
        /////////////////////
    </script>
</body>

</html>