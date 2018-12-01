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
	<title>Print History</title>
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
					<h1 class="text-center">Print History</h1>
						<?php
							$rno=$_SESSION['rno'];
							$q="SELECT * FROM printhistory";
							$result=$conn->query($q);
							if ($result->num_rows > 0) 
							{
								echo"
								<table align=center class='table border' id=table_id>
								<thead>
									<tr>
										<th width=100>ID</td>
										<th width=150>Roll Number</td>
										<th width=300>PDF Name</td>
										<th width=100>Color</td>
										<th width=100>Pages</td>
										<th width=100>Copies</td>
										<th width=150>Cost</td>
										<th width=100>Printed</td>
										<th width=100>Collected</td>
										<th width=300>Make Changes</td>
									</tr>
								</thead>";
								while($row = $result->fetch_assoc()) 
								{
									echo"
									<tr>
										<td>".$row["id"]."</td>
										<td>".$row["rno"]."</td>
										<td><a href=uploads/".$row["newname"]." target=_blank class=nav-link style='color:grey' >".$row["pdfname"]."</a></td>
										<td><input type=checkbox style='pointer-events: none;'"; if($row['color']==1) echo "checked"; echo"></td>
										<td>".$row['pages']."</td>
										<td>". $row["copies"]."</td>
										<td>₹". $row["cost"]."</td>
										<form action='' method=post>
											<td><input type=checkbox name=ps "; if($row['printstatus']==1) echo "checked"; echo"></td>
											<td><input type=checkbox name=cs "; if($row['collectstatus']==1) echo "checked"; echo"></td>";
											//<td><input type=hidden name=pay "; if($row['paystatus']==1) echo "checked"; echo"></td>
											echo"<td><input type=submit class=btn name=submit value=Change></input></td>
											<input type=hidden name=idfind value=".$row["id"].">
										</form>
									</tr>";
									if(isset($_REQUEST['submit']))
									{
										$id=$_POST['idfind'];
										if(isset($_POST['ps']))
										{
											mysqli_query($conn,"UPDATE printhistory SET printstatus=1 WHERE id='$id'");
										}
										if(empty($_POST['ps']))
										{
											mysqli_query($conn,"UPDATE printhistory SET printstatus=0 WHERE id='$id'");
										}
										if(isset($_POST['cs']))
										{
											mysqli_query($conn,"UPDATE printhistory SET collectstatus=1 WHERE id='$id'");
										}
										if(empty($_POST['cs']))
										{
											mysqli_query($conn,"UPDATE printhistory SET collectstatus=0 WHERE id='$id'");
										}
										if(isset($_POST['pay']))
										{
											mysqli_query($conn,"UPDATE printhistory SET paystatus=1 WHERE id='$id'");
										}
										if(empty($_POST['pay']))
										{
											mysqli_query($conn,"UPDATE printhistory SET paystatus=0 WHERE id='$id'");
										}
										header("Location:admin.php");
									}	
								}
							echo"</table>";
							} 
							else
							echo"No print History Found";
						?>
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