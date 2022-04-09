<?php include('../../config/server.php') ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Crowdsourcing Dataset Platform</title>

</head>
  <body class="text-center">
      <main>
          <form class="create-dataset" method="post" action="CreateDataset.php">
            <?php include('../../config/errors.php'); ?>
            <div class="form-floating">
                <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                <label for="title">Title</label>
            </div>

            <div class="form-floating">
                <input type="textarea" name="description" class="form-control" id="description" placeholder="Description">
                <label for="description">Description</label>
            </div>

            <div class="form-floating">
                <input type="textarea" name="tags" class="form-control" id="tags" placeholder="Tags">
                <label for="tags">Tags</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit" name="create_dataset">Create Dataset</button>
        </form>
    </main>
</body>

</html>
