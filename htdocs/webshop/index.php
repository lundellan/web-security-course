<!DOCTYPE html>
<html>
  <head>
    <title>Web Shop</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php 
      include 'actions.php';

      if (validate_session()) {
        echo "Hej " . $_COOKIE['signed_in'];
      }
    ?>

    <div id="page">
      <header>
        <h1>Web Shop</h1>
      </header>

      <main>
        <div>
          <img src="./media/flash.jpg" style="height: 200px; width: 100%;">
          
          <div class="contents">
            <h3>Flash vulnerabilities</h3>

            <form method="post" action="add_to_cart.php">
              <input type=submit name="add_to_cart" value="Add to cart">
            </form>
          </div>
        </div>
        <div>
          <img src="./media/leaked_emails.jpg" style="height: 200px; width: 100%;">

          <div class="contents">
            <h3>Leaked emails and passwords 2021</h3>

            <form method="post" action="add_to_cart.php">
              <input type=submit name="add_to_cart" value="Add to cart">
            </form>
          </div>
        </div>
        <div>
          <img src="./media/script.jpg" style="height: 200px; width: 100%;">

          <div class="contents">
            <h3>XSS scripts</h3>

            <form method="post" action="add_to_cart.php">
              <input type=submit name="add_to_cart" value="Add to cart">
            </form>
          </div>
        </div>
        <div>
          <img src="./media/ddos.jpg" style="height: 200px; width: 100%;">

          <div class="contents">
            <h3>DDoS-as-a-service</h3>

            <form method="post" action="add_to_cart.php">
              <input type=submit name="add_to_cart" value="Add to cart">
            </form>
          </div>
        </div>
      </main>

      <nav>
        <?php 
          if (validate_session()) { 
        ?>

        <section>
          <h2>Cart</h2>
          <form method="post" action="checkout.php">
            <input type=submit name="submit" value="Finish order">
          </form>
        </section>

        <section>
          <h2>Account</h2>
          <form method="post" action=<?php sign_out(); ?>>
            <input type=submit name="sign_out" value="Sign out">
          </form>
        </section>
        
        <?php 
          } else {
        ?>

        <section>
          <h2>Sign in</h2>
          <form method="post" action="<?php sign_in(); ?>">
            Username 
            <input type="text" size="12" name="username"><br /><br />
            Password 
            <input type="password" size="12" name="password"><br /><br />
            <input type=submit name="sign_in" value="Sign in">
          </form>
        </section>

        <section>
          <h2>Create new account</h2>
          <form method="post" action=<?php create_account(); ?>>
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
        ?>
      </nav>
    </div>

  </body>
</html>

