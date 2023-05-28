<?php
require '../../models/Model.php';
echo json_encode((new Model())->getGenres());
