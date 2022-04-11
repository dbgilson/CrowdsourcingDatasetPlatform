<?php include('../../config/server.php') ?>
<?php $_SESSION['dataset'] = "Plants"; // FIXME ?>
<!DOCTYPE html>
<html>
<body>

<form action="UploadData.php" method="post" enctype="multipart/form-data">
    <?php include('../../config/errors.php'); ?>
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="upload_image">
</form>

</body>
</html>
