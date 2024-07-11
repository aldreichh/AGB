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
    text-align: center;
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
        <div class="addcontainer">
            <div class="addcontainer2">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">  
                <div class="textfields">
                    <input class="name" type="text" name="full_name" placeholder="Full Name" required/> <br>
                    <input class="user" type="text" name="uname" placeholder="Username" required/> <br>
                    <input class="pass" type="password" name="pword" placeholder="Password" required/> <br>   
                    <input class="confirmpass" type="password" name="confirmpword" placeholder="Confirm Password" required/> <br> 
                </div>
                <div class="buttons">
                    <input type="submit" class="addbtn" value="Add" name="btn"/> <br>
                </div>           
                </form>
                <a href="users.php"><button class="btn6">Back</button></a><br>
            </div>
        </div>
    </div>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agbdb";

    if(isset($_POST['btn'])&&isset($_POST['full_name'])&&isset($_POST['uname'])&&isset($_POST['pword'])&&isset($_POST['confirmpword'])){

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if ($conn->connect_error) 
        {
            die("Connection failed: " . $conn->connect_error);
        } 
        $name = $_POST['full_name'];
        $uname = $_POST['uname']; 
        $pword = $_POST['pword']; 
        $confirmpword = $_POST['confirmpword'];

        if($pword == $confirmpword){
            $sql = "SELECT * FROM accounts WHERE username='$uname'";

            $result = $conn->query($sql) or die ("Query error: " . $conn->error);

            if($result->num_rows > 0)
            {       
                echo "Username already exists";            
            }
            else{
                $sql2 = "INSERT INTO accounts (username, password, role, full_name) VALUES ('$uname','$pword', 'Employee', '$name')";


                if ($conn->query($sql2) === TRUE){
                echo "<br>"."<br>"."New record has been successfully created"."<br>";
                    }
                else{
                    echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
            } 
        }
        else{
            echo "<div class='uspas'>";
            echo "Password doesn't match";
            echo "</div>";
        }
    }
    ?>


</body>
</html>