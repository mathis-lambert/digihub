<?php
include '../../models/Db.php';
include '../../models/Favorites.php';

$input = json_decode(file_get_contents('php://input'), true);

$mediaId = $input['mediaId'];
$userId = $input['userId'];

$favorite = Favorites::find($mediaId, $userId);

if (is_null($favorite)) {
    try {
        $favorite = Favorites::add($mediaId, $userId);
        echo json_encode(['success' => true, 'message' => 'Ajouté aux favoris', 'favorite' => $favorite]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    try {
        Favorites::remove($mediaId, $userId);
        echo json_encode(['success' => true, 'message' => 'Retiré des favoris']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
