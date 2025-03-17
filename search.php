<?php
// Database credentials
$host = "158.120.255.229";
$user = "vin_user";      
$pass = "Akylbek64!";  
$dbname = "vinsearch";  

// Connect to MySQL
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Handle form submission
$vin = "";
$result = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["vin"])) {
    $vin = $conn->real_escape_string($_POST["vin"]);
    $query = "SELECT * FROM vehicle_listings WHERE vin = '$vin'";
    $result = $conn->query($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>VIN Search</title>
</head>
<body>
    <h2>Search for a Vehicle by VIN</h2>
    <form action="" method="POST">
        VIN: <input type="text" name="vin" value="<?= htmlspecialchars($vin) ?>" required>
        <button type="submit">Search</button>
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($vin)): ?>
        <h3>Search Results:</h3>
        <?php if ($result && $result->num_rows > 0): ?>
            <table border="1">
                <tr><th>VIN</th><th>Year</th><th>Make</th><th>Model</th><th>Trim</th><th>Color</th><th>Mileage</th><th>Price</th><th>Description</th></tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['vin']) ?></td>
                        <td><?= htmlspecialchars($row['year']) ?></td>
                        <td><?= htmlspecialchars($row['make']) ?></td>
                        <td><?= htmlspecialchars($row['model']) ?></td>
                        <td><?= htmlspecialchars($row['trim']) ?></td>
                        <td><?= htmlspecialchars($row['color']) ?></td>
                        <td><?= htmlspecialchars($row['mileage']) ?></td>
                        <td>$<?= htmlspecialchars($row['price']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No results found for VIN: <?= htmlspecialchars($vin) ?></p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
