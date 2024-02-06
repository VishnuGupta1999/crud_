<?php
    $conn = new mysqli("localhost", "root", "", "crud");
    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM std_profile WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
    }

    if(isset($_POST['submit'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $emailid = $_POST['emailid'];
        $languages = implode(", ", $_POST['languages']); // Convert array to string
        $gender = $_POST['gender'];
        
        // File upload handling
        $filename = $_FILES["image"]["name"];
        $tempname = $_FILES["image"]["tmp_name"];
        $folder = "images/".$filename;
        move_uploaded_file($tempname, $folder);

        // Update the record in the database
        $sql = "UPDATE std_profile SET name='$name', description='$description', emailid='$emailid', languages='$languages', gender='$gender', image='$folder' WHERE id=$id";
        
        if($conn->query($sql) === TRUE){
            echo "Record updated successfully";
             header("Location: listing_form.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
    $conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Form</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?php echo $row['name']; ?>"><br> 
        <label>Description:</label><br>
        <input type="text" name="description" value="<?php echo $row['description']; ?>"><br>
        <label>Email:</label><br>
        <input type="text" name="emailid" value="<?php echo $row['emailid']; ?>"><br>
        <label>Languages:</label><br>
        <input type="checkbox" name="languages[]" value="english" <?php if(in_array('english', explode(', ', $row['Languages']))) echo 'checked'; ?>> English<br>
        <input type="checkbox" name="languages[]" value="hindi" <?php if(in_array('hindi', explode(', ', $row['Languages']))) echo 'checked'; ?>> Hindi<br>
        <input type="checkbox" name="languages[]" value="marathi" <?php if(in_array('marathi', explode(', ', $row['Languages']))) echo 'checked'; ?>> Marathi<br>
        <label>Gender:</label><br>
        <input type="radio" name="gender" value="female" <?php if($row['gender'] == 'female') echo 'checked'; ?>>Female
        <input type="radio" name="gender" value="male" <?php if($row['gender'] == 'male') echo 'checked'; ?>>Male
        <input type="radio" name="gender" value="other" <?php if($row['gender'] == 'other') echo 'checked'; ?>>Other<br>
        <label>Image:</label><br> 
        <img src="<?php echo $row['image']; ?>" width="100" height="100"><br>
        <input type="file" name="image"><br>
        <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>
