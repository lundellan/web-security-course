<!DOCTYPE html>
<html>
  <head>
    <title>Web Shop</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php 
      session_start();
      include 'actions.php';
      include 'components.php';
      if(isset($_POST['add_to_cart'])) {
        add_to_cart();
        header("Location: /webshop/"); // Prevent form resubmit
      }
      if(isset($_POST['remove_from_cart'])) {
        remove_from_cart();
        header("Location: /webshop/"); // Prevent form resubmit
      }
      if(isset($_POST['empty_cart'])) {
        empty_cart();
        header("Location: /webshop/"); // Prevent form resubmit
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

