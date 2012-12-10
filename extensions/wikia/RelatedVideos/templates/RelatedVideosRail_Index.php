<section class="RelatedVideosModule module">
	<? echo F::app()->renderView(
							'RelatedVideos',
							'getCaruselRL',
							array()
						);
	?>

	<? // temporary video survey code bugid-68723 ?>
	<?= $surveyLink ?>
</section>