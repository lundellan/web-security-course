<?php 
  session_start();
  include 'actions.php';
  include 'components.php';
  update_cart();
  finish_order();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Mallory Shop - Checkout</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <header><?php header_component();?></header>
    <nav><?php cart_component(false); payment_component();?></nav>
  </body>
</html>