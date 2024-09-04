<?php
include "./config/db_conn.php";

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 1; 

$offset = ($page - 1) * $itemsPerPage;

$searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$countSql = "SELECT COUNT(*) as total FROM `$product_tbl` WHERE `name` LIKE '%$searchQuery%'";
$countResult = mysqli_query($conn, $countSql);
$totalRows = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRows / $itemsPerPage);

$sql = "SELECT * FROM `$product_tbl` WHERE `name` LIKE '%$searchQuery%' LIMIT $offset, $itemsPerPage";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Product List</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .product-container {
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }

        .product {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;  
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid #ddd;
            width: 400px;
        }


        .product h3 {
            margin: 0;
            font-size: 24px;
            color: #007BFF;
        }

        .product p {
            margin: 5px 0;
            color: #555;
        }

        .product-price {
            font-weight: bold;
            color: #28a745;
        }

        .product hr {
            margin: 20px 0;
            border: 0;
            border-top: 1px solid #ddd;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 10px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #007BFF;
        }
        .pagination a.active {
            background-color: #007BFF;
            color: white;
            border-color: #007BFF;
        }
        .pagination a.disabled {
            color: #ddd;
            pointer-events: none;
        }
    </style>
    <!-- Your existing CSS and JS includes -->
</head>
<body>
<?php require "components/navbar.php" ?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<h2>Product List</h2>

<form id="searchForm" method="GET">
    <input type="text" id="searchQuery" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($searchQuery); ?>" />
    <button type="submit">Search</button>
</form>

<div class="product-container">
    <?php
    if (mysqli_num_rows($result) > 0) {
        // Output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            echo "<div class='product'>";
            echo "<h3>" . $row["name"] . "</h3>";
            echo "<p>" . $row["description"] . "</p>";
            echo "<p class='product-price'>Price: $" . $row["price"] . "</p>";
            echo "<button onclick='deleteProduct(\"" . $row["_id"] . "\")'>Delete</button>";
            echo "</div>";
        }
    } else {
        echo "<p>No products found.</p>";
    }
    ?>
</div>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($searchQuery); ?>">Previous</a>
    <?php else: ?>
        <a class="disabled">Previous</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($searchQuery); ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($searchQuery); ?>">Next</a>
    <?php else: ?>
        <a class="disabled">Next</a>
    <?php endif; ?>
</div>

<script>
    function deleteProduct(productId) {
        if (confirm("Are you sure you want to delete this product?")) {
            fetch(`http://localhost:80/e_commerce/api/delete_product_.php?_id=${productId}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload(); 
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
</script>
</body>
</html>
