<div class="WikiaHubsModal ArticleSuggestModal">
	<h1><?= wfMsg('wikiahubs-suggest-article-header') ?></h1>

	<?= F::app()->renderView( 'WikiaStyleGuideForm', 'index', array('form' => $formData) ); ?>
	<p class="successMessage"></p>
	<div class="close-button">
		<button class="wikia-button close"><?= wfMessage('ok')->text(); ?></button>
	</div>
</div>