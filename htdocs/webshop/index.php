<!DOCTYPE html>
<html>
  <head>
    <title>Web Shop</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php 
      session_start();
      // unset($_SESSION['cart']);
      include 'actions.php';
      include 'components.php';
      // print_r($_POST);
      if(isset($_POST['add_to_cart'])) {
        add_to_cart();
      }
      if (isset($_SESSION['cart'])) {
        print_r($_SESSION['cart']);
      }
    ?>

    <div id="page">
      <header>
        <?php header_component();?>
      </header>

      <main>
        <?php items_grid_component();?>
      </main>

      <nav>
        <?php navigation_component() ?>
      </nav>
    </div>

  </body>
</html>

