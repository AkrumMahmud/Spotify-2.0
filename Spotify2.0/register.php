<!DOCTYPE html>
<?php
	include("include/config.php");
	include("include/classes/Account.php");
	include("include/classes/Constants.php");

	$account = new Account($con);

	include("include/handler/registerHandler.php");
	include("include/handler/loginHandler.php");

	function getInputValue($name) {
		if(isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}
?>

<html>
<head>
	<title>Spotify2.0</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<script src="assets/js/register.js"></script>
</head>
<body>
	<?php 
		if(isset($_POST['registerButton'])){
			echo '<script type="text/javascript">
					$(document).ready(function(){

						$("#loginForm").hide();
						$("#registerForm").show();
				});
				</script>';
		}
		else{
			echo '<script type="text/javascript">
					$(document).ready(function(){

						$("#loginForm").show();
						$("#registerForm").hide();
				});
				</script>';
		}
	?>

	<div id="background">
		<div ID="loginContainer">
			<div id="inputContainer">
				<form id="loginForm" action="register.php" method="POST">
					<h2>Login to your account</h2>
					<p>
						<?php echo $account->getError(Constants::$loginFailed); ?>
						<label for="loginUsername">Username</label>
						<input id="loginUsername" name="loginUsername" type="text" value="<?php getInputValue('loginUsername') ?>" required>
					</p>
					<p>
						<label for="loginPassword">Password</label>
						<input id="loginPassword" name="loginPassword" type="password" required>
					</p>

					<button type="submit" name="loginButton">LOG IN</button>
					
					<div class="hasAccount"> 
						<span id="hideLogin">Sign up here.</span>
					</div>

				</form>



				<form id="registerForm" action="register.php" method="POST">
					<h2>Create your free account</h2>
					<p>
						<?php echo $account->getError(Constants::$usernameCharacters); ?>
						<?php echo $account->getError(Constants::$usernameTaken); ?>
						<label for="username">Username</label>
						<input id="username" name="username" type="text" value="<?php getInputValue('username') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$firstNameCharacters); ?>
						<label for="firstName">First name</label>
						<input id="firstName" name="firstName" type="text" value="<?php getInputValue('firstName') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$lastNameCharacters); ?>
						<label for="lastName">Last name</label>
						<input id="lastName" name="lastName" type="text" value="<?php getInputValue('lastName') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
						<?php echo $account->getError(Constants::$emailInvalid); ?>
						<?php echo $account->getError(Constants::$emailTaken); ?>
						<label for="email">Email</label>
						<input id="email" name="email" type="email" value="<?php getInputValue('email') ?>" required>
					</p>

					<p>
						<label for="email2">Confirm email</label>
						<input id="email2" name="email2" type="email" value="<?php getInputValue('email2') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$passwordsDoNoMatch); ?>
						<?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
						<?php echo $account->getError(Constants::$passwordCharacters); ?>
						<label for="password">Password</label>
						<input id="password" name="password" type="password" required>
					</p>

					<p>
						<label for="password2">Confirm password</label>
						<input id="password2" name="password2" type="password" required>
					</p>

					<button type="submit" name="registerButton">SIGN UP</button>

					<div class="hasAccount"> 
						<span id="hideRegister">Login Here.</span>
					</div>
					
				</form>


			</div>

			<div id="loginText">
				<h1>Sign up to listen to awesome music</h1>
				<h2>Listen to all your favorite music</h2>
				<ul>
					<li>Discover music all at your fingertips</li>
					<li>Keep up to date with your favorite artists</li>
					<li>Create your own playlists</li>
				</ul>
			</div>


		</div>
	</div>

</body>
</html>