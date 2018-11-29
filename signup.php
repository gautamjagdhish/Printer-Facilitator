<?php
    session_start();
    if(!empty($_SESSION['status']))
    {
        header('Location:logout.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign Up!</title>
        <link href="css/bootstrap-4.0.0.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">

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
                            <h1 class="text-center">Sign Up! </h1>
                            <form class="align-content-center" method="POST" enctype="multipart/form-data" action="">
                                <div class="form-group col-lg-4 offset-lg-4">
                                    <br>
                                    <input type="text" class="form-control" placeholder="Enter Roll No"  onkeyup='checkint();' name="rno" id='rno' required>
                                    <br>
                                    <input type="password" placeholder="Enter Password" class="form-control" name="psw" id=pwd1 onkeyup='check();' required>
                                    <span class='password-match' id='message'></span>
                                    <br>
                                    <input type="password" placeholder="Repeat Password" class="form-control" name="psw-repeat" id=pwd2 onkeyup='check();' required>
                                    <br>
                                    <button type="submit" class="btn btn-primary" style="width:100%" onclick='return checkpwd();' name="signup">Sign Up</button>
                                    <a href="login.php" class="nav-link">Already created a account?</a>
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
<script>
    var check = function() 
    {
        if (document.getElementById('pwd1').value==document.getElementById('pwd2').value) 
        {
            document.getElementById('message').style.color = 'green';
            document.getElementById('message').innerHTML = 'Passwords Match';
        } 
        else 
        {
            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = 'Passwords do not match';
        }
    }
    function checkpwd()
    {
        if (document.getElementById('pwd1').value != document.getElementById('pwd2').value)
        {
            alert("Password do not match");
            return false;
        }
        i=document.getElementById('rno').value
        if(i!=parseInt(i))
        {
            alert("Please Enter Roll number as integer values");
            return false;
        }
    }
    function checkint()
    {
        i=document.getElementById('rno').value
        if(i!=parseInt(i))
        {
            alert("Please Enter only integer values");
            return false;
        }
    }
</script>
<?php
    if(isset($_REQUEST['signup']))
    {
        $random = substr(number_format(time()*rand(),0,'',''),0,6);
        $rno=$_POST['rno'];
        $_SESSION['rno']=$rno;
        $_SESSION['pw']=$_POST['psw'];
        $_SESSION['xxx']=$random;
        ini_set( 'display_errors', 1 );
        error_reporting( E_ALL );
        $from = "iitdhprint@gmail.com";
        $to = $rno."@iitdh.ac.in";
        $subject = "Verification Code for Printer Facilitator";
        $message = "Verification code is ".$random;
        if(mail($to,$subject,$message))
        {
            $_SESSION['toverify']="yes";
            header('Location:verification.php');
        }
    }
?>