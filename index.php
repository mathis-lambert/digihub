<?php
require_once './controllers/php/controller.php';
include_once './config/config.php';

$controller = new Controller($conn);
$controller->invoke();
