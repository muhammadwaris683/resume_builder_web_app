<?php
session_start();
include 'includes/db_connection.php'; // Include your database connection file

// Redirect if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$errors = [];
$success = false;

$stmt = $conn->prepare("SELECT resume_count, package_type FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($resume_count, $package_type);
$stmt->fetch();
$stmt->close();



// Enforce the resume creation limit for the basic package
if ($package_type == 'basic' && $resume_count >= 3) {
    header("Location: upgrade_packages.php?message=limit_reached");
    exit;
}

if ($package_type == 'basic' && $resume_count >= 3) {
    $upgrade_message = "You have reached the limit of 3 resumes. Please upgrade your package to create more resumes.";
} else {
    $upgrade_message = "";
}




if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($upgrade_message)) {
    // Gather form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $bio = trim($_POST['bio']);
    $skills = $_POST['skills'];
    $education = $_POST['education'];
    $experience = $_POST['experience'];
    $hobbies = trim($_POST['hobbies']);
    
    // File upload
    $profile_picture_path = '';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $upload_ok = 1;
        
        // Check if the file is an actual image
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check === false) {
            $errors[] = "File is not an image.";
            $upload_ok = 0;
        }

        // Check file size
        if ($_FILES["profile_picture"]["size"] > 500000) {
            $errors[] = "Sorry, your file is too large.";
            $upload_ok = 0;
        }

        // Allow certain file formats
        if (!in_array($image_file_type, ["jpg", "jpeg", "png", "gif"])) {
            $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $upload_ok = 0;
        }

        // Check if $upload_ok is set to 0 by an error
        if ($upload_ok == 0) {
            $errors[] = "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $profile_picture_path = $target_file;
            } else {
                $errors[] = "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Validate form data
    if (empty($name) || empty($email) || empty($phone)) {
        $errors[] = "Name, email, and phone are required.";
    }

    if (empty($errors)) {
        // Convert the skills array to a JSON string
        $skills_json = json_encode($skills);

        // Insert resume data into the database
        $stmt = $conn->prepare("INSERT INTO resumes (user_id, name, email, phone, profile_picture, bio, skills, education, experience, hobbies) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === false) {
            $errors[] = "Error preparing statement: " . $conn->error;
        } else {

            $skills_json = json_encode($skills);
            $education_json = json_encode($education);
            $experience_json = json_encode($experience);
        
            $stmt->bind_param("isssssssss", $user_id, $name, $email, $phone, $profile_picture_path, $bio, $skills_json, $education_json, $experience_json, $hobbies);

            if ($stmt->execute()) {
                $success = true;
                $stmt = $conn->prepare("UPDATE users SET resume_count = resume_count + 1 WHERE id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $stmt->close();
        
                // Redirect to the resume viewing page
                header("Location: view_resumes.php?message=resume_created");
                exit;
            } else {
                $errors[] = "Failed to create resume: " . $stmt->error;
            }

        
    } 
            $stmt->close();
        }
    }

    




$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Resume - Resume Builder</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="text-center">Create New Resume</h2>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        Resume created successfully!
                    </div>
                <?php endif; ?>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="create_resume.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" id="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Profile Picture</label>
                        <input type="file" name="profile_picture" class="form-control" id="profile_picture">
                    </div>
                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea name="bio" class="form-control" id="bio" rows="4"><?php echo htmlspecialchars($_POST['bio'] ?? ''); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="skills" class="form-label">Skills</label>
                        <div id="skills-container">
                            <input type="text" name="skills[]" class="form-control mb-2" placeholder="Enter a skill">
                        </div>
                        <button type="button" class="btn btn-secondary mt-2" onclick="addSkill()">Add Another Skill</button>
                    </div>
                    <div class="mb-3">
                        <label for="education" class="form-label">Education</label>
                        <div id="education-container">
                            <input type="text" name="education[]" class="form-control mb-2" placeholder="Enter education detail">
                        </div>
                        <button type="button" class="btn btn-secondary mt-2" onclick="addEducation()">Add Another Education</button>
                    </div>
                    <div class="mb-3">
                        <label for="experience" class="form-label">Experience</label>
                        <div id="experience-container">
                            <input type="text" name="experience[]" class="form-control mb-2" placeholder="Enter experience detail">
                        </div>
                        <button type="button" class="btn btn-secondary mt-2" onclick="addExperience()">Add Another Experience</button>
                    </div>
                    <div class="mb-3">
                        <label for="hobbies" class="form-label">Hobbies</label>
                        <input type="text" name="hobbies" class="form-control" id="hobbies" value="<?php echo htmlspecialchars($_POST['hobbies'] ?? ''); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Create Resume</button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function addSkill() {
            const container = document.getElementById('skills-container');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'skills[]';
            input.className = 'form-control mb-2';
            input.placeholder = 'Enter a skill';
            container.appendChild(input);
        }

        function addEducation() {
            const container = document.getElementById('education-container');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'education[]';
            input.className = 'form-control mb-2';
            input.placeholder = 'Enter education detail';
            container.appendChild(input);
        }

        function addExperience() {
            const container = document.getElementById('experience-container');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'experience[]';
            input.className = 'form-control mb-2';
            input.placeholder = 'Enter experience detail';
            container.appendChild(input);
        }
    </script>
</body>
</html>

