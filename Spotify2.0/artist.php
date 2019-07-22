<?php include("include/includedFiles.php");

	if(isset($_GET['id'])) {
		$artistId = $_GET['id'];
	}
	else{
		header("Location: index.php");
	}

	$artist = new Artist($con, $artistId);
?>


<div class="entityInfo borderBottom">

	<div class="centerSection">
		
		<div class="artistInfo">
			
			<h1 class="artistName"><?php echo $artist->getName(); ?></h1>

			<div class="headerButtons">

				<button class="button aqua" onclick="playFirstSong()">Play</button>
				
			</div>
		</div>
	</div>
</div>

<div class="trackListContainer borderBottom">
	<h2>Songs</h2>
	<ul class="trackList">

		<?php 

		$songIdArray = $artist->getSongId();

		$i = 1;

		foreach($songIdArray as $songId){

			if($i > 5){
				break;
			}

			$albumSong = new Song($con, $songId);
			$albumArtist = $albumSong->getArtist();

			echo "<li class='trackListRow'>

				<div class='trackCount'> 
					<img class='play' src='http://media.gettyimages.com/vectors/vector-play-button-icon-vector-id915608112?s=170x170&w=1007' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
					<span class='trackNumber'>$i</span>
				</div>

				<div class='trackInfo'>
					<span class='trackName'>" . $albumSong->getTitle() . "</span>
					<span class='artistName'>" . $albumArtist->getName() . "</span>
 				</div>

				<input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
 					<img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
 				</div>

 				<div class='trackDuration'>
 				 	<span class='duration'>" . $albumSong->getDuration() . "</span>
 				</div>


			</li>";

			$i = $i++;

		}	

		?>

		<script>
			
			var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
			tempPlaylist = JSON.parse(tempSongIds);

		</script>
		
	</ul>

</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist:: getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>

