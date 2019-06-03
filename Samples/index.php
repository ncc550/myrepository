<script language="JavaScript" type="text/javascript">
function validate()
{
	var str=  document.getElementById("username").value;
	var x= buttonIndex ;
	var n = str.length;
	if (n > 3)
	{
		document.getElementById("sb").value=x;
		return true ;
	} else {
		alert('User ID must be at least 4 charaters');
		return false ;
	}
}
</script>

<?php
require_once('include/DE.css');
error_reporting(1);

/////////   Start here   
$head1a="<br><br><hr><br><font size=5>Homework Landing Page</font<br><hr><br>" ;
echo $head1a ;

echo "<br><br><table><tr>" ; 
echo "<td width=100></td>" ;
echo "</tr>";
echo "<tr><td width=50></td><td width=250></td><td>" ;
echo "<form name='myForm' action='validateuid.php' method='post' onsubmit='return validate()' >";
echo "<label for='username'>Username(4 characters minimum):</label>";
echo "<input type='text' id='username' name='username'>";
echo "<br><label for='pass'>Password (8 characters minimum):</label>";
echo "<input type='password' id='pass' name='password'";
echo "minlength='8' required>";
echo "<input type='hidden' id='sb' name='sb' value=''>" ;
echo "<br><input style='height:35px; width:210px' onclick='buttonIndex=0;' type='submit' value='Login'>" ;
echo "<input style='height:35px; width:210px' onclick='buttonIndex=1;' type='submit' value='New User'></form>" ;
echo "</tr></table>" ;
?>
