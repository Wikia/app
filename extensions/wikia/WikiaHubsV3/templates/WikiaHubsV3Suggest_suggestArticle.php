<div class="WikiaHubsModal ArticleSuggestModal">
	<div class="form-view">
		<h1><?= wfMessage('wikiahubs-v3-suggest-article-header')->escaped() ?></h1>
		<?= F::app()->renderView( 'WikiaStyleGuideForm', 'index', array('form' => $formData) ); ?>
	</div>
	<div class="success-view">
		<p class="success-message"><?= $successMessage; ?></p>
		<div class="close-button">
			<button class="wikia-button close"><?= wfMessage('ok')->escaped(); ?></button>
		</div>
	</div>
</div>
