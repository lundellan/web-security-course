<?php
  function OpenCon()  {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "webshop";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    // echo "<script>alert('Connected to server successfully!');</script>";
  }
    
  function CloseCon($conn)  {
    $conn -> close();
  }
?>