<?php
include"database.php";
session_start();
if(empty($_SESSION['level']))
	header('Location:logout.php');
if($_SESSION['level']=='student')
    header('Location:action.php');
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Make Payment</title>
    <link href="css/bootstrap-4.0.0.css" rel="stylesheet">
    <style>
        table, td, th 
        {    
            border: 1px solid #ddd;
            text-align: left;
        }
        table 
        {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 15px;
        }
        
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light offset-lg-0 col-lg-12"><a class="navbar-brand" href="admin.php">Printer Facilitator</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"> <a class="nav-link" href="payments.php">Make Payment</a></li>
            <li class="nav-item"> <a class="nav-link" href="payhistory.php">Payment History</a></li>
            <li class="nav-item"> <a class="nav-link" href="logout.php">Log Out</a></li>
        </ul>
        </div>
    </nav>
    <header>
    <div class="jumbotron">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center">Make Payment</h1>
                        <div class="col-md-8 col-sm-12 text-center col-lg-8 offset-lg-2">
                            <?php
                                $rno=$_SESSION['rno'];
                                $q="SELECT * FROM main WHERE level='student' ORDER BY balance DESC";
                                $result=$conn->query($q);
                                if ($result->num_rows > 0) 
                                {
                                    echo"
                                    <table align=center class='table border' id=table_id>
                                    <thead>
                                        <tr>
                                            <th width=400>Roll Number</td>
                                            <th width=200>Remaining Balance</td>
                                            <th width=200>Amount Paid</td>
                                            <th width=200>Confirm</td>
                                        </tr>
                                    </thead>";
                                    while($row = $result->fetch_assoc()) 
                                    {
                                        echo"
                                        <tr>
                                            <td>".$row["rno"]."</td>
                                            <td>₹".(int)$row["balance"]."</td>
                                            <form action='' method=post>
                                                <td><input type=number name=update id=update style='width: 60px;' min=0 value=0></td>
                                                <td><input type=submit class='btn' name=submit style='width:100%' onclick=\"return confirm('Please Confirm')\"></td>
                                                <input type=hidden name=hider id=hider value=".$row["rno"].">
                                            </form>
                                        </tr>";
                                        if(isset($_REQUEST['submit']))
                                        {
                                            $rno=$_POST['hider'];
                                            $bc=$_POST['update'];
                                            $sql="SELECT balance FROM main WHERE rno='$rno'";
                                            $result=$conn->query($sql);
                                            $row=$result->fetch_assoc();
                                            $now=$row["balance"];
                                            $now=(int)$now;
                                            date_default_timezone_set("Asia/Kolkata");
                                            $date = date_create();
                                            $timestamp=date_format($date, 'd-m-Y H:i:s');
                                            if($now>=$bc)
                                            {
                                                $sql="UPDATE main SET balance=balance-'$bc' WHERE rno='$rno'";
                                                mysqli_query($conn,$sql);
                                                mysqli_query($conn,"INSERT INTO payments(rno,amount,timestamp) VALUES('$rno','$bc','$timestamp')");  
                                                header('Location:payments.php');
                                                break;
                                            }
                                            else
                                            {
                                                echo"
                                                    <script>
                                                        alert('Please Recheck the value');
                                                        window.location.replace('payments.php');
                                                    </script>";
                                                break;
                                            }
                                        }
                                    }
                                echo"</table>";
                                } 
                                else
                                echo"<p align=center>No print History Found</p>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    </footer>
    <script src="js/jquery-3.2.1.min.js"></script> 
    <script src="js/popper.min.js"></script> 
    <script src="js/bootstrap-4.0.0.js"></script>
</body>
</html>
<script>
    function conf()
    {
        var r=confirm('Please Confirm');
        if(r==true)
        {
            '<php doit(); ?>'
        }
    }
</script>
