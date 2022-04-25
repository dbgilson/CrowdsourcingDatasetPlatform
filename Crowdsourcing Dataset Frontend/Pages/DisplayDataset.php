<?php
$dataset_name = "Plants";
$dirname = "datasets/" . $dataset_name . "/";
$images = glob($dirname."*.*");

if(empty($images))
    echo "This dataset has no images. <br>";

foreach($images as $image) {
    //echo '<img src="'.$image.'" /><br />';
    echo "<img src=\"" . $image . "\" height=\"130\" width=\"150\" />";
    echo '<input type="button" value="Delete Image" onclick="location=\'Login.php\'" /><br />';

}
?>
