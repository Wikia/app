<div class="WikiaHubsModal ArticleSuggestModal">
	<div class="form-view">
		<h1><?= wfMsg('wikiahubs-suggest-article-header') ?></h1>
		<?= F::app()->renderView( 'WikiaStyleGuideForm', 'index', array('form' => $formData) ); ?>
	</div>
	<div class="success-view">
		<p class="success-message"><?= $successMessage; ?></p>
		<div class="close-button">
			<button class="wikia-button close"><?= wfMessage('ok')->text(); ?></button>
		</div>
	</div>
</div>