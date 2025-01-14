<?php include('../../config/server.php') ?>
<?php
if(!isset($_SESSION['username'])) {
    header("location: Login.php");
}
?>
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
                            // echo '<li class="nav-item"><span class="nav-link " aria-current="page">'. $_SESSION['username'] .'</span></li>';
                        }else {
                            echo '<li class="nav-item"><a href="Login.php" class="nav-link" aria-current="page">Login</a></li>';
                        }
                    ?>
                      <li class="nav-item"><a href="SearchPage.php" class="nav-link">Search</a></li>
                      <li class="nav-item"><a href="User.php" class="nav-link active">Profile</a></li>
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
            //echo '<h1 align="left" class="h4 mt-1 mb-5 fw-normal">Current User: ' . $_SESSION['username'] . '</h1>';
        ?>
        <img class="mb-4" src="../assets/checkbox.png" alt="" width="144" height="57">
        <h1 class=h3 mb-3 fw-normal u><u>User Contributed Datasets</u></h1>
        <table class="table table-striped table-bordered" id="userTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Tags</th>
                    <th scope="col">Files</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <?php
            $index = 0;
                $username = $_SESSION['username'];
                $query="SELECT title, description, tags FROM  internalDatasets
                      INNER JOIN users ON users.id = internalDatasets.owner_id
                      WHERE users.username = '$username'";
                
                $result = mysqli_query($db, $query) or trigger_error(mysqli_error($db));
                if (mysqli_num_rows($result) === 0) {
                    echo '<h1 align="center" class="h4 mt-1 mb-5 fw-normal">You Have No Datasets.</h1>';
                }
                else{
                    echo "<tbody>";
                    foreach($result as $row) {
                        echo    "<tr>";
                        echo        '<th scope="row">'. $index . '</th>';
                        echo        '<td>'.$row["title"].'</td>';
                        echo        '<td>'.$row["description"].'</td>';
                        echo        '<td>'.$row["tags"].'</td>';
                        echo        '<td><a href="DisplayDataset.php?dataset='. $row['title'] .'&owner_id=' . $_SESSION["id"] . '">View Dataset</a></td>';
                        echo        '<th scope="row">
                                        <form name="delete_dataset" method="post">
                                        <input type="hidden" name="dataset" value="'. $row['title'] . '">
                                        <button type="submit" class="btn btn-info" name="delete_dataset">Delete Dataset</button>
                                        </form>
                                    </th>';
                        echo    "</tr>";
                        $index++;
                    }
                    echo "</tbody>";
                }
            ?>
        </table>
        <a href="CreateDataset.php"><button type="button" class="w-35 mt-1 mb-2 btn btn-m btn-primary">Create Dataset</button></a>

        <h1 class=h3 mb-3 fw-normal u><u>Saved Datasets</u></h1>
        <table class="table table-striped table-bordered" id="userTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Tags</th>
                    <th scope="col">Contributors</th>
                    <th scope="col">View</th>
                </tr>
            </thead>
            <?php
            $index = 0;
                $username = $_SESSION['username'];
                $query="SELECT id.*
                    FROM users u
                    INNER JOIN userInternalDatasets ui
                    ON ui.user_id = u.id
                    INNER JOIN internalDatasets id
                    ON id.id = ui.internal_id
                    WHERE u.username = '$username'";
                
                $resultInternal = mysqli_query($db, $query) or trigger_error(mysqli_error($db));
                
                $query="SELECT ed.*
                    FROM users u
                    INNER JOIN userExternalDatasets ued
                    ON ued.user_id = u.id
                    INNER JOIN externalDatasets ed
                    ON ed.id = ued.external_id
                    WHERE u.username = '$username'";
                
                $resultExternal = mysqli_query($db, $query) or trigger_error(mysqli_error($db));
                if (mysqli_num_rows($resultInternal) === 0 && mysqli_num_rows($resultExternal) === 0) {
                    echo '<h1 align="center" class="h4 mt-1 mb-5 fw-normal">You have no saved datasets.</h1>';
                }
                else{
                    echo "<tbody>";
                    foreach($resultInternal as $row) {
                        $userId = $row['owner_id'];
                        $query = "SELECT * FROM users WHERE id=
                                        '$userId'";
                        $results = mysqli_query($db, $query);
                        $username = mysqli_fetch_array($results)['username'];


                        echo    "<tr>";
                        echo        '<th scope="row">'. $index . '</th>';
                        echo        '<td>'.$row["title"].'</td>';
                        echo        '<td>'.$row["tags"].'</td>';
                        echo        '<td>'. $username.'</td>';
                        echo        '<td><a href="DisplayDataset.php?dataset='. $row['title'] .'&owner_id=' . $_SESSION["id"] . '">View Dataset</a></td>';
                        echo    "</tr>";
                        $index++;
                    }
                    foreach($resultExternal as $row) {
                        echo    "<tr>";
                        echo        '<th scope="row">'. $index . '</th>';
                        echo        '<td>'.$row["title"].'</td>';
                        echo        '<td>'.$row["tags"].'</td>';
                        echo        '<td>(External) '. $row['web_source'] .'</td>';
                        echo        '<td><a href="DatasetView.php?dataset_id='. $row['id'] . '">View Dataset</a></td>';
                        echo    "</tr>";
                        $index++;
                    }
                    echo "</tbody>";
                }
            ?>
        </table>

        <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>

    </main>


</body>
</html>

