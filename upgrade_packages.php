<?php
session_start();
include 'includes/db_connection.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$upgrade_success = false;
$error_message = "";

// Handle package upgrade
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_package = $_POST['package'];

    // Update the user's package type in the database
    $stmt = $conn->prepare("UPDATE users SET package_type = ? WHERE id = ?");
    $stmt->bind_param("si", $selected_package, $user_id);

    if ($stmt->execute()) {
        $upgrade_success = true;
    } else {
        $error_message = "Error upgrading package: " . $stmt->error;
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
        <?php if ($upgrade_success): ?>
            <div class="alert alert-success" role="alert">
                Your package has been upgraded successfully!
            </div>
            <a href="create_resume.php" class="btn btn-primary">Create More Resumes</a>
        <?php else: ?>
            <form method="post" action="upgrade_packages.php">
                <?php if ($error_message): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="package" class="form-label">Select Package</label>
                    <select class="form-select" id="package" name="package" required>
                        <option value="premium">Premium - Unlimited Resumes</option>
                        <!-- Add more packages as needed -->
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Upgrade Package</button>
            </form>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
