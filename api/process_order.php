<?php
session_start();

// Check if cart data is received
if (!isset($_POST['cart_data']) || !isset($_POST['address'])) {
    header("Location: cart.php"); // Redirect to cart if no data
    exit();
}

$cart_data = json_decode($_POST['cart_data'], true);
$address = $_POST['address'];

if (empty($cart_data)) {
    header("Location: cart.php");
    exit();
}

// Function to save the order to the database
function saveOrder($cart_data, $address) {
    $conn = new mysqli("localhost", "root", "", "e_commerce");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id'];
    $order_date = date("Y-m-d H:i:s");

    // Start transaction
    $conn->begin_transaction();

    try {
        // Prepare the insert statement
        $stmt = $conn->prepare("INSERT INTO orders (user_id, order_date, product_id, quantity, price, address_loc) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        foreach ($cart_data as $product_id => $quantity) {
            $product = getProductDetails($product_id); // Reuse function to get product details
            $price = $product['price'];
            $stmt->bind_param("isidis", $user_id, $order_date, $product_id, $quantity, $price, $address);
            if (!$stmt->execute()) {
                throw new Exception("Order insertion failed: " . $stmt->error);
            }
        }
        $stmt->close();
        
        // Commit transaction
        $conn->commit();
        
        // Clear the cart
        unset($_SESSION['cart']);
        
        echo "Order placed successfully!";
    } catch (Exception $e) {
        // Rollback transaction
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
    
    $conn->close();
}

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

// Save the order
saveOrder($cart_data, $address);
?>
