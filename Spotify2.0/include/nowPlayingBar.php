<?php

$songQuery = mysqli_query($con, "SELECT id FROM Songs ORDER BY RAND() LIMIT 10");

$resultArray = array();

while($row = mysqli_fetch_array($songQuery)){
	array_push($resultArray, $row['id']);
}

$jsonArray = json_encode($resultArray);

?>

<script>

	$(document).ready(function() {
		var newPLaylist = <?php echo $jsonArray; ?>;
		audioElement = new Audio();
		setTrack(newPLaylist[0], newPLaylist, false);
		updateVolumeProgressBar(audioElement.audio);

		$("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
			e.preventDefault();
		});

		$(".playbackBar .progressBar").mousedown(function(){
			mouseDown = true;
		});

		$(".playbackBar .progressBar").mousemove(function(e){
			if(mouseDown){
				timeFromOffset(e, this);
			}
		});

		$(".playbackBar .progressBar").mouseup(function(e){
			timeFromOffset(e, this);
		});

		$(".volumeBar .progressBar").mousedown(function(){
			mouseDown = true;
		});

		$(".volumeBar .progressBar").mousemove(function(e){
			if(mouseDown){

				var percentage = e.offsetX / $(this).width();

				if(percentage >= 0 && percentage <= 1){
					audioElement.audio.volume = percentage;
				}
			}			
		});

		$(".volumeBar .progressBar").mouseup(function(e){
			var percentage = e.offsetX / $(this).width();

				if(percentage >= 0 && percentage <= 1){
					audioElement.audio.volume = percentage;
				}
		});


		$(document).mouseup(function(){
			mouseDown = false;
		});

	});

	function timeFromOffset(mouse, progressBar){
		var percentage = mouse.offsetX / $(progressBar).width() * 100;
		var seconds = audioElement.audio.duration * (percentage / 100);
		audioElement.setTime(seconds);
	}

	function previousSong(){
		if(audioElement.audio.currentTime >= 3 || currentIndex == 0){
				audioElement.setTime(0);
		}
		else{
			currentIndex--;
			setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
		}
	}

	function nextSong(){
		if(repeat == true){
			audioElement.setTime(0);
			playSong();
			return;
		}
		if(currentIndex == currentPlaylist.length - 1){
			currentIndex = 0;
		}
		else{
			currentIndex++;
		}

		var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
		setTrack(trackToPlay, currentPlaylist, true);
	}

	function setRepeat(){
		repeat = !repeat;

		var imageName = repeat ? "repeatactive.png" : "repeat.png";
		$(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
	}

	function setMute(){
		audioElement.audio.muted = !audioElement.audio.muted;

		var imageName = audioElement.audio.muted ? "mute.png" : "volume.png";
		$(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
	}

	function setShuffle(){
		shuffle = !shuffle;

		var imageName = shuffle ? "shufflecolor.png" : "shuffle.png";
		$(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

		if(shuffle == true){
			shuffleArray(shufflePlaylist);
			currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
		}
		else{
			currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);

		}

	}

	function shuffleArray(a) {
    var j, x, i;
    for (i = a.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = a[i];
        a[i] = a[j];
        a[j] = x;
    }
    return a;
}

	function setTrack(trackId, newPLaylist, play){

		if(newPLaylist != currentPlaylist){
			currentPlaylist = newPLaylist;
			shufflePlaylist = currentPlaylist.slice();

			shuffleArray(shufflePlaylist);
		}

		if(shuffle == true){
			currentIndex = currentPlaylist.indexOf(trackId);
		}
		else{
			currentIndex = shufflePlaylist.indexOf(trackId);
		}
		
		pauseSong();

		$.post("include/handler/ajax/getSongJSON.php", { songId: trackId }, function(data){

			var track = JSON.parse(data);

			$(".trackName span").text(track.title);

			$.post("include/handler/ajax/getArtistJSON.php", { artistId: track.artist }, function(data){

				var artist = JSON.parse(data);

				$(".trackInfo .artistName span").text(artist.name);

				$(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");

			});

			$.post("include/handler/ajax/getAlbumJSON.php", { albumId: track.album }, function(data){

				var album = JSON.parse(data);

				$(".content .albumLink img").attr("src", album.artworkPath);

				$(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
				$(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + album.id + "')");
			});


		audioElement.setTrack(track);

			if(play) {
				playSong();			}

		});

	}

		function playSong() {

			if(audioElement.audio.currentTime == 0) {
				$.post("include/handler/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
			}


			$(".controlButton.play").hide();
			$(".controlButton.pause").show();
			audioElement.play();
		}

		function pauseSong() {
			$(".controlButton.play").show();
			$(".controlButton.pause").hide();
			audioElement.pause();
		}


</script>

<div id="nowPlayingBarContainer">

<div id="nowPlayingBar">

	<div id="nowPlayingLeft">
		<div class="content">
			<span class="albumLink">
				<img role="link" tabindex="0" src="" class="albumArtwork">
			</span>

			<div class="trackInfo">

				<span class="trackName">
					<span role="link" tabindex="0"></span>
				</span>

				<span class="artistName">
					<span role="link" tabindex="0"></span>
				</span>

			</div>



		</div>
	</div>

	<div id="nowPlayingCenter">

		<div class="content playerControls">

			<div class="buttons">
				
				<button class="controlButton shuffle" title="Shuffle Button" onclick="setShuffle()">
					<img src="https://image.freepik.com/free-icon/shuffle-arrows-hand-drawn-symbol_318-51974.jpg" alt="Shuffle">
				</button>

				<button class="controlButton previous" title="Previous Button" onclick="previousSong()">
					<img src="https://image.freepik.com/icones-gratis/rebobinar-3_318-10730.jpg" alt="Previous">
				</button>
										
				<button class="controlButton play" title="Play Button" onclick="playSong()">
					<img src="https://image.freepik.com/free-icon/play-button_318-42541.jpg" alt="Play">
				</button>

				<button class="controlButton pause" title="Pause Button" style="display: none;" onclick="pauseSong()">
					<img src="https://image.freepik.com/iconen-gratis/video-pauzeknop_318-33989.jpg" alt="Pause">
				</button>
										
				<button class="controlButton next" title="Next Button" onclick="nextSong()">
					<img src="https://image.freepik.com/free-icon/next-button_318-42554.jpg" alt="Previous">			
				</button>
										
				<button class="controlButton repeat" title="Repeat Button" onclick="setRepeat()">
					<img src="https://www.pazzles.net/wordpress/wp-content/uploads/Repeat.jpg" alt="Repeat">
				</button>

			</div>

			<div class="playbackBar">

				<span class="progressTime current">0.00</span>

				<div class="progressBar">
					<div class="progressBarBg">
						<div class="progress"></div>
					</div>
				</div>

				<span class="progressTime remaining">0.00</span>


			</div>


		</div>


	</div>

	<div id="nowPlayingRight">
		<div class="volumeBar">

			<button class="controlButton volume" title="Volume Button" onclick="setMute()">
				<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSZ5XqXJuSZU3yKxx3nW3K6ot_4d3q5-yZOZIo8C5uWVFnPeEed" alt="Volume">
			</button>

			<div class="progressBar">
				<div class="progressBarBg">
					<div class="progress"></div>
				</div>
			</div>

		</div>
	</div>

</div>

</div>