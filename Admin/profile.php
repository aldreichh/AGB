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
        <div class="formContainer">
            <div class="Form">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input class="oldpass" type="password" name="oldpass" placeholder="Old Password" required/> <br>

                <input class="password" type="password" name="pword" placeholder="New Password" required/> <br>    

                <input class="confirmpassword" type="password" name="confirmpword" placeholder="Confirm Password" required/> <br>   
            </div>

            <div class="confirmbutton">
                <input class="confirmbtn"type="submit" value="Confirm" name="btn"/> <br>
            </div>
            </form>
        </div>
    </div>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agbdb";

    if(isset($_POST['oldpass']) && isset($_POST['pword']) && isset($_POST['confirmpword']))
    {
        $conn = new mysqli($servername, $username, $password, $dbname);

        $oldpass = $_POST['oldpass'];
        $pword = $_POST['pword'];
        $confirm = $_POST['confirmpword'];

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "SELECT username, password FROM accounts WHERE role = 'admin'";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc())
        {
            $fetchpass = $row['password'];
        }

        if ($oldpass == $fetchpass) 
        {
            if($pword == $confirm){
                $sql = "
                UPDATE accounts 
                SET password = '$pword' 
                WHERE role = 'admin'";

                if ($conn->query($sql) === TRUE)
                {   
                    echo "Password has been successfully changed";
                }
                else
                    echo "Error: " . $sql . "<br>" . $conn->error;

                // Close the database connection

            }
            else
            {
                echo "<div class='uspas2'>";
                echo "<br>"."Password doesn't match";
                echo "</div>";
            }
            
        } 
        else
        {
            echo "<div class='uspas'>";
            echo "<br>"."Incorrect Old Password";
            echo "</div>";
        }
    }
    ?>
</body>
</html>