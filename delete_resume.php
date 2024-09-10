<?php
session_start();
include 'includes/db_connection.php'; // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if the resume ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Resume ID is required.";
    exit;
}

$resume_id = intval($_GET['id']);

// Verify that the resume belongs to the logged-in user
$stmt = $conn->prepare("SELECT id FROM resumes WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $resume_id, $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    echo "Invalid resume ID or you do not have permission to delete this resume.";
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// Confirm deletion
if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'Yes') {
    // Delete the resume
    $stmt = $conn->prepare("DELETE FROM resumes WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $resume_id, $user_id);

    if ($stmt->execute()) {
        // Decrement the resume count in the users table
        $stmt = $conn->prepare("UPDATE users SET resume_count = resume_count - 1 WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        // Redirect to the homepage or resume list page with a success message
        header("Location: view_resumes.php?message=resume_deleted");
        exit;
    } else {
        echo "Error deleting resume.";
    }
    $stmt->close();
} else {
    // Show a confirmation form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Confirm Deletion</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5">
            <h2>Are you sure you want to delete this resume?</h2>
            <form method="post" action="">
                <button type="submit" name="confirm_delete" value="Yes" class="btn btn-danger">Yes, delete it</button>
                <a href="view_resumes.php" class="btn btn-secondary">No, go back</a>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
}
$conn->close();
?>
