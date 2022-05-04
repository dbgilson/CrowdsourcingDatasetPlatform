<?php
include('../../config/server.php');

$_SESSION['id'] = 1;
$_SESSION['dataset'] = 'test';

// Get the owner id of the dataset
$query = "SELECT owner_id FROM internalDatasets WHERE title='" . $_SESSION['dataset'] . "';";
$result = mysqli_query($db, $query);
$row = $result->fetch_array();

// Display the delete button if the user id == owner_id
if($result->num_rows == 1) {
    if ($_SESSION['id'] == $row['owner_id']) {
        echo '<form name="delete_dataset" method="post">';
        echo '<button type="submit" class="btn btn-info" name="delete_dataset">Delete Dataset</button>';
        echo '</form>';
    }
}

?>
