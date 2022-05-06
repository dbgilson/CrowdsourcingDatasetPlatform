<?php include('../../config/server.php') ?>
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
    <link href="Register.css" rel="stylesheet">
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
                            echo '<li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Register</a></li>';
                        }else {
                            echo '<li class="nav-item"><a href="Register.php" class="nav-link active">Register</a></li>';
                        }
                    ?>
                </ul>
            </header>
        </div>

        <form class="form-signin" method="post" action="Register.php">
            <?php include('../../config/errors.php'); ?>
            <img class="mb-4" src="../assets/checkbox.png" alt="" width="200" height="150">
            <h1 class="h3 mb-3 fw-normal">Registration</h1>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="form-floating">
                        <input type="username" class="form-control" id="name" name="name" placeholder="name" required>
                        <label for="name">Name</label>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-floating">
                        <input type="username" class="form-control" id="username" name="username" placeholder="username" required>
                        <label for="username">Username</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="form-floating">
                        <input type="password" class="form-control" id="password_1" name="password_1" placeholder="Password" required>
                        <label for="password_1">Password</label>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-floating">
                        <input type="password" class="form-control" id="password_2" name="password_2" placeholder="Password">
                        <label for="password_2">Re-Enter Password</label>
                    </div>
                </div>
            </div>
            <input class="w-50 btn btn-lg btn-primary" id="submit" name="reg_user" value="Submit" type="submit">

            <p class="mt-5 mb-3 text-muted">&copy; 2017-2021</p>
        </form>
    </main>
</body>
</html>


