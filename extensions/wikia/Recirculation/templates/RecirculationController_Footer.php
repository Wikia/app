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
		<div class="ns-article"></div>
		<div class="wiki-article"></div>
	</div>
	<div class="mcf-row">
		<div class="mcf-discussions-placeholder"></div>
		<div class="mcf-col">
			<div class="mcf-row">
				<div class="ns-article"></div>
				<?= F::app()->renderPartial('Recirculation', 'topic', [ 'recirculationExplore' => wfMessage( 'recirculation-explore' )->escaped() ] ); ?>
			</div>
			<div class="mcf-row">
				<div class="wiki-article"></div>
				<div class="ns-article"></div>
			</div>
		</div>
	</div>
	<div class="mcf-row">
		<?= F::app()->renderPartial('Recirculation', 'storyStream', [ 'recirculationExplorePosts' => wfMessage( 'recirculation-explore-posts' )->escaped() ] ); ?>
		<div class="wiki-article"></div>
		<div class="ns-article"></div>
	</div>
	<div class="mcf-row">
		<div class="wiki-article"></div>
		<div class="ns-article"></div>
		<?= F::app()->renderPartial('Recirculation', 'storyStream', [ 'recirculationExplorePosts' => wfMessage( 'recirculation-explore-posts' )->escaped() ] ); ?>
	</div>
	<div class="mcf-row">
		<div class="wiki-article"></div>
		<div class="ns-article"></div>
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
	</div>
	<div class="mcf-row">
		<?= F::app()->renderPartial('Recirculation', 'topic', [ 'recirculationExplore' => wfMessage( 'recirculation-explore' )->escaped() ] ); ?>
		<?= F::app()->renderPartial('Recirculation', 'exploreWikis', [ 'recirculationExploreWikis' => wfMessage( 'recirculation-explore-wikis' )->escaped() ]); ?>
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
	</div>
</div>
