<!DOCTYPE html>
<html>
<body>

<h2>PHP File Upload</h2>

<form method="POST" enctype="multipart/form-data">
    Select File:
    <input type="file" name="myfile" required>
    <input type="submit" name="upload" value="Upload">
</form>

<?php
if (isset($_POST["upload"])) {

    if (isset($_FILES["myfile"]) &&
        $_FILES["myfile"]["error"] === UPLOAD_ERR_OK) {

        $filename = basename($_FILES["myfile"]["name"]);
        $target = "uploads/" . $filename;

        if (move_uploaded_file(
            $_FILES["myfile"]["tmp_name"], $target
        )) {
            echo "File uploaded successfully!";
        } else {
            echo "File upload failed.";
        }

    } else {
        echo "Please select a valid file.";
    }
}
?>

</body>
</html>