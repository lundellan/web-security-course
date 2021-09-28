<?php

  # User is signed in by setting a session cookie
  function sign_in()  {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "webshop";

    $connection = new mysqli($host, $username, $password, $database);

    if(isset($_POST['sign_in'])) {	
      
      $username = $_POST['username'];
      $password = $_POST['password'];
      $query = "SELECT `password` FROM `users` WHERE username = '$username'";

      $result = mysqli_query($connection, $query);

      if ($result)  {
        if (mysqli_num_rows($result) == 1) {
          $row = $result -> fetch_assoc();
          if ($row["password"] == $password)  {
            setcookie("signed_in", $username, time()+60*60*24*30, "/", "localhost", false, false);
            // refresh_page();
          } else{
            echo "Incorrect password.";
          }
        } else {
          echo "Account does not exist.";
        }
      }
    };

    db_disconnect($connection);
  }
?>