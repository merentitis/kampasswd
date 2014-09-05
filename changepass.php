<?php
session_start();
$host="localhost"; // Host name
$username="user"; // Mysql username
$password="pass"; // Mysql password
$db_name="kamailio"; // Database name
$tbl_name="subscriber"; // Table name
$domain="sip.domain"; //domain used in kamctl

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");


// username ,password and newpassword sent from form
$username=$_POST['username'];
$password=$_POST['password'];
$newpass1=$_POST['newpass1'];
$newpass2=$_POST['newpass2'];
// calculate md5 hashes
$ha1oldpass = md5("$username".":"."$domain".":"."$password");
$ha1newpass1 = md5("$username".":"."$domain".":"."$newpass1");
$ha1newpass2 = md5("$username".":"."$domain".":"."$newpass2");
$ha1bnewpass2 = md5("$username"."@"."$domain".":"."$domain".":"."$newpass2");

//Check if old pass is a match:
$query="SELECT * FROM subscriber WHERE username='$username' AND ha1='$ha1oldpass' LIMIT 1";
//Just for testing the passwords:
//echo "OLD pass: $ha1oldpass";
//echo "NEW ha pass: $ha1newpass1";
//echo "NEW pass: $newpass1";
$result = mysql_query($query);
$num_rows = mysql_num_rows($result);
if($num_rows==0)
{
    echo("existing password not correct");
    exit;
}
if ($_POST['newpass1']!= $_POST['newpass2'])
 {
    echo("Oops! New Passwords did not match! Try again. ");
    exit;
 }
if (empty($newpass1))
 {
    echo("Oops! Password can not be blank! Try again. ");
    exit;
 }
if (strlen($newpass1) < 6) 
 {
    echo("Oops! Password must be at least 6 characters long! Try again. ");
    exit;
 }
else
//This is the new ha1 password
$sql="UPDATE $tbl_name SET ha1='$ha1newpass2' WHERE username='$username' and ha1='$ha1oldpass'";
//echo "ha1 changed $sql <br/>\n";
$result = mysql_query($sql) or die("error: " . mysql_error()) ;

$sql="UPDATE $tbl_name SET ha1b='$ha1bnewpass2' WHERE username='$username' and ha1='$ha1newpass2'";
//echo "Second query: $sql <br/>\n";
$result = mysql_query($sql) or die("error: " . mysql_error()) ;
mysql_close();
echo "SIP Password for user $username Updated Successfully. Please close this page" ;
exit;
?>
