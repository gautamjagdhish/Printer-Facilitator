<?php
    session_start();
    if(empty($_SESSION['toverify'])||$_SESSION['toverify']!="yes")
    {
        header('Location:logout.php');
    }
    if(!empty($_SESSION['level']))
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
                            <h1 class="text-center">Email Verification</h1>
                            <form class="align-content-center" method="POST" enctype="multipart/form-data" action="">
                                <div class="form-group col-lg-5 offset-lg-4">
                                    <span id="not">Please Enter the verification code sent to your email</span>
                                    <p id='yes'></p>
                                    <input type="text" class="form-control" placeholder="Enter Code"  onkeyup='checkint();' name="code" id="code" required>
                                    <br>
                                    <button type="submit" class="btn btn-primary" style="width:100%" onclick='return checkint();' name="submit">Submit</button>
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
    function checkint()
    {
        i=document.getElementById('rno').value
        if(i!=parseInt(i))
        {
            alert("Please Enter only integer values");
            return false;
        }
    }
    function recheck()
    {
        var m=document.getElementById('not');
        m.setAttribute('style','color:red;');
        m.textContent="Verification Failed. Please check the verification code and enter it properly";
        setTimeout(change,5000);
    }
    function change()
    {
        var m=document.getElementById('not');
        m.setAttribute('style','color:black;');
        m.textContent="Please Enter the verification code sent to your email";
    }
    function change()
    {
        var m=document.getElementById('not');
        m.setAttribute('style','color:green;');
        m.textContent="Account created Successfully!";
        var c =3;
        while(c!=0)
        {
            setTimeout(function{document.getElementById('yes').textContent="You will be redirected in "+c+" seconds.";},1000);
            c=c-1;
        }
    }
</script>
<?php
    include("database.php");
    if(isset($_REQUEST['submit']))
    {
        $xxx=$_SESSION['xxx'];
        $code=$_POST['code'];
        if($code==$xxx)
        {
            $rno=$_SESSION['rno'];
            $psw=$_SESSION['pw'];
            $hash=hash('sha256',$psw);
            mysqli_query($conn,"INSERT INTO main(rno,password,level) VALUES('$rno','$hash','student')"); 
            echo"<script>change();</script>";
            $_SESSION['status']='success';
            $_SESSION['level']='student';
            header('Location:login.php');
        }
        else
        {
            echo"<script>recheck();</script>";
        }
    }
?>