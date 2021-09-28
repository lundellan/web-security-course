<?php
  $host = "localhost";
  $username = "root";
  $password = "";
  $database = "webshop";

  $conn = new mysqli($host, $username, $password, $database);

  if(isset($_POST['submit'])) {		
    $username = $_POST['username'];
    $password = $_POST['password'];
    $home_address = $_POST['home_address'];

    $insert = mysqli_query($conn, "INSERT INTO `users`(`username`, `password`, `home_address`) VALUES ('$username','$password', '$home_address')");

    if(!$insert)  {
      // echo mysqli_error();
      echo "Records could not be added.";
    } else  {
      echo "Records added successfully.";
    }
  }
?>