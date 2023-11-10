<?php
// Product details (without a database, using arrays)
$products = array(
    array(
        'id' => 1,
        'name' => 'T-Shirt',
        'price' => 20.00,
        'description' => 'A simple and comfortable T-shirt.',
        'image' => 'tshirt.jpg' // Image file path
    ),
    array(
        'id' => 2,
        'name' => 'Jeans',
        'price' => 50.00,
        'description' => 'Classic denim jeans.',
        'image' => 'jeans.jpg' // Image file path
    ),
    array(
        'id' => 3,
        'name' => 'Sneakers',
        'price' => 40.00,
        'description' => 'Stylish and comfortable sneakers.',
        'image' => 'sneakers.jpg' // Image file path
    ),
    array(
        'id' => 4,
        'name' => 'Cotton Socks',
        'price' => 60.00,
        'description' => 'Elegant evening dress.',
        'image' => 'socks.jfif' // Image file path
    ),
    array(
        'id' => 5,
        'name' => 'Watch',
        'price' => 80.00,
        'description' => 'Stylish wristwatch.',
        'image' => 'watch.jfif' // Image file path
    ),
    array(
        'id' => 6,
        'name' => 'Leather Cross Body Bag',
        'price' => 45.00,
        'description' => 'Fashionable handbag.',
        'image' => 'leather.jpg' // Image file path
    ),
    array(
        'id' => 7,
        'name' => 'Nike Shoes',
        'price' => 55.00,
        'description' => 'Formal leather shoes.',
        'image' => 'nike.jpeg' // Image file path
    ),
    array(
        'id' => 8,
        'name' => 'Fedora Hat',
        'price' => 25.00,
        'description' => 'Casual sun hat.',
        'image' => 'fedora.jpg' // Image file path
    )
);

// Cart session
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Add a product to the cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    foreach ($products as $product) {
        if ($product['id'] == $product_id) {
            $_SESSION['cart'][] = $product;
            break;
        }
    }
}

// Delete a product from the cart
if (isset($_POST['delete_item'])) {
    $delete_id = $_POST['delete_id'];
    foreach ($_SESSION['cart'] as $key => $cartItem) {
        if ($cartItem['id'] == $delete_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Shopping</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
        }

        .products {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            list-style: none;
            padding: 0;
        }

        .product {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
            text-align: center;
            width: 250px;
        }

        .product img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .product form {
            margin-top: 10px;
        }

        .cart {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            padding: 20px;
        }

        .cart ul {
            padding: 0;
            list-style: none;
        }

        .cart li {
            border-bottom: 1px solid #ccc;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart li img {
            max-width: 50px;
            height: auto;
            border-radius: 4px;
        }

        select {
            padding: 5px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 5px 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Products</h1>

    <form method="get" action="">
        <input type="text" name="search" placeholder="Search...">
        <input type="submit" value="Search">
    </form>

    <select onchange="location = this.value;">
        <option value="">Select an item</option>
        <?php foreach ($products as $product) { ?>
            <option value="#<?php echo $product['id']; ?>"><?php echo $product['name']; ?></option>
        <?php } ?>
    </select>

    <ul class="products">
        <?php
        foreach ($products as $product) {
            // Search filter
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search = strtolower($_GET['search']);
                if (strpos(strtolower($product['name']), $search) === false) {
                    continue;
                }
            }
        ?>
            <li class="product" id="<?php echo $product['id']; ?>">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h3><?php echo $product['name']; ?></h3>
                <p>$<?php echo $product['price']; ?></p>
                <p><?php echo $product['description']; ?></p>
                <form method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="submit" name="add_to_cart" value="Add to Cart">
                </form>
            </li>
        <?php } ?>
    </ul>

    <div class="cart">
        <h2>Shopping Cart</h2>
        <?php if (!empty($_SESSION['cart'])) { ?>
            <ul>
                <?php foreach ($_SESSION['cart'] as $cartItem) { ?>
                    <li>
                        <img src="<?php echo $cartItem['image']; ?>" alt="<?php echo $cartItem['name']; ?>" width="50">
                        <strong><?php echo $cartItem['name']; ?></strong> - 
                        $<?php echo $cartItem['price']; ?>
                        <form method="post">
                            <input type="hidden" name="delete_id" value="<?php echo $cartItem['id']; ?>">
                            <input type="submit" name="delete_item" value="Delete">
                        </form>
                    </li>
                <?php } ?>
            </ul>
        <?php } else {
            echo "Your cart is empty.";
        } ?>
    </div>
</div>

</body>
</html>
