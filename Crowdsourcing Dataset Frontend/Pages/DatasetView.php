<!-- 
    This page is for displaying external datasets only.
    DisplayDataset.php is for internal datasets. 
-->
<?php include('../../config/server.php') ?>
<?php
// session_start();
function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}
if(!isset($_SESSION['dataset_id'])) {
    redirect("location: SearchPage.php");
}

$datasetID = $_SESSION['dataset_id'];
$alreadySaved = false;
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    
    $query = "SELECT * FROM users WHERE username=
                    '$username'";
    $results = mysqli_query($db, $query);
    $user_id = mysqli_fetch_array($results)['id'];
    
    $query="SELECT *
            FROM userExternalDatasets 
            WHERE user_id = '$user_id' AND external_id = '$datasetID'";
    $result = mysqli_query($db, $query) or trigger_error(mysqli_error($db));
    
    if (mysqli_num_rows($result) !== 0) {
        $alreadySaved = true;
    }
}

$query="SELECT * FROM  externalDatasets
    WHERE id = $datasetID";

$result = mysqli_query($db, $query) or trigger_error(mysqli_error($db));
if (mysqli_num_rows($result) === 0) {
    echo '<h1 align="center" class="h4 mt-1 mb-5 fw-normal">You Have No Datasets.</h1>';
}

$DatasetObject = $result->fetch_assoc();

    $image = "../assets/checkbox.png";
    if ($DatasetObject['web_source'] == "Kaggle") {
        $image = "../assets/kaggle.svg";
    }elseif ($DatasetObject['web_source'] == "ICS"){
        $image = "../assets/ics.jpg";
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

            .row {
                display: flex;
            }

            .column {
                flex: 50%;
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
        <img class="mb-4" src=<?=$image?> alt="" width="144" height="57">

        <h1 class="h3 mb-3 fw-normal u"><u> <?= $DatasetObject['title'] ?> </u></h1>

        <span>URL Link: <a target=blank href=<?=$DatasetObject['url']?>><?=$DatasetObject['url']?></a></span>

        <?php 
            if(isset($_SESSION['username'])) {
                if($alreadySaved) {
                    echo '
                    <div>
                    <span>Remove Dataset From Profile:</span>
                    <form name="remove_dataset_external" method="post">
                    <button type="submit" class="btn btn-info" name="remove_dataset_external">Unfollow</button>
                    </form>
                    </div>
                    ';
                }else{
                    echo '
                    <div>
                    <span>Save Dataset To Profile:</span>
                    <form name="save_dataset_external" method="post">
                    <button type="submit" class="btn btn-info" name="save_dataset_external">Follow</button>
                    </form>
                    </div>
                    ';
                }
            }else{
                echo '<span>Login to save to profile!';
            }
        ?>


        <br><br>
        <div class="row">
            <div class="column">
                <h2>Description</h2>
                <p> <?= $DatasetObject['description']?> </p>
            </div>
            <div class="column">
                <h2>Additional Info</h2>
                <span>Source: <?= $DatasetObject['web_source'] ?> </span><br>
                <span>Tags: <?= $DatasetObject['tags'] ?> </span><br>
                <span><?=$DatasetObject['infoKey1'] ?>: <?= $DatasetObject['infoValue1'] ?> </span><br>
                <span><?=$DatasetObject['infoKey2'] ?>: <?= $DatasetObject['infoValue2'] ?> </span><br>
                <span>Licenses: <?= $DatasetObject['licenses'] ?> </span><br>
            </div>
        </div>
        <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
    </main>

</body>
</html>

