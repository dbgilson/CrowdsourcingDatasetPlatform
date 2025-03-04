<?php include('../../config/server.php') ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Crowdsourcing Dataset Platform</title>

    <!-- Bootstrap core CSS -->
    <link href="../bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet">

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
                            echo '<li class="nav-item"><a href="Login.php" class="nav-link active" aria-current="page">Login</a></li>';
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
          <form class="form-signin" method="post" action="Login.php">
            <?php include('../../config/errors.php'); ?>
              <img class="mb-4" src="../assets/checkbox.png" alt="" width="144" height="57">
              <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

              <div class="form-floating">
                  <input type="username" name="username" class="form-control" id="username" placeholder="Username">
                  <label for="username">Username</label>
              </div>

              <div class="form-floating">
                  <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                  <label for="passwrod">Password</label>
              </div>

              <button class="w-100 btn btn-lg btn-primary" type="submit" name="login_user">Sign in</button>

              <div class="d-flex mt-2 align-items-center justify-content-center pb-4">
                  <p class="mb-0 me-2">Don't have an account?</p>
                  <a href="Register.php"><button type="button" class="w-35 mt-1 btn btn-m btn-primary">Register</button></a>
              </div>

              <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
          </form>
      </main>
</body>

</html>


