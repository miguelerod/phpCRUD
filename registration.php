<html>
	<head>
	    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	
		<title>Registration</title>
	<body>
	</head>
		<h2>Registration Page</h2>
		<a href="index.php">Click Here to go back</a> <br/>
		<br/>
		<form action="registration.php" method="POST">
			Enter E-Mail: <input type="email" name="email" required="required"/> <br/>
			Enter First Name: <input type="text" name="first_name" required="required" /> <br/>
			Enter Last Name: <input type="text" name="last_name" required="required"/> <br>
			Enter Username: <input type="text" name="username" required="required" /> <br/>
			Enter Password: <input type="password" name="password" required="required" /> <br/>
			<input type="submit" value="Sign Up"/>
		</form>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
</html>

<?php
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$mysqli = new mysqli("127.0.0.1", "root", "", "website");
		
		if(mysqli_connect_errno()) {
			printf("Connection failed: %s\n", mysqli_connect_error());
			die();
		}
		
		$bool = true;

		$email = $mysqli->real_escape_string($_POST['email']);
		$first_name = $mysqli->real_escape_string($_POST['first_name']);
		$last_name = $mysqli->real_escape_string($_POST['last_name']);
		$username = $mysqli->real_escape_string($_POST['username']);
		$password = $mysqli->real_escape_string($_POST['password']);
		
		$hashed_pass = password_hash($password, PASSWORD_DEFAULT);
		
		$users = $mysqli->query("SELECT * FROM users");
		
		while($row = $users->fetch_array())
		{
			$table_users = $row['username'];
			if($username == $table_users)
			{
				$bool = false;
				Print '<script>alert("That username is already taken!");</script>';
				Print '<script>window.location.assign(registration.php");</script>';
			}
		}
		
		$users = $mysqli->query("SELECT * FROM users");
		while($row = $users->fetch_array())
		{
			$table_emails = $row['email'];
			if($email == $table_emails)
			{
				$bool = false;
				Print '<script>alert("That email is already being used!");</script>';
				Print '<script>window.location.assign(registration.php");</script>';
			}
		}
		
		if($bool)
		{
			$mysqli->query("INSERT INTO users (email, first_name, last_name, username, passwd) VALUES ('$email', '$first_name', '$last_name', '$username', '$hashed_pass')");
			$id_query = $mysqli->query("SELECT id FROM users WHERE username='$username'");
			$id = $id_query->fetch_assoc()['id'];
			$mysqli->query("INSERT INTO user_role (user_id, role_id) VALUES ('$id', '1')");
			Print '<script>alert("You\'ve been successfully registered with us!");</script>';
			Print '<script>window.location.assign("index.php");</script>';	
		}
	}
?>