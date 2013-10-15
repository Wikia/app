<div class="row">
	<ul class="small-block-grid-4 large-block-grid-5">
		<? foreach ( $assets as $videoData ): ?>
			<li>
				<?= $videoData[ 'videoThumb' ] ?>
			</li>
		<? endforeach; ?>
	</ul>
</div>
