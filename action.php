<?php
include"database.php";
session_start();
if(empty($_SESSION['level']))
	header('Location:logout.php');
if($_SESSION['level']=='admin')
	header('Location:admin.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Print!</title>
	<link href="css/bootstrap-4.0.0.css" rel="stylesheet">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light offset-lg-0 col-lg-12">
		<a class="navbar-brand" href="action.php">Printer Facilitator</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> 
				<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active align-items-lg-end"> <a class="nav-link" href="printhistory.php">Print History<span class="sr-only">(current)</span></a></li>
				<li class="nav-item"> <a class="nav-link" href="logout.php">Log Out</a></li>
			</ul>
		</div>
	</nav>
	<header>
		<div class="jumbotron">
			<div class="container">
				<div class="row">
					<div class="col-12">
					<h1 class="text-center">New Print </h1>
						<form class="align-content-center" method="POST" enctype="multipart/form-data" action="">
							<div class="form-group col-lg-4 offset-lg-4">
								<label for="Upload">Upload</label>
								<input type="file" class="form-control" name="file" id='file' required>
								<label for="Pages">Pages</label>		
								<input type="text" class="form-control" name="pages" id="pages" value="1" required>
								<span><font size=2>Please write valid single page numbers and/or page number range, separated by comma, in ascending order. Example input:1,23-45,51,54-65</font></span>
								<br>
								<label for="Upload">Copies</label>
								<input type="number" class="form-control" name="copies" id='copies' min=1 value=1 required>
								<input type="checkbox" name="color" id='color' value="true" unchecked><label for="Color" >Color</label><br>
								<button type="submit" class="btn btn-primary" name='submit' onclick='return checkcountconfirm();'>New Print</button>
								<br>
								<span id='status' style="text-align:center"></span>
								<br>
								<span id='status1' style="text-align:center"></span>
								<input type=hidden id=totalcost name=totalcost>
								<input type=hidden id=nopages name=nopages>
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
	function showid()
	{
		var p = document.getElementById('status1');
		var id='<?php 
		$sql="SELECT MAX(id) AS lastid from printhistory";
		$result=$conn->query($sql);
		$row=$result->fetch_assoc();
		$lastid=$row["lastid"];
		echo $lastid; ?>';
		id=parseInt(id)+1;
		p.innerHTML ='Print Job ID is '+id;
	}
	var fileInput = document.getElementById('file');
	fileInput.onchange=function ext()
	{
		var filePath = fileInput.value;
		var allowedExtensions = /(\.pdf)$/i;
		if(!allowedExtensions.exec(filePath))
		{
				alert('Upload only .pdf files');
				return false;
		}
	};
	function checkcountconfirm()
	{
		var fileInput = document.getElementById('file');
		var filePath = fileInput.value;
		var allowedExtensions = /(\.pdf)$/i;
		if(!allowedExtensions.exec(filePath))
		{
			alert('Upload only .pdf files');
			return false;
		}
		str = document.getElementById('pages').value;				
		t1 = /[0-9]+/;
		t2=/[0-9]+-[0-9]+/
		if(!str.match(/^[0-9]+(?:-[0-9]+)?(,[0-9]+(?:-[0-9]+)?)*$/))
		{
			alert("Invalid Page Number");
			return false;
		}
		arr = str.split(/[,-]/).map(Number);
		for (var i = 0; i < arr.length-1; i++)
		{
			if (arr[i+1]<=arr[i])
			{
				alert("Invalid Page Number");
				return false;
			}
		}
		var count1 = 0;
		var count2 = 0;
		brr = str.split(/[,]/);
		console.log(brr);
		for (var i = 0; i < brr.length; i++,count2 = 0) 
		{
			var stri = brr[i];
			for (var j = 0; j < stri.length; j++) 
			{
				if(stri[j] =='-')
				{
					var nums = stri.split(/[-]/).map(Number);
					count1 = count1 + nums[1]-nums[0]+1;
					count2++;
				}
			}
			if(count2 == 0)
				count1++;
		}
		document.getElementById('nopages').value=count1;

		var copies=document.getElementById('copies').value;
		if(document.getElementById('color').checked==true)
			color=5;
		else
			color=1;
		var totalcost=copies*count1*color;
		//alert("copies "+copies+"\ncolor "+color+"\npages "+count1);
		r=confirm("Cost of Printing is ₹"+totalcost);
		if(r==true)
			document.getElementById('totalcost').value=totalcost;
		if(r==false)
			return false;
	}
</script>
<?php
$rno=$_SESSION['rno'];
if(isset($_REQUEST['submit']))
{
	$sql="SELECT MAX(id) AS lastid from printhistory";
	$result=$conn->query($sql);
	$row=$result->fetch_assoc();
	$lastid=$row["lastid"];
	$id=$lastid+1;
	if(empty($_POST['color'])) 
	{
		$color='0';
		$cost=1;
	}
	else
	{
		$color='1';
		$cost=5;
	}
	$pdfname=$_FILES['file']['name'];
	$pages=$_POST['pages'];
	$copies=$_POST['copies'];
	$nopages=$_POST['pages'];
	$totalcost=$_POST['totalcost'];
	$newname=$id."_".$nopages."_".$copies."_".$color.".pdf";
	$target="uploads/".basename($newname);
	if(move_uploaded_file($_FILES['file']['tmp_name'],$target))
	{
		$status="Successfully uploaded";
		mysqli_query($conn,"UPDATE main SET balance=balance+'$totalcost' WHERE rno='$rno'");
		/*if (!mysqli_query($conn,"UPDATE main SET balance='$nopages' WHERE rno='$rno'"))
		{
		echo("<br>Unable to Update Balance: ".mysqli_error($conn)."<br>");
		}*/
		echo "<script>showid();</script>";
		mysqli_query($conn,"INSERT INTO printhistory(pdfname,newname,rno,color,pages,copies,cost) VALUES ('$pdfname','$newname','$rno','$color','$pages','$copies','$totalcost')");
		/*if (!mysqli_query($conn,"INSERT INTO printhistory(pdfname,newname,rno,color,pages,copies,cost) VALUES ('$pdfname','$newname','$rno','$color','$pages','$copies','$totalcost')"))
		{
		echo("<br>Unable to insert to printhistory: ".mysqli_error($conn)."<br>");
		}*/
		if(mysqli_affected_rows($conn)<=0)
			echo "error";
		else
			echo"
			<script>
				var p = document.getElementById('status');
				p.innerHTML ='Uploaded Successfully';
			</script>";
	}
	else
	{
	echo"
		<script>
			var p = document.getElementById('status');
			p.style.color = 'red';
			p.innerHTML ='Uploaded Failed';
		</script>";
	}
}
?>
