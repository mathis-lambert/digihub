<?php
$timeFilter = "publishingDate";
## Default config of filters
$filterArray = [
    "publishingDate" => "DESC",
    "year" => "",
    "genre" => "all",
];

?>

<div class="filter_bar" id="filterBar" data-aimat="<?php echo $filter_aim_at; ?>">
    <h3>Filtres</h3>
    <div class="filter_bar__filter">
        <div class="filter_bar__filter__content">
            <fieldset id="publishing_date_filter">

                <legend>Ordre de publication</legend>

                <div class="radio">
                    <input type="radio" class="filter-input" name="publishingDate" id="desc" value="DESC" <?php if ($filterArray['publishingDate'] == "DESC") {
                                                                                                                echo "checked";
                                                                                                            } ?>>
                    <label for="desc">Décroissant</label>
                </div>

                <div class="radio">
                    <input type="radio" class="filter-input" name="publishingDate" id="asc" value="ASC" <?php if ($filterArray['publishingDate'] == "ASC") {
                                                                                                            echo "checked";
                                                                                                        } ?>>
                    <label for="asc">Croissant</label>
                </div>
            </fieldset>

            <fieldset id="year_filter">
                <legend>Année</legend>

                <input type="number" min="1900" max="2099" step="1" name="year" id="year" class="filter-input" value="<?php echo $filterArray['year'];  ?>" placeholder="2023">
            </fieldset>

            <fieldset id="genre_filter">
                <legend>Genre</legend>


                <select name="genre" id="genre" class="filter-input">
                    <option value="all" <?php
                                        if ($filterArray['genre'] == "all") {
                                            echo "selected";
                                        }
                                        ?>>Tous</option>
                    <?php
                    $genres = $this->model->getGenres();

                    foreach ($genres as $genre) {
                        echo "<option value='" . $genre['genreId'] . "' ";
                        if ($filterArray['genre'] == $genre['genreId']) {
                            echo "selected";
                        }
                        echo ">" . $genre['genreName'] . "</option>";
                    }
                    ?>
                </select>
            </fieldset>
        </div>
    </div>
</div>


<script src="./scripts/filterBar.js"></script>