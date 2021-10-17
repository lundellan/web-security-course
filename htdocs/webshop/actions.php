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

  # Verify the CSRF token
  function valid_csrf_token() {
    if (!empty($_POST['csrf_token'])) {
      return hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
    }
    return false;
  }

   # Sets the user as signed in in the session
   function set_user_as_signed_in($username, $home_address) {
    session_regenerate_id();
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $_SESSION['user'] = $username;
    $_SESSION['home_address'] = $home_address;
    refresh_page();
  }

  # Checks user credentials
  function sign_in()  {
    if(isset($_POST['sign_in'])) {	
      $username = $_POST['username'];
      $password = $_POST['password'];

      include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
      $securimage = new Securimage();
      $captcha_valid = false;
      if ($securimage->check($_POST['captcha_code']) == true) {
        $captcha_valid = true;
      }

      if ($captcha_valid) {
        $connection = db_connect();
        $query = "SELECT * FROM `users` WHERE username = ?";

        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
  
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
  
        if ($result)  {
          if (mysqli_num_rows($result) == 1 && password_verify($_POST['password'], $row['password'])) {
            set_user_as_signed_in($row['username'], $row["home_address"]);
          }
        }
        db_disconnect($connection);
      }
    }
  }

  # User is signed out by destroying the session cookie
  function sign_out() {
    if(isset($_POST['sign_out'])) {	
      session_destroy();
      refresh_page();
    }
  }

  # Creates a new account
  function create_account() {
    $connection = db_connect();

    if(isset($_POST['create_account'])) {	
      $password = htmlspecialchars($_POST['password']);

      if (strlen($password) >= 8 && strlen($password) <= 72) {
        $query = "SELECT count(*) as count FROM blacklist WHERE password = ?";

        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $password);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] == 0)  {
          $username = htmlspecialchars($_POST['username']);
          $options = [
            'cost' => 10
          ];
          $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_BCRYPT, $options);
          $home_address = htmlspecialchars($_POST['home_address']);

          $query = "INSERT INTO `users`(`username`, `password`, `home_address`) VALUES (?,?, ?)";

          $stmt = $connection->prepare($query);
          $stmt->bind_param("sss", $username, $password, $home_address);
          $stmt->execute();
          set_user_as_signed_in($username, $home_address);
        }
    }
    }

    db_disconnect($connection);
  }

  # Updates the visible products according to the given keyword
  function update_items() {
    $results_array = [];

    if(isset($_GET['keyword']) && $_GET['keyword'] != "") {
      $connection = db_connect();

      $keyword = "%{$_GET['keyword']}%";
      $query = "SELECT id FROM catalogue WHERE title LIKE ?";

      $stmt = $connection->prepare($query);
      $stmt->bind_param("s", $keyword);
      $stmt->execute();

      $result = $stmt->get_result();
  
      if ($result)  {
        while($row = mysqli_fetch_assoc($result)) {
          $results_array[] = $row['id'];
        }
      }

      db_disconnect($connection);
    }

    return $results_array;
  }

   # Updates cart after new POST-action
   function update_cart()  {
    if(isset($_POST['add_to_cart']) && valid_csrf_token()) {
      add_to_cart();
      refresh_page();
    }
    if(isset($_POST['remove_from_cart']) && valid_csrf_token()) {
      remove_from_cart();
      refresh_page();
    }
    if(isset($_POST['empty_cart']) && valid_csrf_token()) {
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
    if(isset($_POST['place_order']) && valid_csrf_token()): 
      empty_cart();
    ?>
      <script>
        alert('Order placed!');
        window.location.href="../webshop/";
      </script>
    <?php
    endif;
  }

  # Gets specified items from the database
  function get_items($items = []) {
    $connection = db_connect();

    $type = "";
    $query = "SELECT * FROM `catalogue`";

    for ($x = 0; $x < sizeof($items); $x++)  {
      $type .= "s";
      if ($x == 0) {
        $query .= " WHERE id = ?";
      } else  {
        $query .= " OR id = ?";
      }
    }

    $stmt = $connection->prepare($query);
    if (!sizeof($items) == 0)  {
      $stmt->bind_param($type, ...$items);
    }
    $stmt->execute();

    $result = $stmt->get_result();
    $results_array = [];

    while($row = $result->fetch_assoc()) {
      $results_array[] = $row;
    }
    
    return $results_array;

    db_disconnect($connection);
  }

?>