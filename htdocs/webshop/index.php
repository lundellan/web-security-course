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

