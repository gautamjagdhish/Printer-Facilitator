<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sign Up</title>    
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <h2>Printer Facilitator</h2>
        <form action="" method="post" style="border:1px solid #ccc">
        <div class="container">
            <h1>Sign Up</h1>
            <p>Please fill in this form to create an account.</p>
            <hr>
            <input type="text" placeholder="Enter Roll No" onkeyup='checkint();' name="rno" id='rno' required>
            <input type="password" placeholder="Enter Password" name="psw" id=pwd1 onkeyup='check();' required>
            <span class='password-match' id='message'></span>
            <input type="password" placeholder="Repeat Password" name="psw-repeat" id=pwd2 onkeyup='check();' required>
            <button type="submit" name="signup" class="signupbtn" onclick='return checkpwd();'>Sign Up</button>
            <a href="login.php" class="signup-image-link">Already created a account?</a>
        </div>
        </form>
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
    function checkpwd(){
        if (document.getElementById('pwd1').value != document.getElementById('pwd2').value)
        {
            alert("Password do not match");
            return false;
        }
        i=document.getElementById('rno').value
        if(i!=parseInt(i))
        {
            alert("Please Enter only integer values");
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
    include("database.php");
    if(isset($_REQUEST['signup']))
    {
        $rno=$_POST['rno'];
        $psw=$_POST['psw'];
        $hash=hash('sha256',$psw);
        mysqli_query($conn,"INSERT INTO main(rno,password,level) VALUES('$rno','$hash','student')");
        if(mysqli_affected_rows($conn)>0)
        {
            echo "Added Succcessfully";
        }  
        else
        {
            echo"Please recheck the values";
        } 
    }
?>