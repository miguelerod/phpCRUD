<?php
	$mysqli = new mysqli("localhost", "root", "", "website");
	
	if(mysqli_connect_errno()) {
		printf("Connection failed: %s\n", mysqli_connect_error());
		die();
	}
	
	session_start();
	
	$username = $mysqli->real_escape_string($_POST['username']);
	$password = $mysqli->real_escape_string($_POST['password']);
	
	$user_query = $mysqli->query("SELECT * FROM users WHERE username='$username'");
	$exists = $user_query->num_rows;
	$table_user = "";
	$table_password = "";
	
	if($exists > 0)
	{
		while($row=$user_query->fetch_assoc())
		{
			$table_user = $row['username'];
			$table_password = $row['passwd'];
		}
		
		if(password_verify($password, $table_password))
		{
			$_SESSION['user'] = $username;
			header("location: home.php");
		}
		else
		{
			Print '<script>alert("Incorrect Password!");</script>';
			Print '<script>window.location.assign("login.php");</script>';
		}
	}
	else
	{
		Print '<script>alert("That username doesn\'t exist!");</script>';
		Print '<script>window.location.assign("login.php");</script>';
	}