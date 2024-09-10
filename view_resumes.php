<?php
session_start();
include 'includes/db_connection.php'; // Include your database connection file

// Redirect if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$resumes = [];

// Fetch user resumes from the database
$stmt = $conn->prepare("SELECT id, name, email, phone, profile_picture, bio, skills, education, experience, hobbies FROM resumes WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $resumes[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Resumes - Resume Builder</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


        <style>
            p{
                margin-right: 160px;
                
            }
        </style>
      


</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Your Resumes</h2>

                <?php if (empty($resumes)): ?>
                    <div class="alert alert-info">
                        You have not created any resumes yet.
                    </div>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach ($resumes as $resume): ?>
                            <div class="list-group-item">
                                <h4 class="mb-1"><?php echo htmlspecialchars($resume['name']); ?></h4>
                                <p class="mb-1"><strong>Email:</strong> <?php echo htmlspecialchars($resume['email']); ?></p>
                                <p class="mb-1"><strong>Phone:</strong> <?php echo htmlspecialchars($resume['phone']); ?></p>
                                <?php if (!empty($resume['profile_picture'])): ?>
                                    <img src="<?php echo htmlspecialchars($resume['profile_picture']); ?>" alt="Profile Picture" class="img-thumbnail mb-4 position-absolute top-0 end-0 " style="max-width: 150px; hieght:auto; margin: 10px;">
                                <?php endif; ?>
                                <p class="mb-1"><strong>Bio:</strong> <?php echo htmlspecialchars($resume['bio']); ?></p>
                                <p class="mb-1"><strong>Skills:</strong> <?php echo implode(', ', json_decode($resume['skills'])); ?></p>
                                <p class="mb-1"><strong>Education:</strong> <?php echo implode(', ', json_decode($resume['education'])); ?></p>
                                <p class="mb-1"><strong>Experience:</strong> <?php echo implode(', ', json_decode($resume['experience'])); ?></p>
                                <p class="mb-1"><strong>Hobbies:</strong> <?php echo htmlspecialchars($resume['hobbies']); ?></p>
                                <a href="download_resume.php?id=<?php echo $resume['id']; ?>" class="btn btn-primary btn-sm">Download PDF</a>
                                <a href="delete_resume.php?id=<?php echo $resume['id']; ?>" class="btn btn-primary btn-sm" onclick="return confirm('Are you sure you want to delete this resume?');">Delete Resume</a>

                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
