<div id="mixed-content-footer" data-number-of-wiki-articles="<?= $numberOfWikiArticles ?>" data-number-of-ns-articles="<?= $numberOfNSArticles ?>">
	<h1 class="mcf-header"><?= wfMessage('recirculation-impact-footer-title')->escaped() ?></h1>
	<div class="mcf-row">
		<?= F::app()->renderPartial( 'Recirculation', 'wikiArticles', [
			'recirculationArticlesMore' => wfMessage( 'recirculation-articles-more' )
				->params( $sitename )
				->escaped(),
			'communityHeaderBackground' => $communityHeaderBackground,
			'wikiArticles' => $topWikiArticles,
		] ); ?>
		<div class="mcf-card-ns-placeholder"></div>
		<div class="mcf-card-wiki-placeholder"></div>
	</div>
	<div class="mcf-row">
		<div class="mcf-discussions-placeholder"></div>
		<div class="mcf-col">
			<div class="mcf-row">
				<div class="mcf-card-ns-placeholder"></div>
				<div class="mcf-card-wiki-placeholder"></div>
			</div>
			<div class="mcf-row">
				<div class="mcf-card-ns-placeholder"></div>
				<div class="mcf-card-wiki-placeholder"></div>
			</div>
		</div>
	</div>
	<div class="mcf-row">
		<div class="mcf-card-ns-placeholder"></div>
		<div class="mcf-card-wiki-placeholder"></div>
		<div class="mcf-card-ns-placeholder"></div>
	</div>
	<div class="mcf-row">
		<div class="mcf-card-wiki-placeholder"></div>
		<div class="mcf-card-ns-placeholder"></div>
		<div class="mcf-card-wiki-placeholder"></div>
	</div>
	<div class="mcf-row">
		<div class="mcf-card-ns-placeholder"></div>
		<div class="mcf-card-wiki-placeholder"></div>
		<div class="mcf-card-ns-placeholder"></div>
	</div>
	<div class="mcf-row">
		<div class="mcf-card-wiki-placeholder"></div>
		<?= F::app()->renderPartial('Recirculation', 'exploreWikis', [ 'recirculationExploreWikis' => wfMessage( 'recirculation-explore-wikis' )->escaped() ]); ?>
		<div class="mcf-card-ns-placeholder"></div>
	</div>
</div>
