<?php

  # Connects the client to the database
  function db_connect() {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "webshop";

    return new mysqli($host, $username, $password, $database);
  }

  # Disconnects client from the database
  function db_disconnect($connection)  {
    mysqli_close($connection);
  }

  # Validates if a session is active
  function validate_session() {
    return isset($_SESSION['username']);
  }

  function refresh_page() {
    header("Location: /webshop/");
  }

  # User is signed in by setting a session cookie
  function sign_in()  {
    $connection = db_connect();

    if(isset($_POST['sign_in'])) {	
      
      $username = $_POST['username'];
      $password = $_POST['password'];
      $query = "SELECT `password` FROM `users` WHERE username = '$username'";

      $result = mysqli_query($connection, $query);

      if ($result)  {
        if (mysqli_num_rows($result) == 1) {
          $row = $result -> fetch_assoc();
          if ($row["password"] == $password)  {
            // setcookie("signed_in", $username, time()+60*60*24*30, "/", "localhost", false, false);
            // session_register('username');
            $_SESSION['username'] = $username;
            // refresh_page();
          } else{
            echo "Incorrect password."; // Does currently not work
          }
        } else {
          echo "Account does not exist."; // Does currently not work
        }
      }
    };

    db_disconnect($connection);
  }

  # User is signed out by destroying the session cookie
  function sign_out() {
    // if(isset($_POST['sign_out'])) {	
    //   if (isset($_COOKIE['signed_in'])) {
    //     unset($_COOKIE['signed_in']); 
    //     setcookie('signed_in', "", -1, '/'); 
    //     refresh_page();
    //   }
    // }
    unset($_SESSION['username']);
    session_destroy();
  }

  # Creates a new account
  function create_account() {
    $connection = db_connect();

    if(isset($_POST['create_account'])) {		
      $username = $_POST['username'];
      $password = $_POST['password'];
      $home_address = $_POST['home_address'];

      $query = "INSERT INTO `users`(`username`, `password`, `home_address`) VALUES ('$username','$password', '$home_address')";

      $insert = mysqli_query($connection, $query);

      if(!$insert)  {
        // echo mysqli_error();
        echo "User could not be created.";
      } else  {
        echo "User created successfully.";
      }
    }

    db_disconnect($connection);
  }

?>