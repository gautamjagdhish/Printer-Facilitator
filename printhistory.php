<?php
  include"database.php";
  session_start();
  if(empty($_SESSION['rno']))
    header('Location:login.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print!</title>
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light offset-lg-0 col-lg-12"><a class="navbar-brand" href="action.php">Printer Facilitator</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        	<ul class="navbar-nav mr-auto">
            <li class="nav-item active align-items-lg-end"> <a class="nav-link" href="#">Print History<span class="sr-only">(current)</span></a></li>
				  <li class="nav-item"> <a class="nav-link" href="logout.php">Log Out</a></li>
		    </ul>
	    </div>
    </nav>
    <header>
    <div class="jumbotron">
        
        <div class="container">
          <div class="row">
            <div class="col-12">
              <h1 class="text-center">Print History</h1>
              <div class="container ">
                <div class="row">
                  <div class="col-md-6 col-sm-12 text-center col-lg-4 offset-lg-4">
                    <font size=5 id='balance'><p></p></font>
                    <br>
                  </div>
                </div>
              </div>
                    <?php
                        $rno=$_SESSION['rno'];
                        $q="SELECT * FROM printhistory WHERE rno='$rno'";
                        $result=$conn->query($q);
                        if ($result->num_rows > 0) 
                        {
                            echo"
                            <table align=center class='table border' id=table_id>
                            <thead>
                                <tr>
                                    <th width=100>ID</td>
                                    <th width=300>PDF Name(Click to view)</td>
                                    <th width=100>Color</td>
                                    <th width=100>Pages</td>
                                    <th width=100>Copies</td>
                                    <th width=100>Cost</td>
                                    <th width=100>Print Status</td>
                                    <th width=110>Collection Status</td>
                                    <th width=100>Payment Status</td>
                                </tr>
                            </thead>";
                            
                            while($row = $result->fetch_assoc()) 
                            {
                                echo"
                                <tr>
                                    <td>".$row["id"]."</td>
										                <td><a href=uploads/".$row["newname"]." target=_blank class=nav-link style='color:grey' >".$row["pdfname"]."</a></td>
                                    <td><input type=checkbox style='pointer-events: none;' "; if($row['color']==1) echo "checked"; echo"></td>
                                    <td>".$row['pages']."</td>
                                    <td>". $row["copies"]."</td>
                                    <td>₹". $row["cost"]."</td>
                                    <td><input type=checkbox style='pointer-events: none;' "; if($row['printstatus']==1) echo "checked"; echo"></td>
                                    <td><input type=checkbox style='pointer-events: none;' "; if($row['collectstatus']==1) echo "checked"; echo"></td>
                                    <td><input type=checkbox style='pointer-events: none;' "; if($row['paystatus']==1) echo "checked"; echo"></td>
                                </tr>";
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
    </header>
<section>
	<div class="container">
  </div>
  
  <div class="row">
    <div class="col-lg-12 mb-4 mt-2 text-center">
    </div>
  </div>
    <footer class="text-center">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <a class="nav-link" href="logout.php">Log Out</a>
          </div>
        </div>
      </div>
    </footer>
    <script src="js/jquery-3.2.1.min.js"></script> 
    <script src="js/popper.min.js"></script> 
    <script src="js/bootstrap-4.0.0.js"></script>
  </body>
</html>
<script>
  var b = document.getElementById('balance');
  var bal='<?php 
  $rno=$_SESSION['rno'] ;
  $sql="SELECT * from main WHERE rno='$rno'";
  $result=$conn->query($sql);
  $row=$result->fetch_assoc();
  $lastid=$row["balance"];
  echo $lastid; ?>';
  bal=parseInt(bal);
  b.innerHTML ='Amount to be paid is ₹'+bal;
    function color(b)
    {
        if(b==0)
            return 'red'
        else
            return 'green';
    }
</script>