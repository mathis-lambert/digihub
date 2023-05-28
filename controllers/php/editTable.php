<?php
session_start();
require '../../models/Db.php';

$body = file_get_contents("php://input");
$d = json_decode($body, true);

$pdo = new Db();
$error = false;

/* TRAITEMENT DES MODIFICATIONS */
if (isset($d['edit'])) {
    if (in_array($_SESSION['role'], [1, 2, 3])) {
        if ($d['edit']['target'] == "user") {
            $id = $d['edit']['id'];
            $mail = $d['edit']['email'];
            $nom = $d['edit']['nom'];
            $prenom = $d['edit']['prenom'];
            $role = $d['edit']['role'];
            $birth = $d['edit']['naissance'];

            $sql = "UPDATE users SET userFirstname = ?, userLastname = ?, userMail = ?, userRole = ?, userBirthdate = ? WHERE userId = ?";

            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindValue(1, htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8'));
                $stmt->bindValue(2, htmlspecialchars($nom, ENT_QUOTES, 'UTF-8'));
                $stmt->bindValue(3, htmlspecialchars($mail, ENT_QUOTES, 'UTF-8'));
                $stmt->bindValue(4, $role);
                $stmt->bindValue(5, $birth);
                $stmt->bindValue(6, $id);
                $stmt->execute();

                echo json_encode(["error" => $error, "method" => "edit", "target" => "user", $id = $id, "message" => "Modification réussie"]);
                exit;
            } else {
                echo json_encode(["error" => $error = true, "method" => "edit", "target" => "user", $id = null, "message" => "Erreur de modification"]);
                exit;
            }
        } else if ($d['edit']['target'] == "comments") {
            $id = $d['edit']['id'];
            $contenu = $d['edit']['contenu'];
            $note = $d['edit']['note'];
            $statut = $d['edit']['statut'];

            $sql = "UPDATE comments SET commentText = ?, commentRating = ?, commentStatus = ? WHERE commentId = ?";

            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindValue(1, htmlspecialchars($contenu, ENT_QUOTES, 'UTF-8'));
                $stmt->bindValue(2, $note);
                $stmt->bindValue(3, $statut);
                $stmt->bindValue(4, $id);
                $stmt->execute();

                echo json_encode(["error" => $error, "method" => "edit", "target" => "article", $id = $id, "message" => "Modification réussie"]);
                exit;
            } else {
                echo json_encode(["error" => $error = true, "method" => "edit", "target" => "article", $id = null, "message" => "Erreur de modification"]);
                exit;
            }
        }
    } else {
        echo json_encode(["error" => $error = true, "method" => "edit", "target" => "article", $id = null, "message" => "Vous n'avez pas les droits pour effectuer cette action"]);
        exit;
    }
}

/* TRAITEMENT DES SUPPRESSIONS */
if (isset($d['delete'])) {
    if (in_array($_SESSION['role'], [2, 3])) {
        if ($d['delete']['target'] == 'user') {
            if ($_SESSION['id'] == $d['delete']['id']) {
                echo json_encode(["error" => $error = true, "method" => "delete", "target" => "user", $id = null, "message" => "Vous ne pouvez pas vous supprimer"]);
                exit;
            } else {
                $id = $d['delete']['id'];

                $sql = "DELETE FROM users WHERE userId = ?";

                if ($stmt = $pdo->prepare($sql)) {
                    $stmt->bindValue(1, $id);
                    $stmt->execute();

                    echo json_encode(["error" => $error, "method" => "delete", "target" => "user", $id = $id, "message" => "Suppression réussie"]);
                    exit;
                } else {
                    echo json_encode(["error" => $error = true, "method" => "delete", "target" => "user", $id = null, "message" => "Erreur de suppression"]);
                    exit;
                }
            }
        } else if ($d['delete']['target'] == 'comments') {
            $id = $d['delete']['id'];

            $sql = "DELETE FROM comments WHERE commentId = ?";

            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindValue(1, $id);
                $stmt->execute();

                echo json_encode(["error" => $error, "method" => "delete", "target" => "comment", $id = $id, "message" => "Suppression réussie"]);
                exit;
            } else {
                echo json_encode(["error" => $error = true, "method" => "delete", "target" => "comment", $id = null, "message" => "Erreur de suppression"]);
                exit;
            }
        }
    } else {
        echo json_encode(["error" => $error = true, "method" => "delete", "target" => "user", $id = null, "message" => "Vous n'avez pas les droits pour effectuer cette action"]);
        exit;
    }
}
