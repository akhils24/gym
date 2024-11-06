<?php
$dbhost="localhost";
$dbuser="root";
$dbpass="";
$db="gym";
//Create Connection
$conn=mysqli_connect($dbhost,$dbuser,$dbpass,$db);
//Check Connection
if($conn->connect_error)
{
     die("connection Failed : ".$conn->connect_error);
}
// echo"Connected successfully";
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['input'])) {
  $name = mysqli_real_escape_string($conn, $_POST['input']);
  $sql=mysqli_query($conn,"SELECT * FROM category WHERE cat_name='$name'");
  if($sql->num_rows>0) {
    echo " already exists!";
  } else{
    $catqry=mysqli_query($conn,"INSERT INTO category(cat_name) VALUES('$name')");
    if ($catqry) {
      echo " added successfully!";
    } else {
      echo "Error: " . mysqli_error($conn);
    }
  }
  exit;
}
else{
  echo " Not Recieved";
}
?>
