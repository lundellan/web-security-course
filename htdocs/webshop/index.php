<!DOCTYPE html>
<html>
  <head>
    <title>Web Shop</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php 
      include 'create_account.php';
    ?>

    <div id="page">
      <header>
        <h1>
          <?php echo "Web Shop" ?>
        </h1>
      </header>

      <main>
        <div></div>
        <div></div>
        <div></div>
      </main>

      <nav>
        <section>
          <h2>Sign in</h2>
          <form method="post" action="sign_in.php">
            Username 
            <input type="text" size="12" name="username"><br /><br />
            Password 
            <input type="password" size="12" name="password"><br /><br />
            <input type=submit value="Sign in">
          </form>
        </section>

        <section>
          <h2>Create new account</h2>
          <form method="post" action="create_account.php">
            Choose your username
            <input type="text" size="12" name="username"><br /><br />
            Choose your password,
            <i>it should at least contain the following:</i><br>
            <ul>
              <li>eight characters in total,</li>
              <li>one capital letter,</li>
              <li>and one digit.</li>
            </ul>
            <input type="password" size="12" name="password"><br /><br />
            Enter your home address
            <input type="text" size="12" name="home_address"><br /><br />
            <input type=submit name="submit" value="Create account">
          </form>
        </section>

        <section>
          <h2>Shopping bag</h2>
          <form method="post" action="order.php">
            <input type=submit value="Finish order">
          </form>
        </section>

        <section>
          <h2>Account</h2>
          <form method="post" action="account_actions.php">
            <input type=submit value="Sign out">
          </form>
        </section>
      </nav>
    </div>

  </body>
</html>

