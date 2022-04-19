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
$db = mysqli_connect('127.0.0.1', 'db_admin', 'password', 'crowdsource_website_db');

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

		// Storing username of the logged in user,
		// in the session variable
		$_SESSION['username'] = $username;

		// Success message
		$_SESSION['success'] = "You have logged in";

		// Page on which the user will be
		// redirected after logging in
        // header('location: index.php');
        header('location: User.php');
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

        // Create a new directory to store the dataset
        //$db_path = "datasets/" . $title;
        //if (!mkdir($db_path)) {
        //    echo "ERROR: could not create directory " . $db_path;
        //}
        //else {
            // Success message
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
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

    // Check if image file is a actual image or fake image
    //$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    //echo $check;
    //if($check !== true) {
    //    array_push($errors, "File must be an image");
    //}

    // Check if file already exists
    if (file_exists($target_file)) {
        array_push($errors, "File already exists");
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        array_push($errors, "File is too large");
    }

    // Check file format
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png"&& $imageFileType != "jpeg") {
        array_push($errors, "File msut be JPG, JPEG, or PNG");
    }

    // If the form is error free, then create the dataset
    if (count($errors) == 0) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $_SESSION['success'] = "You have successfully uploaded a file";
        }
        else {
            echo "Error uploading your file.";
        }
    }
}

?>
