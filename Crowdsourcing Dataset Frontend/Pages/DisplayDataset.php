<?php include('../../config/server.php') ?>

<?php
$dataset_name = "Plants";
$dirname = "datasets/" . $dataset_name . "/";
$images = glob($dirname."*.*");


if(empty($images))
    echo "This dataset has no images. <br>";

foreach($images as $image) {
    echo "<img src=\"" . $image . "\" height=\"130\" width=\"150\" />";

    echo '<form method="POST" action="DisplayDataset.php">';
    echo '<button name="delete_image" value="'. $image . '">';
    echo 'Delete';
    echo '</button>';
    echo '</form>';

}
?>
