<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Printer Facilitator</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <h2>Printer Facilitator</h2>
        <form action="" method="post" style="border:1px solid #ccc">
            <p id=try class="login-status">Welcome!</p>
            <div class="imgcontainer">
                <img src="avatar.png" alt="Avatar" class="avatar">
            </div>
            <div class="container">
                <input type="text" placeholder="Enter Roll No" name="rno" required>
                <input type="password" placeholder="Enter Password" name="psw" required>
                <button type="submit" style="width:100%"name="login">Login</button>
                <a href="signup.php" class="signup-image-link">Sign Up</a>
            </div>
        </form>
    </body>
</html>
<?php
    include("database.php");
    if (isset($_REQUEST['login']))
    {
        $rno=str_replace(";","",str_replace("--","",str_replace("#","",$_POST['rno'])));
        $psw=$_POST['psw'];
        $hash=hash('sha256',$psw);
        $result = $conn->query("SELECT * FROM main WHERE rno='$rno' AND password='$hash'");
        if($row=$result->fetch_assoc()) 
        {
            echo"
            <script>
                document.getElementById('try').setAttribute('class', 'login-status c-g');
                var p = document.getElementById('try');
                p.textContent = 'Login Success';
            </script>";
            $_SESSION['rno']=$rno;
            if($row['level']=="admin")
            {
                header('Location: admin.php');
            }
            else
            {
                header('Location: action.php');
            }
        }
        else
        {
            echo"
            <script>
                document.getElementById('try').setAttribute('class', 'login-status c-r');
                var p = document.getElementById('try');
                p.textContent = 'Login Failed. Try Again!';
            </script>";
        }
    }
?>