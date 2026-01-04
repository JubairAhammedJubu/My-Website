<?php
include('db.php');

$id = $_GET['id'];
$delete = "DELETE FROM students WHERE id=$id";

if (mysqli_query($conn, $delete)) {
    header("Location: RegisterProfile.php");
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
?>
