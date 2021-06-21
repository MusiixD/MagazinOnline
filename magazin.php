<?php

session_start();
include 'db.php';

$status = "";
if (isset($_POST['code']) && $_POST['code'] != "") {
    $code = $_POST['code'];
    $result = mysqli_query($con, "select * from tbl_product where code = '$code'");
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $code = $row['code'];
    $price = $row['price'];
    $image = $row['image'];

    $cartArray = array(
        $code = array(
            'name' => $name,
            'code' => $code,
            'price' => $price,
            'quantity' => 1,
            'image' => $image),
    );

    if (empty($_SESSION["shopping_cart"])) {
        $_SESSION["shopping_cart"] = $cartArray;
        $status = "<div class='box'>Product is added to your cart!</div>";
    } else {
        $array_keys = array_keys($_SESSION["shopping_cart"]);
        if (in_array($code, $array_keys)) {
            $status = "<div class='box' style='color:red;'>
		Product is already added to your cart!</div>";
        } else {
            $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"], $cartArray);
            $status = "<div class='box'>Product is added to your cart!</div>";
        }

    }
}
?>
<html>
<head>
<title>Magazin</title>
<link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
</head>
<body>
	<style>
body {
  background-image: url('poza_fundal.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: 100% 100%;
    }
</style>
<a href="logout.php" style="color: white">Logout</a>
<div style="width:700px; margin:50 auto; background-color: #b32d00">
<h2 style="color: black; text-align: center; text-decoration-line: underline;">Magazin Telefoane</h2>

<?php
if (!empty($_SESSION["shopping_cart"])) {
    $cart_count = count(array_keys($_SESSION["shopping_cart"]));
    ?>
<div class="cart_div">
<a href="cart.php" ><img src="carticon.png" /> Cart<span><?php echo $cart_count; ?></span></a>
</div>
<?php
}

$result = mysqli_query($con, "SELECT * FROM `tbl_product`");
while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class='product_wrapper'>
			  <form method='post' action=''>
			  <input type='hidden' name='code' value=" . $row['code'] . " />
			  <div class='image'><img src='" . $row['image'] . "' /></div>
			  <div class='name'>" . $row['name'] . "</div>
		   	  <div class='price'>$" . $row['price'] . "</div>
			  <button type='submit' class='buy'>Adauga in cos</button>
			  </form>
		   	  </div>";
}
mysqli_close($con);
?>

<div style="clear:both;"></div>

<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>
</div>

<br /><br />

</div>
</body>
</html>