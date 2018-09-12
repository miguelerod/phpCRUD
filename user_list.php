<?php	
	session_start();
	if(!$_SESSION['user'])
	{
		header("location: index.php");
	}
	
	$mysqli = new mysqli("localhost", "root", "", "website");
	if(mysqli_connect_errno())
	{
		printf("Connection failed: %s\n", mysqli_connect_error());
		die();
	}
	
	$user = $_SESSION['user'];
	$query = $mysqli->query("SELECT id FROM users WHERE username='$user'");
	$user_id = $query->fetch_array()['id'];
	$query = $mysqli->query("SELECT role_id FROM user_role WHERE user_id='$user_id'");
	$permission = $query->fetch_array()['role_id'];
	
	$id = $_GET['id'];
	$query = $mysqli->query("SELECT username FROM users WHERE id='$id'");
	$selected_user = $query->fetch_array()['username'];
	$selected_usr_lst = $mysqli->query("Select * FROM list WHERE user='$selected_user'");
	
	if(($permission != 2) && ($permission != 3))
	{
		header("location: home.php");
	}
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		
		<link rel="icon" href="../../../../favicon.png">
		
		<title><?php Print "$selected_user";?>'s list</title>
	</head>
	<body>
		<h2>Hame</h2>
		<p>Oi <?php echo "$user"; ?>!</p>
		<a href="home.php">Click here to go back.</a><br/>
		<br/>
		<form action="add.php" method="POST">
			Add more to list: <input type="text" name="details"/><br/>
			Public post? <input type="checkbox" name="public[]" value="yes"/><br/>
			<input type="submit" value="Add to list"/>
		</form>
		<h2 align="center"><?php Print "$selected_user";?>'s list</h2>
		<table border="1px" width="100%">
			<tr>
				<th>Details</th>
				<th>Post Time</th>
				<th>Edit Time</th>
				<?php
					if($permission == 2)
					{
						Print '
						<th>Edit</th>
						<th>Delete</th>
						';
					}	
				?>
				<th>Public Post</th>
			</tr>
			<?php
				while($row = $selected_usr_lst->fetch_array())
				{
					Print '<tr>';
						Print '<td align="center">'.$row['details']."</td>";
						Print '<td align="center">'.$row['date_posted']."-".$row['time_posted']."</td>";
						Print '<td align="center">'.$row['date_edited']."-".$row['time_edited']."</td>";
						if($permission == 2)
						{
							Print '<td align="center"><a href="edit.php?id='.$row['id'].'">edit</a></td>';
							Print '<td align="center"><a href="#" onclick="delete_record('.$row['id'].')">delete</a></td>';
						}
						Print '<td align="center">'.$row['public']."</td>";
					Print '</tr>';
				}
			?>
		</table>
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
</html>