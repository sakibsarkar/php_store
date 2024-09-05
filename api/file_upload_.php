<?php
if (isset($_POST['submit'])) {
    // Check if a file was uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file = $_FILES['file'];

        // File details
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        // Specify allowed file types (e.g., only images)
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExt, $allowedTypes)) {
            // Specify the directory to upload files
            $uploadDirectory = 'uploads/';
            $uploadPath = $uploadDirectory . basename($fileName);

            // Move the uploaded file to the target directory
            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                echo "File uploaded successfully!";
            } else {
                echo "Error moving the uploaded file.";
            }
        } else {
            echo "Invalid file type. Allowed types: " . implode(', ', $allowedTypes);
        }
    } else {
        echo "No file uploaded or there was an error.";
    }
}
?>
