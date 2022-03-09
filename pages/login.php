<?php
	include('/scripts/dbConnect.php');
    
	$username = $password = "";
	$username_err = $password_err = "";

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(empty(trim($_POST["username"])))
		{
			$username_err = "Please enter username.";
		} else{
			$username = trim($_POST["username"]);
		}
		
		if(empty(trim($_POST["password"])))
		{
			$password_err = "Please enter your password.";
		} else{
			$password = trim($_POST["password"]);
		}
		
		if(empty($username_err) && empty($password_err))
		{
			$query = "SELECT * FROM Users WHERE username like ?";

			if($stmt = mysqli_prepare($dbConnect, $query)){
				mysqli_stmt_bind_param($stmt, "s", $param_username);
				$param_username = $username;
				if(mysqli_stmt_execute($stmt))
				{
					mysqli_stmt_store_result($stmt);
					
					if(mysqli_stmt_num_rows($stmt) == 1)
					{                    
						mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $type);
						
						
						if(mysqli_stmt_fetch($stmt))
						{
							
							if(password_verify($password, $hashed_password))
							{
								
								if($type == 2){
									echo '<META HTTP-EQUIV="refresh" content="0; URL=admin_view.php">';
								}else{
									echo '<META HTTP-EQUIV="refresh" content="0; URL=searchPokeAll.php">';
								}
							}else
							{
								$password_err = "The password you entered was not valid.";
							}
						}
					}else
					{
						$username_err = "No account found with that username.";
					}
				} else
				{
					echo "Error, something went wrong.";
				}
				mysqli_stmt_close($stmt);
			}
		}
		mysqli_close($dbConnect);
}
/*I'm gonna be honest, I was working on this for a while and could not get it to wokr
 *So I finally caved in and googled how to get a proper login form to work.
 *https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php
 */
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Online Banking</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
		<style>
		
			#headerMessage{
				font-family: sans-serif;
				color: black;
				border-bottom: 1px solid #000000;
				text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
				text-align: center;
				font-size: 30px;
				padding-top: 10px;
			}
			#container1{
				margin: 0 auto;
				width: 500px;
				height: 500px;
				background: rgba(235,23,23);
				box-shadow: 10px 10px 5px grey;
				border-radius: 10px; 
				border-color: black;
				border-width: 5px;
			}
			.container2{
				margin: 0 auto;
				background: white;
				width: 430px;
				height: 400px;
				color: black;
				font-family: sans-serif;
				border-radius: 10px;
			}
			#loginContainer{
				padding-left: 15px;
				padding-top: 30px;
			}
			#customerLoginBtn{
				float: right; 
				margin-right: 80px; 
				width: 100px; 
				height: 25px; 
				text-align: center;
				font-family: sans-serif; 
			}
			#customerLoginBtn:hover{
				opacity: 0.6;
			}
			#linksNavi{
				text-align: center;
				margin-top: 100px
			}
		</style>
	</head>
  <body>

		<div id = "container1">
			<h3 id= "headerMessage"> Online Banking </h3>
			<div class = "container2">
				<h4 style = "font-size: 25px; padding-top: 25px; text-align: center;"> Customer Login <h4>
					<form id = "loginContainer" >
						
						<label for="userName">Username:</label>
						<br>
						<input type="text" style= "width: 250px;" name="userName"	  autocomplete="off"><br>
						<br>

						<label for="passWord">Password:</label>
						<br>
						<input style= "width: 250px;" type="password" id="passWord" autocomplete="off">
					</form>
					<br>

					<button id = "customerLoginBtn" onclick= "window.location.href = 'pages/customerHomePage.html'">Log In</button>

					<div id = "linksNavi"> 
						<a href="pages/adminLogin.html">Admin Login</a>
						|
						<a href=" ">Contact Support </a>
						|
						<a href=" ">Forgot Password</a>
					</div> 
			</div> 
		</div>
  </body>

	<script> 
		

	</script>
<