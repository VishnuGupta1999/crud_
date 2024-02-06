<?php 
    $conn = new mysqli("localhost", "root", "", "crud");
    if ($conn->connect_error){
        die("connection failed:" . $conn->connect_error);
    }
    $query = "SELECT * FROM std_profile" ;
    $result = mysqli_query($conn,$query);
    if (isset($_GET['id'])) {
        $sql = "DELETE FROM std_profile WHERE id=".$_GET['id'];
         if ($conn->query($sql) === TRUE) {
          echo "Record deleted successfully";
          header("Location: listing_form.php");
        } else {
          echo "Error deleting record: " . $conn->error;
        }
    }
    $conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <style type="text/css">
        .container {
            position: relative;
        }
        .add-button {
            position: ;
            top: 0;
            right: 0;
            margin-top: 0px; /* Adjust this value based on your button size */
            text-align: right;
        }
        table {
            margin: 0 auto; /* This centers the table horizontally */
            text-align: center; /* This centers the content within cells */
            border: 1px solid black;
            border-collapse: collapse;
            height: 100px;
            width: 1000px;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="login_form.php"  class="add-button">Add New Record</a><br><br>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Email</th>
                <th>Languages</th>
                <th>Gender</th>
                <th>Image</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php 
                while ($row = mysqli_fetch_assoc($result)) { 
            ?>
            <tr>
                <td><?php echo $row['id'];?></td>
                <td><?php echo $row['name'];?></td> 
                <td><?php echo $row['description'];?></td> 
                <td><?php echo $row['emailid'];?></td> 
                <td><?php echo $row['Languages'];?></td> <!-- Update this line -->
                <td><?php echo $row['gender'];?></td> 
                <td><img src='<?php echo $row['image'];?>' height='100px' width='100px'></td> 
                <td><a href="edit_form.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a></td>
                <td><a href="listing_form.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a></td>
             </tr>           
            <?php       
                }
            ?>
        </table>
    </div>
</body>
</html>
