<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Crowdsourcing Dataset Platform</title>
    <?php


$name_error = $username_error = $password_error = $passwordMatch_error = "";
$name = $username = $password = "";
$testDatasetObject = [
    "web_source" => "ICS",
    "url" => "keggle.com",
    "title" => "Dataset Title",
    "licenses" => "open source, other license",
    "tags" => "test, key, word",
    "description" => "This is a description of the dataset",
    "infoKey1" => "Usability Rating",
    "infoValue1" =>  '.88',
    "infoKey2" => "Total Downloads",
    "infoValue2" => '579'
];
    $image = "../assets/checkbox.png";
    if ($testDatasetObject['web_source'] == "Kaggle") {
        $image = "../assets/kaggle.svg";
    }elseif ($testDatasetObject['web_source'] == "ICS"){
        $image = "../assets/ics.jpg";
    }
    
    ?>
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
                    <li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Login</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Search</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Profile</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Help</a></li>
                </ul>
            </header>
        </div>
        <img class="mb-4" src=<?=$image?> alt="" width="144" height="57">
        <h1 class="h3 mb-3 fw-normal u"><u> <?= $testDatasetObject['title'] ?> </u></h1>
        <span>URL Link: <a href=<?=$testDatasetObject['url']?>><?=$testDatasetObject['url']?></a></span>
        <!-- <h1 class="h3 mb-3 fw-normal u"><u> This is the Title </u></h1>
        <span>URL Link: <a href="https://www.kaggle.com/datasets/kkhandekar/sulfur-dioxide-pollution">https://www.kaggle.com/datasets/kkhandekar/sulfur-dioxide-pollution</a></span> -->
        <br><br>
        <div class="row">
            <div class="column">
                <h2>Description</h2>
                <p> <?= $testDatasetObject['description']?> </p>
            </div>
            <div class="column">
                <h2>Additional Info</h2>
                <span>Source: <?= $testDatasetObject['web_source'] ?> </span><br>
                <span>Tags: <?= $testDatasetObject['tags'] ?> </span><br>
                <!-- <span>Tags: <?= str_replace(",", " ", $testDatasetObject['tags']) ?> </span><br> -->
                <span><?=$testDatasetObject['infoKey1'] ?>: <?= $testDatasetObject['infoValue1'] ?> </span><br>
                <span><?=$testDatasetObject['infoKey2'] ?>: <?= $testDatasetObject['infoValue2'] ?> </span><br>
                <!-- <span>Licenses: <?= str_replace(",", " ", $testDatasetObject['licenses']) ?> </span><br> -->
                <span>Licenses: <?= $testDatasetObject['licenses'] ?> </span><br>
            </div>
        </div>
        <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
    </main>

    <?php
    $name_error = $username_error = $password_error = $passwordMatch_error = "";
    $name = $username = $password = "";
    $testDatasetObject = [
        "web_source" => "kaggle",
        "url" => "keggle.com",
        "title" => "Dataset Title",
        "licenses" => ["open source", "other license"],
        "tags" => ["test", "key", "word"],
        "description" => "This is a description of the dataset",
        "infoKey1" => "Usability Rating",
        "infoValue1" =>  '.88',
        "infoKey2" => "Total Downloads",
        "infoValue2" => '579'
    ]
    ?>

</body>
</html>

