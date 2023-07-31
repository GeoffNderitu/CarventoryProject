<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  
  // Database connection details
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "CarNation";

  // Create a new PDO instance
  $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  
  // Prepare the SQL statement
  $stmt = $pdo->prepare("INSERT INTO cars (brand, make, model, image, image2, image3, image4, specs, created_at)
                        VALUES (:brand, :make, :model, :image, :image2, :image3, :image4, :specs, NOW())");
  
  // Bind the form data to the prepared statement
  $stmt->bindParam(":brand", $_POST["brand"]);
  $stmt->bindParam(":make", $_POST["make"]);
  $stmt->bindParam(":model", $_POST["model"]);
  $stmt->bindParam(":image", $_FILES["image"]["name"]);
  $stmt->bindParam(":image2", $_FILES["image2"]["name"]);
  $stmt->bindParam(":image3", $_FILES["image3"]["name"]);
  $stmt->bindParam(":image4", $_FILES["image4"]["name"]);
  $stmt->bindParam(":specs", $_POST["specs"]);


  // Execute the prepared statement
  $stmt->execute();

  // Move the uploaded images to a desired directory
  $uploadDirectory = "../resources/images/";
  move_uploaded_file($_FILES["image"]["tmp_name"], $uploadDirectory . $_FILES["image"]["name"]);
  move_uploaded_file($_FILES["image2"]["tmp_name"], $uploadDirectory . $_FILES["image2"]["name"]);
  move_uploaded_file($_FILES["image3"]["tmp_name"], $uploadDirectory . $_FILES["image3"]["name"]);
  move_uploaded_file($_FILES["image4"]["tmp_name"], $uploadDirectory . $_FILES["image4"]["name"]);

  // Redirect to a success page
  header("Location: admin_dash.php");
  exit();
}
   
?>
