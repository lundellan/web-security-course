<?php 
  session_start();
  include 'actions.php';
  include 'components.php';
  update_cart();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Mallory Shop</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <header><?php header_component();?></header>
    <main><?php items_component();?></main>
    <nav><?php navigation_component()?></nav>
  </body>
</html>

