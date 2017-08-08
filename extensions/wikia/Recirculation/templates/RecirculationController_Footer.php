<div id="mixed-content-footer">
	<h1 class="mcf-header"><?= wfMessage('recirculation-impact-footer-title')->escaped() ?></h1>
	<div class="mcf-row">
		<?= F::app()->renderPartial( 'Recirculation', 'wikiArticles', [
				'recirculationArticlesMore' => wfMessage( 'recirculation-articles-more' )
					->params( $sitename )
					->escaped(),
				'communityHeaderBackground' => $communityHeaderBackground,
			] ); ?>
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
	</div>
	<div class="mcf-row">
		<div class="mcf-discussions-placeholder"></div>
		<div class="mcf-col">
			<div class="mcf-row">
				<?= F::app()->renderPartial('Recirculation', 'article'); ?>
				<?= F::app()->renderPartial('Recirculation', 'topic', [ 'recirculationExplore' => wfMessage( 'recirculation-explore' )->escaped() ] ); ?>
			</div>
			<div class="mcf-row">
				<?= F::app()->renderPartial('Recirculation', 'article'); ?>
				<?= F::app()->renderPartial('Recirculation', 'article'); ?>
			</div>
		</div>
	</div>
	<div class="mcf-row">
		<?= F::app()->renderPartial('Recirculation', 'storyStream', [ 'recirculationExplorePosts' => wfMessage( 'recirculation-explore-posts' )->escaped() ] ); ?>
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
	</div>
	<div class="mcf-row">
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
		<?= F::app()->renderPartial('Recirculation', 'storyStream', [ 'recirculationExplorePosts' => wfMessage( 'recirculation-explore-posts' )->escaped() ] ); ?>
	</div>
	<div class="mcf-row">
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
	</div>
	<div class="mcf-row">
		<?= F::app()->renderPartial('Recirculation', 'topic', [ 'recirculationExplore' => wfMessage( 'recirculation-explore' )->escaped() ] ); ?>
		<?= F::app()->renderPartial('Recirculation', 'exploreWikis', [ 'recirculationExploreWikis' => wfMessage( 'recirculation-explore-wikis' )->escaped() ]); ?>
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
	</div>
</div>
