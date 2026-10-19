<?php
session_start();
include 'db.php';

if (!isset($_SESSION["id"])) {
    header("Location:login.php");
    exit();
}

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $sql = $conn->prepare("SELECT image FROM properties WHERE id=? AND user_id=?");
    $sql->bind_param("ii", $id, $_SESSION["id"]);
    $sql->execute();

    $result = $sql->get_result();
    $row = $result->fetch_assoc();

    if ($row) {

        $image = $row["image"];

        $sql = $conn->prepare("DELETE FROM properties WHERE id=? AND user_id=?");
        $sql->bind_param("ii", $id, $_SESSION["id"]);

        if ($sql->execute()) {

            if ($image != "" && file_exists("uploads/" . $image)) {
                unlink("uploads/" . $image);
            }

            header("Location:dashboard.php");
            exit();

        } else {
            die("Delete failed: " . $sql->error);
        }

    } else {
        die("Property not found");
    }
}
?>