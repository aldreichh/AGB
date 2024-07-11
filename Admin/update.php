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
            <a href="adduser.php"><button class="btn3">Add User</button></a> <br>
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

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "SELECT product_ID, date, product_name, quantity, unit_price, available_balance FROM products ORDER BY product_ID"; 

        $result = $conn->query($sql);
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
        } 

        $sql2 = "SELECT product_ID, date, product_name, quantity, unit_price, available_balance FROM products"; 

        $result2 = $conn->query($sql2);

        while($row2 = $result2->fetch_assoc()) 
        {
            $array[]=$row2['product_ID'];
        }
        $length = count($array);

        echo "<form method='post'>";
        echo "<select name='productid' id='subject' class='selection' required>";
        echo "<option value='' disabled selected hidden>";
        echo "Product ID";
        if($length != 0)
        {   
            for($i=0; $i<=$length-1;$i++)
            { 
                echo "<option>";
                echo $array[$i];
                echo "</option>";
            }
                echo "</option>";
        }
        echo "</select>";
        echo "<div class='deletebutton'>";
            echo "<input class='productname' type='text' name='productname' placeholder='Product Name' required/>"; 
            echo "<br>";
            echo "<input class='quantity' type='text' name='quantity' placeholder='Quantity' required/>"; 
            echo "<br>";
            echo "<input class='price' type='text' name='price' placeholder='Price' required/>"; 
            echo "<br>";
        echo "<input class='deletebtn' type='submit' value='Confirm' name='btn'/>";
        echo "<br>";
        echo "</div>"; 
        echo "</form>"; 



        if(isset($_POST['productid'])&&isset($_POST['productname'])&&isset($_POST['quantity'])&&isset($_POST['price'])&&isset($_POST['btn']))
        {
            $productid = $_POST["productid"];
            $productname = $_POST["productname"];
            $quantity = $_POST["quantity"];
            $price = $_POST["price"];

            $sql = "UPDATE products
                    SET product_name = '$productname',
                        quantity = '$quantity',
                        unit_price = '$price'
                    WHERE product_ID = $productid";

            if ($conn->query($sql) === TRUE)
                echo "<script>location.href='update.php'</script>";
            else
                echo "Error: " . $sql . "<br>" . $conn->error;


            echo $selected;
        }
        ?>
        <div class="logoutbtn">
            <a href="products.php"><button class="btn6">Back</button></a> <br>
        </div>

    </div>

</body>
</html>