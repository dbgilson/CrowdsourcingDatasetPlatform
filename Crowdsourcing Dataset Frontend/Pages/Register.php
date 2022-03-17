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
                    <li class="nav-item"><a href="Login.html" class="nav-link active" aria-current="page">Login</a></li>
                    <li class="nav-item"><a href="Search.html" class="nav-link">Search</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Profile</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Help</a></li>
                </ul>
            </header>
        </div>

        <form class="form-signin" method="post">
            <img class="mb-4" src="../assets/checkbox.png" alt="" width="144" height="57">
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
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingPasswordCheck" name="floatingPasswordCheck" placeholder="Password">
                        <label for="floatingPasswordCheck">Re-Enter Password</label>
                    </div>
                </div>
            </div>
            <input class="w-50 btn btn-lg btn-primary" id="submit" name="submit" value="Submit" type="submit">

            <p class="mt-5 mb-3 text-muted">&copy; 2017-2021</p>
        </form>
    </main>
<?php
$name_error = $username_error = $password_error = $passwordMatch_error = "";
$name = $username = $password = "";

if (isset($_POST['submit'])) {

  echo "Hello, made it into submit";
  require "../../config/config.php";
  require "../../config/common.php";

  // make sure passwords match
  if ($_POST["password"] === $_POST["floatingPasswordCheck"]) {
      // passwords match
      try {
        $connection = new PDO($dsn, $username, $password, $options);

        $name = test_input($_POST["name"]);
        $username = test_input($_POST["username"]);
        $password = test_input($_POST["password"]);

        $new_user = array(
          "name"      => $_POST['name'],
          "username"  => $_POST['username'],
          "password"  => $_POST['password']
        );

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "users",
            implode(", ", array_keys($new_user)),
            ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
      } catch(PDOException $error) {
          echo $sql . "<br>" . $error->getMessage();
        }

        if (isset($_POST['submit']) && $statement) {
            echo "successfully added";
        }
    }
    else {
        // passwords do not match
        echo "Error: passwords must match.";
        exit;
    }
  }

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
</body>
</html>
