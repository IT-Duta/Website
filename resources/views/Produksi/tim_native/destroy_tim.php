<?php

include_once("../config.php");

//getting id of the data from url
$id = $_GET['id'];

//deleting the row from table

$sql = "DELETE FROM tim WHERE tim_id=:id";
$query = $conn->prepare($sql);
$query->execute(array(':id' => $id));

//redirecting to the display page (index.php in our case)
header("Location:index.php");
?>