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
    <nav class="navbar navbar-expand-lg navbar-light bg-light offset-lg-0 col-lg-12"><a class="navbar-brand" href="action.php">Printer Facilitator</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
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
                  <input type="file" class="form-control" name="file" required>
                  <label for="Pages">Pages</label>		
                  <input type="text" class="form-control" name="pages" id="pages" value="All" required>
                  <label for="Upload">Copies</label>
                  <input type="number" class="form-control" name="copies" min=1 value=1 required>
                  <input type="checkbox" name="color" value="true" unchecked><label for="Color" >Color</label><br>
                  <label for="Submit"></label> 
                  <input type="submit" class="btn btn-primary" name='submit' onclick="return checkstring();" value="New Print"></input>
                  <br>
                  <span id='status' style="text-align:center"></span>
                  <br>
                  <span id='status1' style="text-align:center"></span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </header>
<section>
	<div class="container">
  </div>
  <div class="container ">
    <div class="row">
      <div class="col-md-6 col-sm-12 text-center col-lg-4 offset-lg-4">
        <span id=balance><h1></h1></span>
      </div>
    </div>
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
    
  function checkstring()
		{
			str = document.getElementById('pwd1').value;				
			t1 = /[0-9]+/;
			t2=/[0-9]+-[0-9]+/
			if(!str.match(/^[0-9]+(?:-[0-9]+)?(,[0-9]+(?:-[0-9]+)?)*$/))
			{
				alert("Invalid entry");
				return false;
			}
			arr = str.split(/[,-]/).map(Number);
			for (var i = 0; i < arr.length-1; i++)
			{
				if (arr[i+1]<=arr[i])
				{
					alert("Invalid entry");
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
				{
					count1++;
				}
			}
			console.log(count1);
		} 
</script>
<?php
$rno=$_SESSION['rno'];
if(isset($_REQUEST['submit']))
{
    if(empty($_POST['color'])) 
    {
      $color='#CE0C00';
      $cost=1;
    }
    else
    {
      $color='green';
      $cost=5;
    }
    $pdfname=$_FILES['file']['name'];
    $target="uploads/".basename($pdfname);
    $pages=$_POST['pages'];
    $copies=$_POST['copies'];
    $nopages=1;
    $totalcost=$nopages*$cost*$copies;
    if(move_uploaded_file($_FILES['file']['tmp_name'],$target))
    {
        $status="Successfully uploaded";
        mysqli_query($conn,"UPDATE main SET balance=balance+'$totalcost' WHERE rno='$rno'");
        /*if (!mysqli_query($conn,"UPDATE main SET balance='$nopages' WHERE rno='$rno'"))
        {
          echo("<br>Error description: ".mysqli_error($conn)."<br>");
        }*/
        echo "<script>showid();</script>";
        mysqli_query($conn,"INSERT INTO printhistory(pdfname,rno,color,pages,copies,cost) VALUES ('$pdfname','$rno','$color','$pages','$copies','$totalcost')");
        /*if (!mysqli_query($conn,"INSERT INTO printhistory(pdfname,rno,color,pages,copies) VALUES ('$pdfname','$rno','$color','$pages','$copies')"))
        {
          echo("<br>Error description: ".mysqli_error($conn)."<br>");
        }
        if(mysqli_affected_rows($conn)<=0)
          echo "error";-->*/
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
