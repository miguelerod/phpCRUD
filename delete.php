<?php
	session_start();
	if(!$_SESSION['user'])
	{
		header("location: index.php");
	}
	
	$user = $_SESSION['user'];
	
	if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		$mysqli = new mysqli("localhost", "root", "", "website");
		if(mysqli_connect_errno())
		{
			printf("Connection failed: %s\n", mysqli_connect_error());
			die();
		}
		
		$id = $_GET['id'];
		$mysqli->query("DELETE FROM list WHERE id='$id'");
		
		header("location: home.php");
	}
?>