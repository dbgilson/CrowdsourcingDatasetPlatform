<?php
include('../../config/server.php');

echo '<form name="download_dataset" method="post">';
echo '<button type="submit" class="btn btn-info" name="download_dataset">Download Zip</button>';
echo '</form>';

?>
<?php include('../../config/server.php') ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Crowdsourcing Dataset Platform</title>

    <!-- Bootstrap core CSS -->
    <link href="../bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
    <script src="DataUpload.js"></script>
    <div class="container">
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>


        <!-- Custom styles for this template -->
        <link href="Login.css" rel="stylesheet">
        <link href="headers.css" rel="stylesheet">
</head>
  <body class="text-center">
      <main>
          <div class="container">
              <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
                  <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                      <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap" /></svg>
                      <span class="fs-4">CDP</span>
                  </a>

                  <ul class="nav nav-pills">
                    <?php  
                        if(isset($_SESSION['username'])) {
                            echo '<a class="navbar-brand">'. $_SESSION['username'] .'</a>';
                        }else {
                            echo '<li class="nav-item"><a href="#" class="nav-link" aria-current="page">Login</a></li>';
                        }
                    ?>
                      <li class="nav-item"><a href="SearchPage.php" class="nav-link">Search</a></li>
                      <li class="nav-item"><a href="User.php" class="nav-link">Profile</a></li>
                      <?php  
                        if(isset($_SESSION['username'])) {
                            echo '<li class="nav-item"><a href="Logout.php" class="nav-link" aria-current="page">Logout</a></li>';
                        }else {
                            echo '<li class="nav-item"><a href="Register.php" class="nav-link">Register</a></li>';
                        }
                    ?>
                  </ul>
              </header>
          </div>
          <?php
            echo '<h1 align="left" class="h4 mt-1 mb-5 fw-normal">Current User: ' . $_SESSION['username'] . '</h1>';
          ?>

          <?php include('../../config/errors.php'); ?>
          <div class="container">
            <?php
                echo '<h1 align="middle" class="h4 mt-1 mb-5 fw-normal">' . $_GET["dataset"] . '</h1>';

                echo '<form name="download_dataset" method="post">';
                echo '<button type="submit" class="btn btn-info" name="download_dataset">Download Zip</button>';
                echo '</form>';
            ?>
            <a href="UploadData.php"><button type="button" class="w-35 mt-1 mb-5 btn btn-m btn-primary">Upload Data</button></a>
          </div>
          <?php
            $dataset_name = $_GET["dataset"];
            $dirname = "datasets/" . $dataset_name . "/";
            $images = glob($dirname."*.*");


            if(empty($images)){
                echo $dirname;
                echo "This dataset has no images. <br>";
            }
            
            foreach($images as $image) {
                echo "<img src=\"" . $image . "\" height=\"130\" width=\"150\" />";
                if($_GET["owner_id"] == $_SESSION["id"]){
                    echo '<form method="POST" action="DisplayDataset.php">';
                    echo '<button name="delete_image" value="'. $image . '">';
                    echo 'Delete';
                    echo '</button>';
                    echo '</form>';
                }

            }
          ?>

              <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>

      </main>
  </body>
</html>
