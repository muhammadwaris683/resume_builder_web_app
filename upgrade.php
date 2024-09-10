<?php
session_start();
include 'includes/db_connection.php'; // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch the current package type for the user
$stmt = $conn->prepare("SELECT package_type FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($current_package);
$stmt->fetch();
$stmt->close();

// If the form is submitted, update the user's package
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_package = $_POST['package_type'];

    // Update the package in the database
    $stmt = $conn->prepare("UPDATE users SET package_type = ? WHERE id = ?");
    $stmt->bind_param("si", $new_package, $user_id);

    if ($stmt->execute()) {
        header("Location: index.php?message=package_upgraded");
        exit;
    } else {
        echo "Error upgrading package: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upgrade Package</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Upgrade Your Package</h2>
        <p>Your current package: <strong><?php echo ucfirst($current_package); ?></strong></p>
        <form method="post" action="upgrade_packages.php">
            <div class="mb-3">
                <label for="package_type" class="form-label">Choose a new package:</label>
                <select id="package_type" name="package_type" class="form-select" required>
                    <option value="premium" <?php if ($current_package == 'premium') echo 'selected'; ?>>Premium Package</option>
                    <option value="basic" <?php if ($current_package == 'basic') echo 'selected'; ?>>Basic Package</option>
                    <!-- Add more packages if needed -->
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Upgrade</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
