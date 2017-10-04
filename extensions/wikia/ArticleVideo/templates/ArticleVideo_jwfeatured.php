<div class="featured-video-wrapper">
	<div id="article-video" class="article-video">
		<div id="featured-video-player" class="featured-video-player"></div>
		<script src="//content.jwplatform.com/libraries/TAUVjJL5.js"></script>
		<script>
			window.wgFeaturedVideoData = <?= json_encode($videoDetails); ?>;
		</script>
		<script src="<?= $jwplayerScript; ?>"></script>
	</div>
</div>
