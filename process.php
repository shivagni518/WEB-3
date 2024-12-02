<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture and sanitize input fields
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $dob = htmlspecialchars($_POST['dob']);
    $address = htmlspecialchars($_POST['address']);
    $course = htmlspecialchars($_POST['course']);
    $grade = htmlspecialchars($_POST['grade']);

    // Directories for uploads
    $uploadDir = 'uploads/';
    $essayDir = $uploadDir . 'essays/';
    $docsDir = $uploadDir . 'documents/';
    
    // Create directories if not exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    if (!is_dir($essayDir)) {
        mkdir($essayDir, 0777, true);
    }
    if (!is_dir($docsDir)) {
        mkdir($docsDir, 0777, true);
    }

    // Handle essay upload
    if (isset($_FILES['essay']) && $_FILES['essay']['error'] === UPLOAD_ERR_OK) {
        $essayTmpPath = $_FILES['essay']['tmp_name'];
        $essayFileName = basename($_FILES['essay']['name']);
        $essayDestPath = $essayDir . $essayFileName;

        if (!move_uploaded_file($essayTmpPath, $essayDestPath)) {
            echo "<p style='color: red;'>Failed to upload essay. Please try again.</p>";
            exit;
        }
    } else {
        echo "<p style='color: red;'>Essay upload error. Please try again.</p>";
        exit;
    }

    // Handle supporting documents upload
    $uploadedDocs = [];
    if (isset($_FILES['docs']) && is_array($_FILES['docs']['name'])) {
        foreach ($_FILES['docs']['name'] as $index => $fileName) {
            if ($_FILES['docs']['error'][$index] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['docs']['tmp_name'][$index];
                $fileDestPath = $docsDir . basename($fileName);

                if (move_uploaded_file($fileTmpPath, $fileDestPath)) {
                    $uploadedDocs[] = $fileDestPath;
                } else {
                    echo "<p style='color: red;'>Failed to upload document: $fileName. Please try again.</p>";
                    exit;
                }
            }
        }
    } else {
        echo "<p style='color: red;'>Document upload error. Please try again.</p>";
        exit;
    }

    // Display the submission details
    echo "<h2>Scholarship Application Submitted Successfully!</h2>";
    echo "<p><strong>Name:</strong> $name</p>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p><strong>Phone:</strong> $phone</p>";
    echo "<p><strong>Date of Birth:</strong> $dob</p>";
    echo "<p><strong>Address:</strong> $address</p>";
    echo "<p><strong>Intended Course of Study:</strong> $course</p>";
    echo "<p><strong>Recent Academic Qualification:</strong> $grade</p>";
    echo "<p><strong>Essay Uploaded:</strong> <a href='$essayDestPath' target='_blank'>View Essay</a></p>";

    if (!empty($uploadedDocs)) {
        echo "<p><strong>Supporting Documents:</strong></p><ul>";
        foreach ($uploadedDocs as $doc) {
            echo "<li><a href='$doc' target='_blank'>" . basename($doc) . "</a></li>";
        }
        echo "</ul>";
    }
} else {
    echo "<p style='color: red;'>Invalid request. Please submit the form correctly.</p>";
}
?>
