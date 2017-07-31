<div class="featured-video-wrapper">
	<div id="article-video" class="article-video">
		<img class="video-thumbnail"
			 src="<?= Sanitizer::encodeAttribute( $videoDetails['thumbnailUrl'] ); ?>">
		<div class="video-container">
			<video id="myPlayerID"
				   data-embed="default"
				   data-application-id
				   class="video-js"
				   autoplay
				   muted
				   controls></video>
			<div class="video-details">
				<div class="video-label"><?= wfMessage( 'articlevideo-watch' )->escaped() ?>
					<span class="video-time"><?= $videoDetails['duration'] ?></span>
				</div>
				<div class="video-title"><?= htmlspecialchars( $videoDetails['title'] ) ?></div>
				<?= $app->renderPartial( 'ArticleVideo', 'attribution', [ 'videoDetails' => $videoDetails ] ) ?>
			</div>
			<?= $app->renderPartial( 'ArticleVideo', 'feedback' ) ?>
		</div>
	</div>
	<?= $app->renderPartial( 'ArticleVideo', 'attribution', [ 'videoDetails' => $videoDetails ] ) ?>
</div>




<script>
	old = define;
	define = null;
</script>
<script src="//players.brightcove.net/5519514651001/Bys4vXDLb_default/index.min.js" id="myScript"></script>

<script>define = old;


	myPlayerID.setAttribute('data-account', 5519514651001);
	myPlayerID.setAttribute('data-player', 'Bys4vXDLb');
	myPlayerID.setAttribute('data-video-id', 5522176571001);
	window.bc(document.getElementById("myPlayerID"));
	myPlayer = videojs("myPlayerID");

	myPlayer.on('loadedmetadata',function(){
		myPlayer.play();
	});

	videojs('vjs_video_3_html5_api').ready(function() {
		var myPlayer = this;

		myPlayer.on('play', function () {
			console.log('play')
		});

		myPlayer.on('pause', function () {
			console.log('pause')
		});
	})

</script>
<style>
	.video-js {
		width: 100%;
		height: 500px;
	}
</style>
