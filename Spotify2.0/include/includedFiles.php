<?php

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	include("include/config.php");
	include("include/classes/User.php");
	include("include/classes/Artist.php");
	include("include/classes/Album.php");
	include("include/classes/Song.php");
	include("include/classes/Playlist.php");

	if(isset($_GET['userLoggedIn'])){
		$userLoggedIn = new User($con, $_GET['userLoggedIn']);
	}
	else{
		echo "username variable not passed";
		exit();
	}
}
else {
	include("include/header.php");
	include("include/footer.php");

	$url = $_SERVER['REQUEST_URI'];
	echo "<script>openPage('$url')</script>";
	exit();
}

?>