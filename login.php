<!DOCTYPE html>
<html>
<head>
	<title>LOGIN</title>
	<link rel="stylesheet" type="text/css" href="newstyle.css">
	<h1>INVENTORY SYSTEM</h1>
</head>
<body>
     <form action="login.php" method="post">
        <h1>LOGIN</h1>
     	<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
     	<label>Username</label>
     	<input type="text" name="username" placeholder="Username" required><br>

     	<label>Password</label>
     	<input type="password" name="password" placeholder="Password" required><br>

     	<button type="submit">Login</button>
		<div class="Register"><a href="Register.php">Register</a></div>
     </form>
</body>
</html>

<?php  
$sname= "localhost";
$username= "root";
$password = "";

$db_name = "inventory_system";

$conn = mysqli_connect($sname, $username, $password, $db_name);

if (!$conn) {
	echo "<script>alert('Connection failed');</script>";
}
?>

<?php
session_start();
if (isset($_POST['username']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$username = validate($_POST['username']);
	$password = validate($_POST['password']);

	if (empty($username)) {
		header("Location Login.php?error=Username is required");
	    exit();
	}else if(empty($password)){
        header("Location Login.php?error=Password is required");
	    exit();
	}else{
		$sql = "SELECT * FROM account WHERE userName='$username' AND passWord='$password'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['userName'] === $username && $row['passWord'] === $password) {
                    echo "Logged in!";
            	$_SESSION['userame'] = $row['userName'];
            	$_SESSION['name'] = $row['name'];
            	$_SESSION['id'] = $row['id'];
				/**
				 * Do an sql statement here that will look for the $userName of the logged in user
				 * in tables staff and supplier. If it exists, set the correct location for the
				 * specific dashboard of the user.
				 */
            	header("Location: Dashboard.php");
		        exit();
            }else{
				header("Location: Login.php?error=Incorect Username or Password");
		        exit();
			}
		}else{
			header("Location: Login.php?error=Incorect Username or Password");
	        exit();
		}
	}
	
}else{
	exit();
}
?>
