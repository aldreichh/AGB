<?php
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AppName</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300&display=swap" rel="stylesheet">
</head>

<style>
    * {box-sizing: border-box; }
body {
    font-family: 'Poppins', sans-serif;
    margin: 0 auto;
}
.navcontainer{
    background-color: skyblue;
    width: 30%;
    text-align: center;
    float: left;
    height: 1080px;
}
.contents{
    background-color: lightpink;
    width: 70%;
    text-align: center;
    float: right;
    height: 1080px;
}
.tablecontainer{
    margin: 0 auto;
    margin-top: 50px;
    text-align: center;
}
table, th, td{
    border: 1px solid;
    padding: 10px;
    width: 60%
}
table{
    border-collapse: collapse;
}

</style>

<body>
    <div class="navcontainer">
        <div class="profile">
            image <br>
            <a>Admin</a>
        </div>
        <div class="productsbtn">
            <a href="products.php"><button class="btn1">Products</button></a><br>
        </div>
        <div class="historybtn">
            <a href="history.php"><button class="btn2">History</button></a><br>
        </div>
        <div class="addbtn">
            <a href="users.php"><button class="btn3">Add User</button></a> <br>
        </div>
        <div class="profilebtn">
            <a href="profile.php"><button class="btn4">Profile</button></a><br>
        </div>
        <div class="logoutbtn">
            <a href="../index.php"><button class="btn5">Log Out</button></a> <br>
        </div>
    </div>

    <div class="contents">
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agbDB";
    $length = 0;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "SELECT product_ID, date, product_name, quantity, unit_price, available_balance FROM products ORDER BY product_ID"; 

    $result = $conn->query($sql);
    $result2 = $conn->query($sql);
    $array = array();

    if ($result->num_rows > 0) 
    {
        echo "<table class='tablecontainer'>";
        echo "<tr>";
        echo "<th>Product ID</th>";
        echo "<th>Date</th>";
        echo "<th>Product Name</th>";
        echo "<th>Quantity</th>";
        echo "<th>Price</th>";
        echo "<th>Available Balance</th>";
        echo "</tr>";
        
        
        while($row = $result->fetch_assoc()) 
        {
            echo  "<tr>";
            echo "<td>";
            echo $row['product_ID'];
            echo "</td>";
            echo "<td>";
            echo $row['date'];
            echo "</td>";
            echo "<td>";
            echo $row['product_name'];
            echo "</td>";
            echo "<td>";
            echo $row['quantity'];
            echo "</td>";
            echo "<td>";
            echo $row['unit_price'];
            echo "</td>";
            echo "<td>";
            echo $row['available_balance'];
            echo "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        
        while($row2 = $result2->fetch_assoc()) 
        {
            $array[]=$row2['product_name'];
        }
        $length = count($array);
    }

    echo "<form method='post'>";
    echo "<select name='product' id='product' class='selection' required>";
    echo "<option value='' disabled selected hidden>";
    echo 'Select a Product';
   
    $array = array_unique($array);
    $length = count($array);

    if($length != 0)
    {
        foreach ($array as $value) 
        {
            echo "<option>";
            echo $value;
            echo "</option>";
        }
        echo "</option>";
    }
    else
    {
    }
    echo "<input class='quantity' type='text' name='quantity' placeholder='Quantity' required/>"; 
    echo "<br>";
    echo "<button class='sellbtn'>Sell</button>";
    echo "</form>";
    ?>

    <?php
    if(isset($_POST['product'])&&isset($_POST['quantity']))
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "agbDB";
        $product = $_POST['product'];
        $quantity = $_POST['quantity'];
        $totalquantity = 0;
        $arrayquantity = 0;

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);}

        $sql = "SELECT product_ID, date, product_name, quantity, unit_price, available_balance FROM products WHERE product_name='$product' ORDER BY product_ID"; 

        $result = $conn->query($sql);
        $result2 = $conn->query($sql);
        $result3 = $conn->query($sql);

        if ($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc()) 
            {
               $tempvalue = $row['quantity'];
               $arrayquantity += $tempvalue;
               $tempvalue = 0;
            }
        } 

        //if($quantity <= $arrayquantity)
        //{
            while($row2 = $result2->fetch_assoc())
            {
                $item[] = $row2;
            }
                foreach ($item as $value) 
                {
                    $datedata = $value['date'];
                    $quantitydata = $value['quantity'];
                    $pricedata = $value['unit_price'];
                    echo $quantity."<br>"."<br>";
                    $tempquantity = $quantity;
                    $quantity = $quantity - $value['quantity'];
                    $productID = $value['product_ID'];


                    if($quantity > 0) //positive
                    {
                        echo $productID."positive";


                        $sql = "INSERT INTO history (date_added, date_sold, product_name, quantity, price)
                        VALUES ('$datedata', CURRENT_TIMESTAMP , '$product', '$quantitydata', '$pricedata')";
                        if ($conn->query($sql) === TRUE)
                        {
                            echo "added to history"."<br>";
                        }

                        $sql2 = "DELETE FROM products
                        WHERE product_ID = $productID";
                        if ($conn->query($sql2) === TRUE)
                        {
                            echo "successful positive";
                        }

                    }

                    else if($quantity < 0) //negative
                    {
                        echo $productID."negative"."<br>";
                        $price = $value['unit_price'];
                        echo $price;
                        $quantity = abs($quantity);

                        $sql = "INSERT INTO history (date_added, date_sold, product_name, quantity, price)
                        VALUES ('$datedata', CURRENT_TIMESTAMP , '$product', '$tempquantity', '$pricedata')";
                        if ($conn->query($sql) === TRUE)
                        {
                            echo "added to history"."<br>";
                        }

                        $sql2 = "UPDATE products
                        SET quantity = $quantity,
                        available_balance = $quantity*$price
                        WHERE product_ID = $productID";
                        if ($conn->query($sql2) === TRUE)
                        {
                            echo "successful negative";
                        }


                        break;
                    }

                    else if($quantity == 0)
                    {
                        echo $productID."zero"."<br>";

                        $sql = "INSERT INTO history (date_added, date_sold, product_name, quantity, price)
                        VALUES ('$datedata', CURRENT_TIMESTAMP , '$product', '$tempquantity', '$pricedata')";
                        if ($conn->query($sql) === TRUE)
                        {
                            echo "added to history"."<br>";
                        }

                        $sql2 = "DELETE FROM products
                        WHERE product_ID = $productID";
                        if ($conn->query($sql2) === TRUE)
                        {
                            echo "successful zero";
                        }
                        break;
                    }
                }  
            
        //}  
        //else
        //{
            //echo "Insufficient stocks!"."<br>";
            //echo "Available stocks: ".$arrayquantity."<br>";
        //}
        
    } 

    ?>

        <a href="products.php"><button class="backbtn">Back</button></a><br>
    </div>
    
</body>
</html>