<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Resume Builder</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center mb-4">
                <h1>Welcome to Resume Builder</h1>
                <p class="lead">Create and manage your professional resumes effortlessly.</p>
                <p class="lead">Make the first step towards your dream job with a resume that gets you noticed.</p>
                
                <div class="d-grid gap-2 d-md-block">
                    <a href="register.php" class="btn btn-success btn-lg">Register</a>
                    <a href="login.php" class="btn btn-primary btn-lg">Login</a>
                    <a href="create_resume.php" class="btn btn-secondary btn-lg">Create New Resume</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
if (isset($_GET['message']) && $_GET['message'] == 'resume_deleted') {
    echo '<div class="alert alert-success">Resume deleted successfully.</div>';
}
?>
