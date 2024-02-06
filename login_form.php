<!DOCTYPE html>
<html>
<head>
</head>
<body> 
    <form method="POST" enctype="multipart/form-data">
        <label>Name:</label><br>
        <input type="text" name="name"><br> 
        <label>Description:</label><br>
        <textarea name="description" rows="5" cols="40"></textarea><br>
        <label>Email:</label><br>
        <input type="text" name="emailid"><br>
        <label>Languages:</label><br>
        <input type="checkbox" name="languages[]" value="english"> English<br>
        <input type="checkbox" name="languages[]" value="hindi"> Hindi<br>
        <input type="checkbox" name="languages[]" value="marathi"> Marathi<br>
        <label>Gender:</label><br>
        <input type="radio" name="gender" value="female"> Female
        <input type="radio" name="gender" value="male"> Male
        <input type="radio" name="gender" value="other"> Other<br>
        <label>Image:</label><br> 
        <input type="file" name="image"><br><br>
        <input type="submit" name="submit">
    </form>
</body>
</html>

<?php 
    $conn = new mysqli("localhost", "root", "", "crud");
    if ($conn->connect_error){
        die("Connection failed:" . $conn->connect_error);
    }
    if(isset($_POST['submit'])){
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
        
        // Database insertion
        $sql = "INSERT INTO std_profile (name, description, emailid, languages, gender, image) 
                VALUES ('$name', '$description', '$emailid', '$languages', '$gender', '$folder')";
        
        if($conn->query($sql) === TRUE){
            echo "Record submitted successfully";
            header("Location: listing_form.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
?>
