<?php include("include/includedFiles.php") ?>

<div class="playlistsContainer">
	
	<div class="gridViewContainer">
		
		<h2>Playlists</h2>

		<div class="buttonItems">
			<button class="button aqua" onclick="createPlaylist()">New Playlist</button>
		</div>


		<?php
			$username = $userLoggedIn->getUsername();

			$playlistQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner='$username'");

			if(mysqli_num_rows($playlistQuery) == 0){
				echo "<span class='noResults'>No playlists found</span>";
			}

			while($row = mysqli_fetch_array($playlistQuery)) {

				$playlist = new Playlist($con, $row);

				echo "<div class='gridViewItem' role='link' tabindex='0' onclick='openPage(\"playlist.php?id=" . $playlist->getId() ."\")'>

						<div class='playlistImage'>
							<img src='https://cdn.dribbble.com/users/29051/screenshots/2515769/icon_1x.png'>
						</div>
						
						<div class='gridViewInfo'>"
							. $playlist->getName() .
						"</div>

					</div>";



			}
		?>

		</div>




	</div>


</div>