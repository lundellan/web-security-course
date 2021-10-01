<?php 
session_start();
include 'actions.php';
include 'components.php';

if(isset($_POST['remove_from_cart'])) {
    remove_from_cart();
    header("Location: /webshop/checkout.php"); // Prevent form resubmit
}
if(isset($_POST['empty_cart'])) {
    empty_cart();
    header("Location: /webshop/checkout.php"); // Prevent form resubmit
}
if(isset($_POST['place_order'])) {
    empty_cart();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Web Shop - Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div>
        <header>
            <?php header_component();?>
        </header>

        <?php if(isset($_POST['place_order'])): ?>
        <div>
            Order placed!
            <br />
            <input type="button" value="Continue Shopping" onclick="window.location='/webshop'" />
        </div>
        <?php else: ?>
        <form method="post" action="">
            <table>
                <thead>
                    <tr>
                        <td colspan="2">Product</td>
                        <td>Price</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($_SESSION['cart'])): ?>
                    <tr>
                        <td colspan="3" style="text-align:center;">You have no products added in your Shopping Cart</td>
                    </tr>
                    <?php else: ?>
                    <?php
                    $total_price = 0;
                    foreach ($_SESSION['cart'] as $product) {
                        $total_price += $product['price'];
                    ?>
                    <tr>
                        <td>
                            <img src="<?=$product['img_url']?>" width="50" height="50" alt="<?=$product['title']?>">
                        </td>
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
                        <td colspan="2" style="text-align:right;">Order total:</td>
                        <td>&#8383;<?=$total_price?></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div>
                <input type="button" value="Continue Shopping" onclick="window.location='/webshop'" />
                <?php if (!empty($_SESSION['cart'])): ?>
                <input type="submit" value="Empty Cart" name="empty_cart">
                <input type="submit" value="Place Order" name="place_order">
                <?php endif; ?>
            </div>
        </form>
        <?php endif; ?>
    </div>
</body>

</html>