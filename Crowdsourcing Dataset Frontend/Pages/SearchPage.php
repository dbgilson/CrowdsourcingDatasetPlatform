<?php
unset($_SESSION['ex_search_results']);// for not displaying "No Results Found" on first load
include('../../config/server.php');

function isFreed(mysqli_result $result) {
    return @($result->num_rows === NULL);
}
// unset($_POST['searchString']);
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}
$foundDatasets = 0;
$displayExResults = false;
$displayInResults = false;
try {
    if(isset($_SESSION['ex_search_results'])) {
        $foundDatasets += $_SESSION['ex_search_results']->num_rows;    
        $displayExResults = true;
    }
}catch(Error) {
    ;
}
try {
    if(isset($_SESSION['in_search_results'])) {
        $foundDatasets += $_SESSION['in_search_results']->num_rows;
        $displayInResults = true;
    }
}catch(Error) {
    ;
}
?>
<?php 
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
                        }else {
                            echo '<li class="nav-item"><a href="Login.php" class="nav-link" aria-current="page">Login</a></li>';
                        }
                    ?>
                      <li class="nav-item"><a href="SearchPage.php" class="nav-link active">Search</a></li>
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
        <!-- <?php
            echo '<h1 align="left" class="h4 mt-1 mb-5 fw-normal">Current User: ' . $_SESSION['username'] . '</h1>';
        ?> -->
        <!-- <?php include('../../config/errors.php'); ?> -->



        <form class="form-upload" method='post' action="SearchPage.php">
            <div class="input-group mb-3">
                <input type="text" class="form-control rounded" placeholder="Search Datasets" aria-label="Search" aria-describedby="search-addon" id="searchString" name="searchString" />
                <button type="submit" class="btn btn-outline-primary" id="addTag" name="search_datasets">Search</button>
            </div>
        </form>

        <img class="mb-4" src="../assets/checkbox.png" alt="" width="144" height="57">
        
        <h1 class=h3 mb-3 fw-normal u><u><?php echo $foundDatasets ?> Datasets Found</u></h1>
        
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
                echo '<tbody>';
                $count = 1;
                if($displayInResults) {
                    // echo count(($_SESSION['search_results']));
                    while($row = $_SESSION['in_search_results']->fetch_assoc()) {
                        $userId = $row['owner_id'];
                        $query = "SELECT * FROM users WHERE id=
                                        '$userId'";
                        $results = mysqli_query($db, $query);
                        $username = mysqli_fetch_array($results)['username'];
                        
                        echo '<tr>
                        <th scope="row">'. $count++ .'</th>
                        <td>'. $row['title']. '</td>
                        <td>'. $row["tags"] .'</td>';
                        echo'<td>'. $username .'</td>';
                        echo '<td><a href="DisplayDataset.php?dataset='. $row['title'] .'&owner_id=' . $row['owner_id'] . '">Details</a></td>
                        </tr>';
                    }
                }
                if($displayExResults) {
                    // echo count(($_SESSION['search_results']));
                    while($row = $_SESSION['ex_search_results']->fetch_assoc()) {
                        echo '<tr>
                            <th scope="row">'. $count++ .'</th>
                            <td>'. $row['title']. '</td>
                            <td>'. $row["tags"] .'</td>';
                            echo '<td>(External) '. $row['web_source'] .'</td>';
                            echo '<td><a href="DatasetView.php?dataset_id= '.$row['id'] . '">Details</a></td>
                        </tr>';
                    }
                }
                echo '</tbody>';
            ?>
        </table>

        <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>

    </main>


</body>
</html>

