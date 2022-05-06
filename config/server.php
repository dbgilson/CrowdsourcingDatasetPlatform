<?php

// Starting the session, necessary
// for using session variables
session_start();

// Declaring and hoisting the variables
$username = "";
$email = "";
$errors = array();
$_SESSION['success'] = "";

// DBMS connection code -> hostname,
// username, password, database name
$db = mysqli_connect('127.0.0.1', 'root', '', 'crowdsource_website_db');

// Registration code
if (isset($_POST['reg_user'])) {

	// Receiving the values entered and storing
	// in the variables
	// Data sanitization is done to prevent
	// SQL injections
	// $username = mysqli_real_escape_string($db, $_POST['username']);
	// $email = mysqli_real_escape_string($db, $_POST['email']);
	// $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    // $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    $name = mysqli_real_escape_string($db, $_POST['name']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

	// Ensuring that the user has not left any input field blank
    // error messages will be displayed for every blank input
    if (empty($name)) { array_push($errors, "Name is required"); }
	if (empty($username)) { array_push($errors, "Username is required"); }
    // if (empty($email)) { array_push($errors, "Email is required"); }
	if (empty($password_1)) { array_push($errors, "Password is required"); }

	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
		// Checking if the passwords match
	}

	// If the form is error free, then register the user
	if (count($errors) == 0) {

		// Password encryption to increase data security
		$password = md5($password_1);

		// Inserting data into table
		// $query = "INSERT INTO users (username, email, password)
                //                VALUES('$username', '$email', '$password')";

                $query = "INSERT INTO users (name, username, password)
                                VALUES('$name', '$username', '$password')";

             mysqli_query($db, $query);
             
             $query = "SELECT * FROM users WHERE username=
                    '$username' AND password='$password'";
             $results = mysqli_query($db, $query);

            // $results = 1 means that one user with the
            // entered username exists
            if (mysqli_num_rows($results) == 1) {

                // Storing username and id in session variables
                 $_SESSION['username'] = $username;
                 $_SESSION['id'] = mysqli_fetch_array($results)['id'];

                    // Success message
                 $_SESSION['success'] = "You have logged in!";

                // Page on which the user is sent
                     // to after logging in
                 header('location: User.php');
     	    }
	}
}

// User login
if (isset($_POST['login_user'])) {

	// Data sanitization to prevent SQL injection
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['password']);

	// Error message if the input field is left blank
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// Checking for the errors
	if (count($errors) == 0) {

		// Password matching
		$password = md5($password);

		$query = "SELECT * FROM users WHERE username=
				'$username' AND password='$password'";
		$results = mysqli_query($db, $query);

		// $results = 1 means that one user with the
		// entered username exists
		if (mysqli_num_rows($results) == 1) {

		    // Storing username and id in session variables
		    $_SESSION['username'] = $username;
                    $_SESSION['id'] = mysqli_fetch_array($results)['id'];

	    	    // Success message
                    $_SESSION['success'] = "You have logged in!";

		    // Page on which the user is sent
		    // to after logging in
                    //header('location: index.php');
                    header('location: User.php');
                    //header('location: CreateDataset.php');
		}
		else {

			// If the username and password doesn't match
			array_push($errors, "Username or password incorrect");
		}
	}
}

// Create a new dataset
if (isset($_POST['create_dataset'])) {

    $title = mysqli_real_escape_string($db, $_POST['title']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $tags = mysqli_real_escape_string($db, $_POST['tags']);

    // Ensuring that the user has not left any input field blank
    // error messages will be displayed for every blank input that is required
    if (empty($title)) { array_push($errors, "Title is required"); }
    if (empty($description)) { array_push($errors, "Description is required"); }

    // Ensure that the title is unique
    if (file_exists("datasets/" . $title)) {
        array_push($errors, "Title is taken");
    }

    // Create a new directory to store the dataset and check if successful
    $db_path = "datasets/" . $title;
    if (!mkdir($db_path)) {
        array_push($errors, "ERROR: could not create directory " . $db_path);
    }

    // Ensuring that the title is a valid directory name
    //if (preg_match('/^[\/\w\-. ]+$/', $title)) {
    //    array_push($errors, "Title must be a valid directory name");
    //}

    // If the form is error free, then create the dataset
    if (count($errors) == 0) {

        // Create a new row in the internalDatasets table
        // FIXME Add a column for number of datapoints in the dataset FIXME
        $owner_id = $_SESSION['id'];
        $query = "INSERT INTO internalDatasets (title, description, tags, owner_id)
                    VALUES('$title', '$description', '$tags', '$owner_id')";

        mysqli_query($db, $query) or trigger_error(mysqli_error($db));

        $target_dir = "datasets/" . $title . "/";
        $countfiles = count($_FILES["fileToUpload"]["name"]);
        for($i = 0; $i < $countfiles; $i++){
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);

            // Check if file already exists
            if (file_exists($target_file)) {
                array_push($errors, "File already exists");
            }

            // Check file size
            if ($_FILES["fileToUpload"]["size"][$i] > 500000) {
               array_push($errors, "File is too large");
            }

            // Check file format
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png"&& $imageFileType != "jpeg") {
                array_push($errors, "File msut be JPG, JPEG, or PNG");
            }

            // If the form is error free, then create the dataset
            if (count($errors) == 0) {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
                    $_SESSION['success'] = "You have successfully uploaded a file";
                }
                else {
                    echo "Error uploading your file.";
                }
            }
        }
        $_SESSION['success'] = "You have created a new dataset";

            // Page on which the user will be
            // redirected after logging in
        header('location: User.php');
        //}
    }
}

