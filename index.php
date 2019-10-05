<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Authenticator</title>
    <meta charset="utf-8" />
    <script src="js/script.js"></script>
</head>

<body>
	<?php
		define('servername','localhost');
		define('username','root');
		define('password','');
		define('dbname','restaurantdatabase');
		
		$conn = mysqli_connect(servername, username, password, dbname);
		
		if ($conn == false) {
			die("ERROR: Connection failed. ".mysqli_connect_error());
		}
	?>
    <form action="index.php" method="post" novalidate="novalidate">
        <label for="_username">Username:</label> <input type="text" name="username" id="_username"><br>
        <label for="_password">Password:</label> <input type="text" name="password" id="_password"><br>
        
        <button type="submit">Login</button>
        <button type="reset">Reset</button>
    </form>
    <?php
		$user = $pass = "";
		$username_err = $password_err = "";
		
		if($_SERVER["REQUEST_METHOD"] == "POST"){
		 
			if(empty(trim($_POST["username"]))){
				$username_err = "Please enter username.";
			} else{
				$user = trim($_POST["username"]);
			}
			
			if(empty(trim($_POST["password"]))){
				$password_err = "Please enter your password.";
			} else{
				$pass = trim($_POST["password"]);
			}
			
			if(empty($username_err) && empty($password_err)){
				$sql = "SELECT username, password FROM account WHERE username = ?";
				$stmt = mysqli_prepare($conn, $sql);
				mysqli_stmt_bind_param($stmt, 's', $user);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_store_result($stmt);
				
				if(mysqli_stmt_num_rows($stmt) == 1){
					mysqli_stmt_bind_result($stmt, $user, $stored_password);
					
					if(mysqli_stmt_fetch($stmt)){
						if($pass == $stored_password){
							header("location: homepage.php");
						}
						else{
							echo "<p>Incorrect Password.</p>";
							echo $pass;
							echo $stored_password;
						}
					}
				}
				else{
					echo "<p>Username does not exist.</p>";
				}
				mysqli_close($conn);
			}
			else{
				if(empty(trim($_POST["username"]))){
					echo "<p>".$username_err."</p>";
				}
				if(empty(trim($_POST["password"]))){
					echo "<p>".$password_err."</p>";
				}
			}
		}
	?>
</body>

</html>