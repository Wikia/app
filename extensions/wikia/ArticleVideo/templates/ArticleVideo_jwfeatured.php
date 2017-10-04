<div class="featured-video">
	<div class="featured-video__player-container">
		<div id="featured-video__player" class="featured-video__player"></div>
	</div>
	<script src="//content.jwplatform.com/libraries/VXc5h4Tf.js"></script>
	<script>
		window.wgFeaturedVideoData = <?= json_encode($videoDetails); ?>;
	</script>
	<script src="<?= $jwplayerScript; ?>"></script>
</div>