// Upload an image to a dataset
if (isset($_POST['upload_image'])) {
    $target_dir = "datasets/" . $_SESSION['dataset'] . "/";
    $countfiles = count($_FILES["fileToUpload"]["name"]);
    for($i = 0; $i < $countfiles; $i++){
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);

    // Check if file already exists
    if (file_exists($target_file)) {
        array_push($errors, "File already exists");
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"][$i] > 500000) {
        array_push($errors, "File is too large");
    }

    // Check file format
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png"&& $imageFileType != "jpeg") {
        array_push($errors, "File msut be JPG, JPEG, or PNG");
    }

    // If the form is error free, then create the dataset
    if (count($errors) == 0) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
            $_SESSION['success'] = "You have successfully uploaded a file";
        }
        else {
            echo "Error uploading your file.";
        }
    }
}
}

// Delete an image from a dataset
if (isset($_POST['delete_image'])) {
    // FIXME Make it so only the dataset owner can delete images

    if (!unlink($_POST['delete_image'])) {
        array_push($errors, "File counld not be deleted");
    }
}

// Delete a dataset
if (isset($_POST['delete_dataset'])) {
    $dataset = $_SESSION['dataset'];
    $dataset_path = './datasets/' . $dataset;

    // Remove the dataset from the internalDatasets table
    $query = "DELETE FROM internalDatasets WHERE title='" . $dataset . "';";
    mysqli_query($db, $query);

    // Delete the dataset directory
    foreach (scandir($dataset_path) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        else {
            $file_path = $dataset_path . "/" . $item;
            unlink($file_path);
        }
    }
    rmdir($dataset_path);
}

// Zips up a dataset directory and downloads it
if (isset($_POST['download_dataset'])) {
    // Get real path for our folder
    //$rootPath = realpath('./datasets/Plants');
    $path = './datasets/' . $_SESSION['dataset'];
    $rootPath = realpath($path);
    $zipFile = $_SESSION['dataset'] . '.zip';
    //$zipFile = 'Plants.zip';

    // Initialize archive object
    $zip = new ZipArchive();
    $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    // Create recursive directory iterator
    /** @var SplFileInfo[] $files */
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootPath),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $name => $file)
    {
        // Skip directories (they would be added automatically)
        if (!$file->isDir())
        {
            // Get real and relative path for current file
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rootPath) + 1);

            // Add current file to archive
            $zip->addFile($filePath, $relativePath);
        }
    }

    // Zip archive will be created only after closing object
    $zip->close();

    //Force download a file in php
    if (file_exists($zipFile)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($zipFile) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($zipFile));
            readfile($zipFile);
    }

    // Delete the created .zip file
    if (!unlink($zipFile)) {
        array_push($errors, "File counld not be deleted");
    }
}

// Search Datasets
if (isset($_POST['search_datasets'])) {
    $_SESSION['search_performed'] = True;
	// Data sanitization to prevent SQL injection
    try {
        error_reporting(E_ERROR | E_PARSE);
        $searchString = mysqli_real_escape_string($db, $_POST['searchString']);
        if (empty($searchString)) {
            array_push($errors, "Must enter some search term");
        }
        
        $searchTerms = explode(" ", trim($searchString)) ;
    
        $queryIn = "SELECT * FROM internalDatasets WHERE "; 
        $queryEx = "SELECT * FROM externalDatasets WHERE ";
    
        foreach ($searchTerms as &$term) {
            $queryIn .= "tags LIKE '%$term%' OR title LIKE '%$term%' OR ";
            $queryEx .= "tags LIKE '%$term%' OR title LIKE '%$term%' OR ";
        }
        $queryIn = substr($queryIn, 0, -3);
        $queryEx = substr($queryEx, 0, -3);
    }catch(Error) {
        array_push($errors, "Must enter some search term");
    }
	// Error message if the input field is left blank
    // Checking for the errors
	if (count($errors) == 0) {

		$resultsEx = mysqli_query($db, $queryEx);
        $resultsIn = mysqli_query($db, $queryIn);

        $_SESSION['ex_search_results'] = $resultsEx;
        $_SESSION['in_search_results'] = $resultsIn;
    } else {
        ;
        // If the username and password doesn't match
        // array_push($errors, "Username or password incorrect");
    }
}

