<?php
$timeFilter = "publishingDate";
## Default config of filters
$filterArray = [
    "publishingDate" => $sort ?? "DESC",
    "year" => "",
    "genre" => "all",
    "favorite" => $favorite ?? false,
    "userId" => $userId ?? null,
    "results" => $results ?? false,
    "query" => $query ?? null

];

?>

<div class="filter_bar" id="filterBar" data-aimat="<?= $filter_aim_at; ?>" data-favorite="<?= boolval($filterArray['favorite']) ? "true" : "false"; ?>" data-userid="<?= $filterArray['userId']; ?>" data-results="<?= boolval($filterArray['results']) ? "true" : "false"; ?>" data-query="<?= $filterArray['query']; ?>">
    <div class="filter_bar__filter">
        <div class="filter_bar__filter__content">
            <fieldset id="publishing_date_filter">

                <legend>Ordre</legend>

                <?php
                if ($filterArray['results']) {
                ?>
                    <div class="radio">
                        <input type="radio" class="filter-input" name="publishingDate" id="pertinence" value="pertinence" <?php if ($filterArray['publishingDate'] == "popularity") {
                                                                                                                                echo "checked";
                                                                                                                            } ?>>
                        <label for="pertinence">Pertinence&nbsp; </label>
                    </div>
                <?php
                }
                ?>

                <div class="radio">
                    <input type="radio" class="filter-input" name="publishingDate" id="desc" value="DESC" <?php if ($filterArray['publishingDate'] == "DESC") {
                                                                                                                echo "checked";
                                                                                                            } ?>>
                    <label for="desc">Plus récent&nbsp; </label>
                </div>

                <div class="radio">
                    <input type="radio" class="filter-input" name="publishingDate" id="asc" value="ASC" <?php if ($filterArray['publishingDate'] == "ASC") {
                                                                                                            echo "checked";
                                                                                                        } ?>>
                    <label for="asc">Plus ancien&nbsp; </label>
                </div>
            </fieldset>

            <fieldset id="year_filter">
                <legend>Année</legend>

                <input type="number" min="1900" max="2099" step="1" name="year" id="year" class="filter-input" value="<?= $filterArray['year'];  ?>" placeholder="2023">
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