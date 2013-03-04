<div class="WikiaHubsModal ArticleSuggestModal">
	<h1><?= wfMsg('wikiahubs-suggest-article-header') ?></h1>

	<?= F::app()->renderView( 'WikiaStyleGuideForm', 'index', array('form' => $formData) ); ?>
	<p class="successMessage"><?= wfMessage('wikiahubs-suggest-article-success')->text(); ?></p>
</div>