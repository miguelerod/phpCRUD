<?php
	session_start();
	if(!$_SESSION['user'])
	{
		header("location:index.php");
	}
	
	$user = $_SESSION['user'];
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$mysqli = new mysqli("localhost", "root", "", "website");
		
		if(mysqli_connect_errno())
		{
			printf("Connection failed: %s\n", mysqli_connect_error());
			die();
		}
		
		$details = $mysqli->real_escape_string($_POST['details']);
		$time = strftime("%X");
		$date = strftime("%B %d, %Y");
		$decision = "no";
		
		foreach($_POST['public'] as $each_check)
		{
			if($each_check != null)
			{
				$decision = "yes";
			}
		}
		
		$mysqli->query("INSERT INTO list (details, date_posted, time_posted, public, user) VALUES ('$details', '$date', '$time', '$decision', '$user')");
		
		header("location:home.php");
	}
	else
	{
		header("location:home.php");
	}
?>