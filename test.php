<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agbDB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "UPDATE products
        SET quantity = 10-5
        WHERE product_ID = 1";

    if ($conn->query($sql) === TRUE)
    echo "Record has been updated successfully";
	else
    echo "Error: " . $sql . "<br>" . $conn->error;
?>