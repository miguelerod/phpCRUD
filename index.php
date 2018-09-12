<?php
	if(session_status() != PHP_SESSION_NONE)
	{
		session_start();
		if($_SESSION['user'])
		{
			header("location: home.php");
		}
	}
?>

<html>
    <head>
	    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		
		<link rel="icon" href="../../../../favicon.png">
		<title>Hullo</title>
    </head>
    <body>
        <?php
            echo "<p>Oi lads!</p>";
        ?>
		<a href="login.php">Log in</a> <br/>
		<a href="registration.php">Register</a><br/>
		<br/>
		<h2 align="center">Public List</h2>
		<table width="100%" border="1px">
			<tr>
				<th>Details</th>
				<th>Post Time</th>
				<th>Edit Time</th>
			</tr>
			<?php
				$mysqli = new mysqli("localhost", "root", "", "website");
				if(mysqli_connect_errno())
				{
					printf("Connection failed: %s\n", mysqli_connect_errno());
					die();
				}
				
				$public_list = $mysqli->query("SELECT * FROM list WHERE public='yes'");
				while($row=$public_list->fetch_array())
				{
					Print '<tr>';
						Print '<td align="center">'.$row['details']."</td>";
						Print '<td align="center">'.$row['date_posted']."-".$row['time_posted']."</td>";
						Print '<td align="center">'.$row['date_edited']."-".$row['time_edited']."</td>";
					Print '</tr>';
				}
			?>
		</table>
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
</html>