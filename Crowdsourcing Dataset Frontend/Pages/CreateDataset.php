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
                            echo '<li class="nav-item"><a href="Login.php" class="nav-link" aria-current="page">Login</a></li>';
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
          <form class="form-upload" method="post" action="CreateDataset.php" enctype="multipart/form-data">
          <?php include('../../config/errors.php'); ?>
              <img class="mb-4" src="../assets/checkbox.png" alt="" width="144" height="57">
              <h1 class="h3 mb-3 fw-normal u"><u>Dataset Upload</u></h1>

              <div class="form-floating mb-3">
                  <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                  <label for="title">Dataset Name</label>
              </div>

              <div class="form-floating mb-3">
                    <textarea class="form-control" name="description" id="description" placeholder="Description" style="height: 100px"></textarea>
                    <label for="description">Description</label>
              </div>

              <div class="form-floating mb-3">
                    <textarea class="form-control" name="tags" id="tags" placeholder="Tags""></textarea>
                    <label for="description">Tags</label>
              </div>

              <div class="mb-3">
                <label for="formFile" class="form-label">Select Images to Upload</label>
                <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" multiple>
              </div>

              <button type="submit" class="w-50 btn btn-lg btn-primary" name="create_dataset">Create Dataset</button>

              <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
          </form>
      </main>
  </body>
</html>
