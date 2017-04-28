<?php
session_start();
//connection to sql server
include 'connection.php';
//$_POST[name from input]
if(isset($_SESSION['user'])){
	$username = $_SESSION['user'];
}else{
	$username = (isset($_POST['userName']) ? $_POST['userName'] : null);//if is set, else = null
	$password = (isset($_POST['userPass']) ? $_POST['userPass'] : null);//^

	// convert username to camel case format like in data base
	$username = ucwords(strtolower($username));
	//sql query for username and password check
	$sql = "SELECT * FROM tblUsers WHERE userName = '$username' AND userPass = '$password'";//sql query for username and password check
	$result = mysqli_query($connection, $sql);
	if(!$row = mysqli_fetch_assoc($result)){
		echo 'error logging in, please go back to the log in page and try again.';
		die();
	}else{
		$_SESSION['user'] = $username;
		echo print_r($_POST);
	}
}

header("location:/home.php");
mysqli_close($connection);

?>
