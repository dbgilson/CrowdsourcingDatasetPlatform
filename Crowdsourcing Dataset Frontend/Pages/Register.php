<?php

/**
  * Use an HTML form to create a new entry in the
  * users table.
  *
  */


if (isset($_POST['submit'])) {
  require "../../config/config.php";
  require "../../config/common.php";

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

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>


<?php if (isset($_POST['submit']) && $statement) { ?>
  > <?php echo $_POST['firstname']; ?> successfully added.
<?php } ?>

<h2>Add a user</h2>

<form method="post">
  <label for="name">Name</label>
  <input type="text" name="name" id="name">
  <label for="username">Username</label>
  <input type="text" name="username" id="username">
  <label for="password">Password</label>
  <input type="text" name="password" id="password">

  <label for="confirmPassword">Confirm Password</label>
  <input type="text" name="confirmPassword" id="confirmPassword">

  <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

