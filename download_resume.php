<?php
session_start();
include 'includes/db_connection.php'; // Include your database connection file
require('fpdf/fpdf.php'); // Include FPDF library

// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Resume ID is required.");
}

$resume_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Fetch resume data from the database
$stmt = $conn->prepare("SELECT * FROM resumes WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $resume_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Resume not found or you do not have permission to download this resume.");
}

$resume = $result->fetch_assoc();
$stmt->close();
$conn->close();

// Create a new PDF document
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Add Profile Picture (Assuming 'profile_picture' column stores the path)
if (!empty($resume['profile_picture']) && file_exists($resume['profile_picture'])) {
    $pdf->Image($resume['profile_picture'], 170, 10, 30, 30); // X, Y, Width, Height
    $pdf->Ln(10); // Move the cursor down after the image
} else {
    $pdf->Cell(40, 10, 'No Profile Picture');
    $pdf->Ln(10);
}

// Add Name
$pdf->Cell(40, 10, 'Name: ' . $resume['name']);
$pdf->Ln(10);

// Add Email
$pdf->Cell(40, 10, 'Email: ' . $resume['email']);
$pdf->Ln(10);

// Add Phone
$pdf->Cell(40, 10, 'Phone: ' . $resume['phone']);
$pdf->Ln(10);

// Add Bio
$pdf->Cell(40, 10, 'Bio:');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, $resume['bio']);
$pdf->Ln(10);

// Add Skills
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Skills:');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$skills = json_decode($resume['skills'], true);
if (is_array($skills)) {
    foreach ($skills as $skill) {
        $pdf->Cell(0, 10, '- ' . $skill);
        $pdf->Ln(10);
    }
}

// Add Education
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Education:');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$education = json_decode($resume['education'], true);
if (is_array($education)) {
    foreach ($education as $edu) {
        $pdf->Cell(0, 10, '- ' . $edu);
        $pdf->Ln(10);
    }
}

// Add Experience
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Experience:');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$experience = json_decode($resume['experience'], true);
if (is_array($experience)) {
    foreach ($experience as $exp) {
        $pdf->Cell(0, 10, '- ' . $exp);
        $pdf->Ln(10);
    }
}

// Add Hobbies
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Hobbies:');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, $resume['hobbies']);

// Output the PDF as a download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="resume_' . $resume_id . '.pdf"');
$pdf->Output('D', 'resume_' . $resume_id . '.pdf');
exit; // Ensure the script ends here
?>
