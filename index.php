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
.headercontainer {
    background-color: #607196;
    height: 70px;
}
.headername a{
    float: right;
    margin-top: 10px;
    margin-right: 30px;
    font-size: 30px;
    color: black;
}
.logincontainer{
    margin: 0 auto;
    padding-top: 35px;
    border-radius: 25px;
    margin-top: 50px;
    text-align: center;
    width: 40%;
    height: 400px;
    background-color: #E8E9ED;
    box-shadow: 7px 7px 15px  rgba(0,0,0,0.4);
}
.title p1{
    font-size: 50px;
    font-weight: bold;
}
.title p2{
    font-size: 50px;
    color: #FF7B9C;
    font-weight: bold;
}
.title p3{
    font-size: 30px;
}
.ltc{
    margin-top: 10px;
}
.logindetails{
    margin-top: 35px;
}
.user {
    width: 60%;
    height: 60px;
    margin: 0 auto;
    border: auto;
    border-radius: 10px;
    border: none;
    padding-left: 10px;
    font-size: 20px;
}
.pass {
    width: 60%;
    height: 60px;
    margin: 0 auto;
    border: auto;
    border-radius: 10px;
    border: none;
    margin-top: 10px;
    padding-left: 10px;
    font-size: 20px;
}
.btn{
    background-color: #F13867;
    border: none;
    padding: 20px 100px;
    text-decoration: none;
    color: white;
    font-weight: bold;
    border-radius: 30px;
    margin-top: 50px;
    box-shadow: 7px 7px 15px  rgba(0,0,0,0.4);
    font-size: 25px;
}
.uspas{
    font-size: 20px;
    padding-top: 35px;
    border-radius: 25px;
    text-align: center;
}

</style>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div class="logincontainer">
        <div class="logindetails">
            <div class="userpass">
                <input class="user" type="text" name="uname" placeholder="Username" required/> <br>
                <input class="pass" type="password" name="pword" placeholder="Password" required/> <br>    
            </div>
            <div class="loginbtn">
                <input class="btn"type="submit" class= "loginbutton"value="Log-in" name="btn"/> <br>
            </div>
        </div>
    </div>
    </form>
    <?php
    
    if($_POST && isset($_POST['uname']) && isset($_POST['pword']))
    {
        $uname = $_POST['uname'];
        $pword = $_POST['pword'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "agbDB";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) 
            {
                die("Connection failed: " . $conn->connect_error);
            } 

        $sql = "SELECT username, password, role, full_name FROM accounts WHERE username='$uname' AND password='$pword'";

        $result = $conn->query($sql) or die ("Query error: " . $conn->error);

        if($result->num_rows > 0)
        {       
            while($row = $result->fetch_assoc()) 
            {
                if($row['role']=='Admin')
                {
                    $_SESSION["uname"] = "$uname";
                    echo "<script>location.href='Admin/products.php'</script>";
                }
                else
                {
                    $_SESSION["uname"] = "$uname";
                    echo "<script>location.href='Employee/employee.php'</script>";
                }
            }

        }
        else
        {
            echo "<div class='uspas'>";
            echo "<br>"."Username or Password doesn't exists";
            echo "</div>";
        }
    }
        
    ?>
</body>
</html>