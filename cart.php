<?php
session_start();

// Check if the cart exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty.";
    exit();
}

// Function to get product details from the database
function getProductDetails($product_id) {
    $conn = new mysqli("localhost", "root", "", "e_commerce");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT name, price FROM products WHERE _id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $product_id);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    $stmt->bind_result($name, $price);
    if (!$stmt->fetch()) {
        // Add debug information
        error_log("Fetch failed: No data found for product_id $product_id");
        return ['name' => 'Unknown', 'price' => 0];
    }

    $stmt->close();
    $conn->close();

    return ['name' => $name, 'price' => $price];
}

$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file here -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <style>
        #modal{
            display:flex;
            justify-content:center;
            align-items:center;
            width:100%;
            height:100vh;
            position:fixed;
            top:0;
            left:0;
            background:rgba(0,0,0,0.5)
        }
    </style>

</head>
<body><script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <?php require "components/navbar.php" ?>
    <h1>Your Cart</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['cart'] as $_id => $quantity): ?>
                <?php
                $product = getProductDetails($_id);
                $product_name = htmlspecialchars($product['name']);
                $product_price = $product['price'];
                $total_item_price = $product_price * $quantity;
                $total_price += $total_item_price;
                ?>
                <tr>
                    <td><?php echo $product_name; ?></td>
                    <td><?php echo number_format($product_price, 2); ?></td>
                    <td><?php echo htmlspecialchars($quantity); ?></td>
                    <td><?php echo number_format($total_item_price, 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>Total Price:</strong></td>
                <td><strong><?php echo number_format($total_price, 2); ?></strong></td>
            </tr>
        </tfoot>
    </table>

    
    <button class="btn btn-primary" onclick="handleOpenModal()"> make order</button>

    <a href="products.php">Continue Shopping</a>
    <script>

const modal =`    <div id="modal">
    <form action="api/process_order.php" method="post">
        <p>Address</p>
        <textarea name="address" required></textarea>
        <input type="hidden" name="cart_data" value='<?php echo json_encode($_SESSION['cart']); ?>'>
        <button type="button" onclick="closeModal()" class="btn btn-danger">Cancel Order</button>
        <button type="submit" class="btn btn-primary">Make Order</button>
    </form>
</div>

`

const closeModal =()=>{
    document.getElementById("modal").remove()
}

const handleOpenModal = ()=>{
    document.body.innerHTML+=modal
}
    </script>
</body>
</html>
