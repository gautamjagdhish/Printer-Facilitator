<html>
<form method=post action=''>
    <input type="checkbox" name="formDoor[]" value="A" />Acorn Building<br />
    <input type="checkbox" name="formDoor[]" value="B" />Brown Hall<br />
    <input type="checkbox" name="formDoor[]" value="C" />Carnegie Complex<br />
    <input type=submit name=submit value=submit>
</form>
</html>
<?php
    $str = "This is some <b>bold</b> text.";
    echo htmlspecialchars($str)."<br>";
        if(isset($_REQUEST['submit']))
    {
        if(empty($_POST['formDoor']))
        {
            echo("You didn't select any buildings.");
        }
        else
        {       
            $aDoor = $_POST['formDoor'];
            $N = count($aDoor);
            echo("You selected $N door(s): ");
            for($i=0; $i < $N; $i++)
            {
                echo htmlspecialchars($aDoor[$i] ). " ";
            }
        }
    }
?>