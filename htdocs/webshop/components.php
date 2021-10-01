<?php

  function header_component() {
    echo '
      <img src="./media/mallory.jpg">
      <h1>Mallory Shop</h1>
    ';
  }

  function navigation_component()  {
    if (validate_session()) {
      signed_in_navigation();
    } else  {
      signed_out_navigation();
    }
  }

  function signed_out_navigation()  {
    echo '
      <section>
        <h2>Sign in</h2>
        <form method="post" action=' . sign_in() . '>
          Username 
          <input type="text" size="12" name="username"><br /><br />
          Password 
          <input type="password" size="12" name="password"><br /><br />
          <input type=submit name="sign_in" value="Sign in">
        </form>
      </section>

      <section>
        <h2>Create new account</h2>
        <form method="post" action=' . create_account() . '>
          Choose your username
          <input type="text" size="12" name="username"><br /><br />
          Choose your password
          <!-- <i>it should at least contain the following:</i><br>
          <ul>
            <li>eight characters in total,</li>
            <li>one capital letter,</li>
            <li>and one digit.</li>
          </ul> -->
          <input type="password" size="12" name="password"><br /><br />
          Enter your home address
          <input type="text" size="12" name="home_address"><br /><br />
          <input type=submit name="create_account" value="Create account">
        </form>
      </section>
    ';
  }

  function signed_in_navigation() {
    ?>
      <section>
        <h2>Shopping Cart</h2>
        <form method="post" action="">
          <table>
              <tbody>
                  <?php if (empty($_SESSION['cart'])): ?>
                  <tr>
                      <td colspan="2" style="text-align:center;">You have no products added in your Shopping Cart</td>
                  </tr>
                  <?php else: ?>
                  <?php
                  $total_price = 0;
                  foreach ($_SESSION['cart'] as $product) {
                      $total_price += $product['price'];
                  ?>
                  <tr>
                      <td>
                          <?=$product['title']?>
                          <br>
                          <form method="post" action="">
                              <input type="hidden" name="productId" value="<?=$product['id']?>">
                              <button type='submit' name='remove_from_cart' value='remove'>Remove</button>
                          </form>
                      </td>
                      <td>&#8383;<?=$product['price']?></td>
                  </tr>
                  <?php } ?>
                  <tr>
                      <td style="text-align:right;">Order total:</td>
                      <td>&#8383;<?=$total_price?></td>
                  </tr>
                  <?php endif; ?>
              </tbody>
          </table>
          <?php if (!empty($_SESSION['cart'])): ?>
            <input type="submit" value="Empty Cart" name="empty_cart">
            <input type="button" value="Finish order" onclick="window.location='/webshop/checkout.php'" />
          <?php endif; ?>
        </form>
      </section>
    
    <section>
        <h2>Account</h2>
        Welcome, <?= $_COOKIE['signed_in']?>
        <form method="post" action='<?php sign_out() ?>'>
          <input type=submit name="sign_out" value="Sign out">
        </form>
      </section>
    <?php
  }

  function items_grid_component($items = []) {
    foreach(get_items($items) as $item) {
      item_component($item);
    }
  }

  function item_component($item)  {
    echo '
      <div>
        <img src=' . $item["img_url"] . '>
        
        <div class="contents">
          <h3>' . $item["title"] . '</h3>
          <h4>Special price:<br><br> <span>&#8383;' . $item["price"] . '</span></h4>

          <form method="post" action="">
            <input type="hidden" name="productId" value=' . $item["id"] . ' />
            <input type=submit name="add_to_cart" value="Add to cart">
          </form>
        </div>
      </div>
    ';
  }

?>