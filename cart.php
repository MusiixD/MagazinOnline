<?php

session_start();


$status = "";
if (isset($_POST['action']) && $_POST['action'] == "remove") {
    if (!empty($_SESSION["shopping_cart"])) {
        foreach ($_SESSION["shopping_cart"] as $key => $value) {
            if ($_POST["code"] == $key) {
                unset($_SESSION["shopping_cart"][$key]);
                $status = "<div class='box' style='color:red;'>
		Product is removed from your cart!</div>";
            }
            if (empty($_SESSION["shopping_cart"])) {
                unset($_SESSION["shopping_cart"]);
            }

        }
    }
}

if (isset($_POST['action']) && $_POST['action'] == "change") {
    foreach ($_SESSION["shopping_cart"] as &$value) {
        if ($value['code'] === $_POST["code"]) {
            $value['quantity'] = $_POST["quantity"];
            break; //
        }
    }
}
?>
<html>
<head>
<title>Cos cumparaturi</title>
<link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
</head>
<body>
<div style="width:700px; margin:50 auto;">
<style>
body {
  background-image: url('poza_fundal.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: 100% 100%;
    }
</style>

<?php
if (!empty($_SESSION["shopping_cart"])) {
    $cart_count = count(array_keys($_SESSION["shopping_cart"]));
    ?>
<div class="cart_div">
<a href="cart.php">
<img src="carticon.png" /> Cart
<span><?php echo $cart_count; ?></span></a>
</div>
<?php
}
?>

<div class="cart">
<?php
if (isset($_SESSION["shopping_cart"])) {
    $total_price = 0;
    ?>
<table class="table" style="color: #F68B1E" >
<tbody>
<tr>
<td></td>
<td style="color: #F68B1E">ITEM NAME</td>
<td style="color: #F68B1E">QUANTITY</td>
<td style="color: #F68B1E">UNIT PRICE</td>
<td style="color: #F68B1E">ITEMS TOTAL</td>
</tr>
<?php

    foreach ($_SESSION["shopping_cart"] as $product) {
        ?>
<tr>
<td><img src='<?php echo $product["image"]; ?>' width="50" height="40"  ></td>
<td><?php echo $product["name"]; ?><br />
<form method='post' action=''>
<input style="color: #F68B1E" type='hidden' name='code' value="<?php echo $product["code"]; ?>" />
<input style="color: #F68B1E" type='hidden' name='action' value="remove" />
<button style="color:  #FF0000" type='submit' class='remove'>Renunta</button>
</form>
</td>
<td>
<form method='post' action=''>
<input style="color: #F68B1E" type='hidden' name='code' value="<?php echo $product["code"]; ?>" />
<input style="color: #F68B1E" type='hidden' name='action' value="change" />
<select style="color: #F68B1E" name='quantity' class='quantity' onChange="this.form.submit()">
<option disabled selected hidden<?php if ($product == 0) {
            echo "selectat";
        }
        ?> value="0"><?php echo $product["quantity"]; ?></option>
<option <?php if ($product == 1) {
            echo "selectat";
        }
        ?> value="1">1</option>
<option <?php if ($product == 2) {
            echo "selectat";
        }
        ?> value="2">2</option>
<option <?php if ($product == 3) {
            echo "selectat";
        }
        ?> value="3">3</option>
<option <?php if ($product == 4) {
            echo "selectat";
        }
        ?> value="4">4</option>
<option <?php if ($product == 5) {
            echo "selectat";
        }
        ?> value="5">5</option>
</select>
</form>
</td>
<td style="color: #F68B1E"><?php echo "$" . $product["price"]; ?></td>
<td style="color: #F68B1E"><?php echo "buc: " . $product["quantity"]; ?></td>
</tr>
<?php
$total_price += ($product["quantity"]*$product["price"]);
    }
    ?>
<tr>
<td colspan="5" align="right" style="color: #F68B1E">
<strong>TOTAL: <?php echo "$" . $total_price; ?></strong>
</td>
</tr>
</tbody>
</table>
  <?php
} else {
    echo "<h3>Cosul tau este gol!</h3>";
}
?>
<a href="magazin.php" style="color: #F68B1E">Home</a>
</div>

<div style="clear:both; color: #F68B1E;"></div>

<div class="message_box" style="margin:10px 0px; color: #F68B1E">
<?php echo $status; ?>
</div>


<br /><br />

</div>
</body>
</html>