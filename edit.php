<?php
	session_start();
	if(!$_SESSION['user'])
	{
		header("location:index.php");
	}
	
	$user = $_SESSION['user'];
	$id_exists = false;
	
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
		<a href="home.php">Git back tae hame</a>
		<h2 align="center">Currently Selected</h2>
		<table border="1px" width="100%">
			<tr>
				<th>Details</th>
				<th>Post Time</th>
				<th>Edit Time</th>
				<th>Public Post</th>
			</tr>
			<?php
				if(!empty($_GET['id']))
				{
					$id = $_GET['id'];
					$_SESSION['id'] = $id;
					
					$mysqli = new mysqli("localhost", "root", "", "website");
					if(mysqli_connect_errno())
					{
						printf("Connection failed: %s\n", mysqli_connect_error());
						die();
					}
					
					$post_query = $mysqli->query("Select * From list Where id='$id'");
					$count = $post_query->num_rows;
					
					if($count > 0)
					{
						$id_exists = true;
						while($row=$post_query->fetch_array())
						{
							Print '<tr>';
								Print '<td align="center">'.$row['details'].'</td>';
								Print '<td align="center">'.$row['date_posted'].' - '.$row['time_posted'].'</td>';
								Print '<td align="center">'.$row['date_edited'].' - '.$row['time_edited'].'</td>';
								Print '<td align="center">'.$row['public'].'</td>';
							Print '</tr>';
						}
					}
				}
			?>
		</table>
		<br/>
		<?php
			if($id_exists)
			{
				Print '
				<form action="edit.php" method="POST">
					Enter new detail <input type="text" name="details"/><br/>
					Public Post? <input type="checkbox" name="public[]" value="yes"/><br/>
					<input type="submit" value="Update List"/>
				</form>
				';
			}
			else
			{
				Print '<h2 align="center">There is no data to be edited.</h2>';
			}
		?>	
	</body>
</html>

<?php
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$mysqli = new mysqli("localhost", "root", "", "website");
		if(mysqli_connect_errno())
		{
			printf("Connection failed: %s\n", mysqli_connect_error());
			die();
		}
		
		$id = $_SESSION['id'];
		
		$details = $mysqli->real_escape_string($_POST['details']);
		$public = "no";
		$time = strftime("%X");
		$date = strftime('%B %d, %Y');
		
		foreach($_POST['public'] as $each_check)
		{
			if($each_check != null)
			{
				$public = "yes";
			}
		}
		
		$mysqli->query("UPDATE list SET details='$details', public='$public', date_edited='$date', time_edited='$time' WHERE id='$id'");
		
		header("location: home.php");
	}
?>
