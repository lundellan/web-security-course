<?php 
  session_start();
  include 'actions.php';
  include 'components.php';
  update_cart();
  $visibleItems = update_items();
  //$_SESSION['si_form'] = array();
  ?>

<!DOCTYPE html>
<html>
  <head>
    <title>Mallory Shop</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <header><?php header_component();?></header>
    <main><?php items_component($visibleItems);?></main>
    <nav><?php navigation_component()?></nav>
  </body>
</html>
<?php
  $_SESSION['si_form'] = array();
?>
