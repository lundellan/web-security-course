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
    if (isset($_COOKIE['signed_in'])) {
      return true;
    }
    return false;
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
            setcookie("signed_in", $username, time()+60*60*24*30, "/", "localhost", false, false);
            refresh_page();
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
    if(isset($_POST['sign_out'])) {	
      if (isset($_COOKIE['signed_in'])) {
        unset($_COOKIE['signed_in']); 
        setcookie('signed_in', "", -1, '/'); 
        refresh_page();
      }
    }
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

  function add_to_cart() {
    if(isset($_POST['productId']) && is_numeric($_POST['productId'])) {
      $productId = intval($_POST['productId']);
      if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        if(!array_key_exists($productId,$_SESSION['cart'])) {
          $_SESSION['cart'][$productId] = get_items([$productId])[0];
        }
      }
      else {
        $_SESSION['cart'] = array($productId => get_items([$productId])[0]);
      }
    }
  }

  function remove_from_cart() {
    if(isset($_POST['productId']) && is_numeric($_POST['productId'])) {
      $productId = intval($_POST['productId']);
      if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
      }
    }
  }

  function empty_cart() {
    if(isset($_SESSION["cart"])) {
      unset($_SESSION["cart"]);
    }
  }

  function get_items($items = []) {
    $connection = db_connect();

    $query = "SELECT * FROM `catalogue`";

    for ($x = 0; $x < sizeof($items); $x++)  {
      if ($x == 0) {
        $query .= " WHERE id = {$items[$x]}";
      } else  {
        $query .= " OR id = {$items[$x]}";
      }
    }

    $result = mysqli_query($connection, $query);
    $results_array = [];

    while($row = mysqli_fetch_assoc($result)) {
      $results_array[] = $row;
    }
    
    return $results_array;

    db_disconnect($connection);
  }

?>