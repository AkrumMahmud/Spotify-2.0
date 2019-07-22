<?php

include("include/config.php");
include("include/classes/Artist.php");
include("include/classes/Album.php");
include("include/classes/Song.php");

if(isset($_SESSION['userLoggedIn'])){
	$userLoggedIn = $_SESSION['userLoggedIn'];
	echo "<script>userLoggedIn = '$userLoggedIn';</script>";
}
else{
	header("Location: register.php");
}


?>

<html>
<head>
	<title>Spotify2.0</title>

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="assets/js/script.js"></script>
</head>

<body>



	<script>

	</script>

	<div id="mainContainer">

		<div id="topContainer">
			
		<?php include("include/navBarContainer.php"); ?>


		<div id="mainViewContainer">
			
			<div id="mainContent">