// Create a new dataset
if (isset($_POST['save_dataset_external'])) {
    $datasetID = mysqli_real_escape_string($db, $_SESSION['id']);
    
    // Ensuring that the user has not left any input field blank
    // error messages will be displayed for every blank input that is required
    if (empty($datasetID)) { array_push($errors, "Dataset ID is required"); }

    $username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username=
                '$username'";
    $results = mysqli_query($db, $query);

    // $results = 1 means that user was found
    if (mysqli_num_rows($results) != 1) {
        array_push($errors, "No user logged in");
    }else{
        $user_id = mysqli_fetch_array($results)['id'];
        $query = "SELECT * FROM userExternalDatasets
                    WHERE user_id='$user_id' AND external_id='$datasetID'";
        $results = mysqli_query($db, $query) or trigger_error(mysqli_error($db));
        if (mysqli_num_rows($results) != 0) {
            array_push($errors, "Dataset already saved to profile");
        }
    }

    // If the form is error free, then save the dataset
    if (count($errors) == 0) {
        $query = "INSERT INTO userExternalDatasets (user_id, external_id)
                    VALUES('$user_id', '$datasetID')";
        mysqli_query($db, $query) or trigger_error(mysqli_error($db));
        
        $_SESSION['success'] = "You have saved a dataset to your profile";


    }
}

if (isset($_POST['remove_dataset_external'])) {
    $datasetID = mysqli_real_escape_string($db, $_SESSION['id']);

    // Ensuring that the user has not left any input field blank
    // error messages will be displayed for every blank input that is required
    if (empty($datasetID)) { array_push($errors, "Dataset ID is required"); }

    $username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username=
                '$username'";
    $results = mysqli_query($db, $query);

    // $results = 1 means that user was found
    if (mysqli_num_rows($results) != 1) {
        array_push($errors, "No user logged in");
    }else{
        $user_id = mysqli_fetch_array($results)['id'];
    }
    
    // If the form is error free, then save the dataset
    if (count($errors) == 0) {
        $query = "DELETE FROM userExternalDatasets
                    WHERE user_id='$user_id' AND external_id='$datasetID'";
        mysqli_query($db, $query) or trigger_error(mysqli_error($db));
        
        $_SESSION['success'] = "You have removed a dataset from your profile";
    }
}


// Create a new dataset
if (isset($_POST['save_dataset_internal'])) {
    $datasetName = mysqli_real_escape_string($db, $_SESSION['dataset']);

    // Ensuring that the user has not left any input field blank
    // error messages will be displayed for every blank input that is required
    if (empty($datasetName)) { array_push($errors, "Dataset ID is required"); }

    $query = "SELECT * FROM internalDatasets WHERE title=
                    '$datasetName'";
    $results = mysqli_query($db, $query);

    $datasetID = mysqli_fetch_array($results)['id'];
    $username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username=
                '$username'";
    $results = mysqli_query($db, $query);

    // $results = 1 means that user was found
    if (mysqli_num_rows($results) != 1) {
        array_push($errors, "No user logged in");
    }else{
        $user_id = mysqli_fetch_array($results)['id'];
        $query = "SELECT * FROM userInternalDatasets
                    WHERE user_id='$user_id' AND internal_id='$datasetID'";
        $results = mysqli_query($db, $query) or trigger_error(mysqli_error($db));
        if (mysqli_num_rows($results) != 0) {
            array_push($errors, "Dataset already saved to profile");
        }
    }

    // If the form is error free, then save the dataset
    if (count($errors) == 0) {
        $query = "INSERT INTO userInternalDatasets (user_id, internal_id)
                    VALUES('$user_id', '$datasetID')";
        mysqli_query($db, $query) or trigger_error(mysqli_error($db));
        
        $_SESSION['success'] = "You have saved a dataset to your profile";


    }
}

if (isset($_POST['remove_dataset_internal'])) {
    $datasetName = mysqli_real_escape_string($db, $_SESSION['dataset']);

    // Ensuring that the user has not left any input field blank
    // error messages will be displayed for every blank input that is required
    if (empty($datasetName)) { array_push($errors, "Dataset ID is required"); }
    
    $query = "SELECT * FROM internalDatasets WHERE title=
                    '$datasetName'";
    $results = mysqli_query($db, $query);
    
    $datasetID = mysqli_fetch_array($results)['id'];
    $username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username=
                '$username'";
    $results = mysqli_query($db, $query);

    // $results = 1 means that user was found
    if (mysqli_num_rows($results) != 1) {
        array_push($errors, "No user logged in");
    }else{
        $user_id = mysqli_fetch_array($results)['id'];
    }
    
    // If the form is error free, then save the dataset
    if (count($errors) == 0) {
        $query = "DELETE FROM userInternalDatasets
                    WHERE user_id='$user_id' AND internal_id='$datasetID'";
        mysqli_query($db, $query) or trigger_error(mysqli_error($db));
        
        $_SESSION['success'] = "You have removed a dataset from your profile";
    }
}

if (isset($_GET['dataset'])) {
    $_SESSION['dataset'] = $_GET['dataset'];
}

if (isset($_GET['id'])) {
    $_SESSION['id'] = $_GET['id'];
}


?>
