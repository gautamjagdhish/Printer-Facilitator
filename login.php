<?php
    session_start();
    if(isset($_SESSION['rno']))
    {
        if($_SESSION['level']=="admin")
            {
                header('Location: admin.php');
            }
            else
            {
                header('Location: action.php');
            }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Print Facilitator</title>
        <link href="css/style.css" rel="stylesheet">
        <link href="css/bootstrap-4.0.0.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light offset-lg-0 col-lg-12">
            <a class="navbar-brand" href="action.php">Printer Facilitator</a>
        </nav>
        <header>
            <div class="jumbotron">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <p id=try class="login-status">Welcome!</p>
                            <div class="imgcontainer" align=center>
                                <img src="avatar.png" alt="Avatar" class="avatar">
                            </div>
                            <form class="align-content-center" method="POST" enctype="multipart/form-data" action="">
                                <div class="form-group col-lg-4 offset-lg-4">
                                    <input type="text" class="form-control" placeholder="Enter Roll No" name="rno" required>
                                    <br>
                                    <input type="password" class="form-control" placeholder="Enter Password" name="psw" required>
                                    <br>
                                    <button type="submit" class="btn btn-primary" style="width:100%" name="login">Login</button>
                                    <a class="nav-link" href="signup.php" class="signup-image-link">Sign Up</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <script src="js/jquery-3.2.1.min.js"></script> 
        <script src="js/popper.min.js"></script> 
        <script src="js/bootstrap-4.0.0.js"></script>
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
            $_SESSION['status']='success';
            $_SESSION['level']=$row['level'];
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