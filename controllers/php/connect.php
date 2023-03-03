<?php
$body = file_get_contents("php://input");
// send the response
echo json_encode($body);
