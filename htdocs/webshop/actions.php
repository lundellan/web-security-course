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
    if (isset($_SESSION['user'])) {
      return true;
    }
    return false;
  }

  # Refreshes the page
  function refresh_page() {
    header("Location: $_SERVER[REQUEST_URI]");
  }
  # User is signed in by setting a session cookie
  function sign_in()  {
    $connection = db_connect();

    if(isset($_POST['sign_in'])) {	
      
      $username = $_POST['username'];
      $password = $_POST['password'];
      $query = "SELECT `password` FROM `users` WHERE username = '$username'";

      $result = mysqli_query($connection, $query);
      $row = $result -> fetch_assoc();

      if ($result)  {
        if (mysqli_num_rows($result) == 1 && $row["password"] == $password) {
            $_SESSION['user'] = $username;
            refresh_page();
        } else { // Funkar inte
          ?>
          <script>
            window.location.href="../webshop/";
            alert('Order placed!');
          </script>
        <?php
        }
      }
    };

    db_disconnect($connection);
  }

  # User is signed out by destroying the session cookie
  function sign_out() {
    if(isset($_POST['sign_out'])) {	
      session_start();
      session_destroy();
      refresh_page();
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

      if(!$insert)  { // Mecka med denna
        // echo mysqli_error();
        echo "User could not be created.";
      } else  {
        echo "User created successfully.";
      }
    }

    db_disconnect($connection);
  }

   # Updates cart after new POST-action
   function update_cart()  {
    if(isset($_POST['add_to_cart'])) {
      add_to_cart();
      refresh_page();
    }
    if(isset($_POST['remove_from_cart'])) {
      remove_from_cart();
      refresh_page();
    }
    if(isset($_POST['empty_cart'])) {
      empty_cart();
      refresh_page();
    }
  }

  # Adds an item to the cart
  function add_to_cart() {
    if(isset($_POST['productId']) && is_numeric($_POST['productId'])) {
      $productId = intval($_POST['productId']);
      if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        if(!array_key_exists($productId,$_SESSION['cart'])) {
          $_SESSION['cart'][$productId] = get_items([$productId])[0];
        }
      } else {
        $_SESSION['cart'] = array($productId => get_items([$productId])[0]);
      }
    }
  }

  # Removes an item to the cart
  function remove_from_cart() {
    if(isset($_POST['productId']) && is_numeric($_POST['productId'])) {
      $productId = intval($_POST['productId']);
      if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
      }
    }
  }

  # Empties all items from the cart
  function empty_cart() {
    if(isset($_SESSION["cart"])) {
      unset($_SESSION["cart"]);
    }
  }

  # Finishes an order
  function finish_order() {
    if(isset($_POST['place_order'])): 
      empty_cart();
    ?>
      <script>
        window.location.href="../webshop/";
        alert('Order placed!');
      </script>
    <?php
    endif;
  }

  # Gets specified items from the database
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