<div class="WikiaHubsModal VideoSuggestModal">
	<h1><?= wfMsg('wikiahubs-suggest-video-header') ?></h1>
	<?= F::app()->renderView( 'WikiaStyleGuideForm', 'index', array('form' => $formData) ); ?>

	<div class="close-button">
		<button class="wikia-button close"><?= wfMsg( 'wikiahubs-button-close' ) ?></button>
	</div>
</div>