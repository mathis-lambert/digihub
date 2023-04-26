<?php
$timeFilter = "publishingDate";
$filterArray = [
    "publishingDate" => false,
    "year" => false,
    "name" => false,
    "genre" => false,
    "type" => false,
    "director" => false,
    "actor" => false
];

?>

<div class="filter_bar" id="filterBar" data-aimat="<?php echo $filter_aim_at; ?>">
    <span>Filtres</span>
    <span id="aimat"></span>

    <div class="filter_bar__filter">
        <span class="filter_bar__filter__title">Date de publication</span>
        <div class="filter_bar__filter__content">
            <input type="radio" name="publishingDate" id="publishingDate" value="ASC" <?php if ($filterArray['publishingDate'] == "ASC") {
                                                                                            echo "checked";
                                                                                        } ?>>
            <label for="publishingDate">Croissant</label>
            <input type="radio" name="publishingDate" id="publishingDate" value="DESC" <?php if ($filterArray['publishingDate'] == "DESC") {
                                                                                            echo "checked";
                                                                                        } ?>>
            <label for="publishingDate">Décroissant</label>
        </div>

    </div>

    <script src="./scripts/filterBar.js"></script>