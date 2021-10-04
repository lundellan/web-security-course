<?php

  # Creates the header section
  function header_component() {
    ?>
      <img src="./media/mallory.jpg">
      <h1>Mallory Shop</h1>
    <?php
  }

  # Creates the grid of products
  function items_component($items = []) {
    foreach(get_items($items) as $item) { 
      ?>
        <div>
          <img src="<?=$item["img_url"]?>">

          <div class="contents">
            <h3><?=$item["title"]?></h3>
            <h4>Special price: <span>&#8383;<?=$item["price"]?></span></h4>

            <?php if (validate_session()): ?>
              <form method="post" action="">
                <input type="hidden" name="productId" value="<?=$item["id"]?>"/>
                <input type=submit name="add_to_cart" value="Add to cart">
              </form>
            <?php endif ?>
          </div>
        </div>
      <?php
    }
  }

  # Creates the right hand side navigation
  function navigation_component()  {
    if (validate_session()) {
      cart_component();
      account_component();
    } else  {
      sign_in_component();
      create_account_component();
    }
  }

  # Creates the cart and order summary section
  function cart_component($index = true)  {
    ?>
      <section>
        <?php if ($index): ?>
        <h2>Shopping Cart</h2>
        <?php else: ?>
        <h2>Order Summary</h2>
        <?php endif; ?>
          <table>
            <tbody>
              <?php if (empty($_SESSION['cart'])): ?>
                <tr>
                  <td>You have no products added in your shopping cart.</td>
                </tr>
              <?php else: 
                $total_price = 0;
                foreach ($_SESSION['cart'] as $product) {
                  $total_price += $product['price']; ?>
                  <tr>
                    <td>
                      <img src="<?=$product['img_url']?>" alt="<?=$product['title']?>">
                    </td>
                    <td style="width: 100%; padding: 0 10px;">
                      <?=$product['title']?><br>
                      <?php if ($index): ?>
                      <form method="post" action="">
                        <input type="hidden" name="productId" value="<?=$product['id']?>">
                        <button type='submit' name='remove_from_cart' value='remove'>Remove</button>
                      </form>
                      <?php endif; ?>
                    </td>
                    <td style='text-align: right;'>
                      &#8383;<?=$product['price']?>
                    </td>
                  </tr>
                <?php } ?>
                <tr>
                  <td></td>
                  <td style="padding-left: 10px;">
                    Order total:
                  </td>
                  <td>
                    &#8383;<?=$total_price?>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>

          <?php if (!empty($_SESSION['cart']) && $index): ?>
            <form method="post" action="">
              <input type="submit" value="Empty cart" name="empty_cart">
              <input type="button" value="Finish order" onclick="window.location='/webshop/checkout.php'" />
            </form>
          <?php endif; if (!empty($_SESSION['cart']) && !$index): ?>
            <input type="button" value="Continue shopping" onclick="window.location='/webshop'" />
          <?php endif; ?>
      </section>
    <?php
  }

  # Creates the account section
  function account_component()  {
    ?>
      <section>
        <h2>Account</h2>
        Welcome back! Signed in as: <?=$_SESSION['user']?><br>
        <form method="post" action='<?=sign_out()?>' style="padding-top: 10px;">
          <input type=submit name="sign_out" value="Sign out">
        </form>
      </section>
    <?php
  }

  # Creates the sign in section
  function sign_in_component()  {
    ?>
      <section>
        <h2>Sign in</h2>
        <form method="post" action="<?=sign_in()?>">
          Username 
          <input type="text" size="12" name="username"><br /><br />
          Password 
          <input type="password" size="12" name="password"><br /><br />
          <input type=submit name="sign_in" value="Sign in">
        </form>
      </section>
    <?php
  }

  # Creates the account creation section
  function create_account_component() {
    ?>
      <section>
        <h2>Create new account</h2>
        <form method="post" action="<?=create_account()?>">
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
    <?php
  }

  # Creates the payment section
  function payment_component()  {
    ?>
      <section>
        <h2>Payment</h2>
        <form method="post" action="">
          Full name
          <input type="text" size="12" name="name"><br /><br />
          Credit card number
          <input type="text" size="12" name="last_name"><br /><br />
          Expiration date 
          <input type="month" size="12" name="username"><br /><br />
          CVC 
          <input type="text" size="12" name="password"><br /><br />
          <input type=submit name="place_order" value="Place order">
        </form>
      </section>
    <?php
  }

?>