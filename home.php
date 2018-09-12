<?php
	session_start();
	if(!$_SESSION['user'])
	{
		header("location:index.php");
	}
	
	$user = $_SESSION['user'];
	
	$title = sprintf("%s's hame", $user);
?>

<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		
		<link rel="icon" href="../../../../favicon.png">
		
		<title><?php echo $title; ?></title>
	</head>
	<body>
		<h2>Hame</h2>
		<p>Oi <?php echo "$user"; ?>!</p>
		<a href="logout.php">Click here to logout</a><br/>
		<br/>
		<form action="add.php" method="POST">
			Add more to list: <input type="text" name="details"/><br/>
			Public post? <input type="checkbox" name="public[]" value="yes"/><br/>
			<input type="submit" value="Add to list"/>
		</form>
		<h2 align="center">Me list</h2>
		<table border="1px" width="100%">
			<tr>
				<th>Details</th>
				<th>Post Time</th>
				<th>Edit Time</th>
				<th>Edit</th>
				<th>Delete</th>
				<th>Public Post</th>
			</tr>
		<?php
			$mysqli = new mysqli("localhost", "root", "", "website");
			
			if(mysqli_connect_errno())
			{
				printf("Connection failed: %s\n", mysqli_connect_error());
				die();
			}
			
			$my_list = $mysqli->query("Select * FROM list WHERE user='$user'");
			
			while($row = $my_list->fetch_array())
			{
				Print '<tr>';
					Print '<td align="center">'.$row['details']."</td>";
					Print '<td align="center">'.$row['date_posted']."-".$row['time_posted']."</td>";
					Print '<td align="center">'.$row['date_edited']."-".$row['time_edited']."</td>";
					Print '<td align="center"><a href="edit.php?id='.$row['id'].'">edit</a></td>';
					Print '<td align="center"><a href="#" onclick="delete_record('.$row['id'].')">delete</a></td>';
					Print '<td align="center">'.$row['public']."</td>";
				Print '</tr>';
			}
		?>
		</table>
		<br/>
		
		<?php
			$mysqli = new mysqli("localhost", "root", "", "website");
			if(mysqli_connect_errno())
			{
				printf("Connection Failed: %s\n", mysqli_connect_errno());
				die();
			}
			
			$query = $mysqli->query("SELECT id FROM users WHERE username='$user'");
			$user_id = $query->fetch_array()['id'];
			$query = $mysqli->query("SELECT role_id FROM user_role WHERE user_id='$user_id'");
			$permission = $query->fetch_array()['role_id'];
			
			if(($permission == 2) || ($permission == 3))
			{
				$user_list = $mysqli->query("SELECT username, id FROM users");
				Print '
					<h2>User List</h2>
					<ul>
				';
				while($row=$user_list->fetch_array())
					if($row['username'] != $user)
				{
					{
						Print '<li><a href="user_list.php?id='.$row['id'].'">'.$row['username'].'</a></li>';
					}
				}
				Print '</ul>';
			}
		?>
		
		<script>
			function delete_record(id)
			{
				var r=confirm("Are you sure you want to delete this record?");
				
				if(r===true)
				{
					window.location.assign("delete.php?id="+id);
				}
			}
		</script>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
</html>