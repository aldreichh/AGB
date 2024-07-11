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
        $dbname = "agbdb";

        $conn = new mysqli($servername, $username, $password, $dbname);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "SELECT username, full_name FROM accounts WHERE role = 'Employee'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) 
        {
            echo "<table class='tablecontainer'>";
            echo "<tr>";
            echo "<th>Full Name</th>";
            echo "<th>Username</th>";
            echo "</tr>";
            
            
            while($row = $result->fetch_assoc()) 
            {
                echo "<tr>";
                echo "<td>";
                echo $row['full_name'];
                echo "</td>";
                echo "<td>";
                echo $row['username'];
                echo "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } 
        

        ?>
        <div class="buttonscontainer">
            <div class="profilebtn">
                <a href="deleteuser.php"><button class="btn1">Delete User</button></a><br>
            </div>
            <div class="adduserbtn">
                <a href="adduser.php"><button class="btn2">Add User</button></a><br>
            </div>
        </div>
    </div>

</body>
</html>