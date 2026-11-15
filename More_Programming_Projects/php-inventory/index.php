<?php
// Small inventory application using MySQLi and prepared statements.
$conn = new mysqli("localhost", "root", "", "inventory_demo");
if ($conn->connect_error) {
    die("Database connection failed: " . htmlspecialchars($conn->connect_error));
}
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";
    if ($action === "add") {
        $name = trim($_POST["name"] ?? "");
        $quantity = filter_input(INPUT_POST, "quantity", FILTER_VALIDATE_INT);
        $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT);

        if ($name !== "" && $quantity !== false && $quantity !== null && $quantity >= 0
            && $price !== false && $price !== null && $price >= 0) {
            $stmt = $conn->prepare("INSERT INTO products (name, quantity, price) VALUES (?, ?, ?)");
            $stmt->bind_param("sid", $name, $quantity, $price);
            $message = $stmt->execute() ? "Product added." : "Could not add product. Check that the name is unique.";
            $stmt->close();
        } else {
            $message = "Enter a product name, non-negative quantity and valid price.";
        }
    } elseif ($action === "delete") {
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        if ($id) {
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $message = $stmt->affected_rows ? "Product deleted." : "Product not found.";
            $stmt->close();
        }
    }
}
$products = $conn->query("SELECT id, name, quantity, price FROM products ORDER BY name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Simple Inventory Manager</title>
<style>
body{font-family:Arial,sans-serif;max-width:900px;margin:35px auto;padding:0 15px;color:#203047}
form.add{display:flex;flex-wrap:wrap;gap:8px;margin:20px 0}
input{padding:10px;min-width:130px}button{padding:10px;cursor:pointer}
table{width:100%;border-collapse:collapse;margin-top:20px}
th,td{border:1px solid #ccd4df;padding:10px;text-align:left}
</style>
</head>
<body>
<h1>Inventory Manager</h1>
<?php if ($message !== ""): ?><p><?= htmlspecialchars($message) ?></p><?php endif; ?>
<h2>Add product</h2>
<form class="add" method="post">
    <input type="hidden" name="action" value="add">
    <input name="name" placeholder="Product name" required>
    <input name="quantity" type="number" min="0" step="1" placeholder="Quantity" required>
    <input name="price" type="number" min="0" step="0.01" placeholder="Price" required>
    <button type="submit">Add product</button>
</form>
<h2>Stock list</h2>
<table>
<tr><th>Name</th><th>Quantity</th><th>Price</th><th>Action</th></tr>
<?php while ($product = $products->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($product["name"]) ?></td>
<td><?= (int)$product["quantity"] ?></td>
<td><?= number_format((float)$product["price"], 2) ?></td>
<td><form method="post" onsubmit="return confirm('Delete this product?')">
<input type="hidden" name="action" value="delete">
<input type="hidden" name="id" value="<?= (int)$product["id"] ?>">
<button type="submit">Delete</button></form></td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
<?php $conn->close(); ?>
