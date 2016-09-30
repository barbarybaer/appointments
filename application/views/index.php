<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CI Registration and Login</title>
	<style type="text/css">
		* {
			font-family: sans-serif, Arial;
		}
		form{
			margin-left: 50px;
			width: 400px;
			border: 1px solid black;
			padding: 10px;
		}
		h2{
			margin-left: 50px;
		}
		input{
			margin-bottom: 5px;
		}
		
	</style>
	<script>
	  $( function() {
	    $( "#datepicker" ).datepicker();
	  } );
  	</script>
</head>
<body>
	<h1>Welcome!</h1>
	<h2>Login</h2>
<?php		if($this->session->flashdata("login_errors"))
			{
				echo $this->session->flashdata("login_errors");
			}
			
?>
	<form action="login" method="post">
		Email address: <input type="text" name="email"/><br>
		Password: <input type="password" name="password"/><br>
		<input type="submit"  value="Login" /><br>
	</form>	
	<h2>Register</h2>
<?php		if($this->session->flashdata("register_errors"))
			{
				echo $this->session->flashdata("register_errors");
			}
?>
	<form action="register" method="post">
		Name: <input type="text" id = 'name' name="name"/> <br>
		Email address: <input type="text" name="email"/><br>
		Password: <input type="password" name="password"/><br>
		Confirm Password: <input type="password" name="confirmPassword"/><br>
		Date of Birth: <input type="date" name="dob" id='datepicker'><br>

		<input type="submit"  value="Register" /><br>
	</form>
</body>
</html>