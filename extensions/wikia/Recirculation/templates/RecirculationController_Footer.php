<div id="mixed-content-footer">
	<h1 class="mcf-header"><?= wfMessage('recirculation-impact-footer-title')->escaped() ?></h1>
	<div class="mcf-row">
		<?= F::app()
			->renderPartial( 'Recirculation', 'wikiArticles',
				[ 'sitename' => $sitename->titleText->render() ] ); ?>
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
	</div>
	<div class="mcf-row">
		<div class="mcf-discussions-placeholder"></div>
		<div class="mcf-col">
			<div class="mcf-row">
				<?= F::app()->renderPartial('Recirculation', 'article'); ?>
				<?= F::app()->renderPartial('Recirculation', 'topic'); ?>
			</div>
			<div class="mcf-row">
				<?= F::app()->renderPartial('Recirculation', 'article'); ?>
				<?= F::app()->renderPartial('Recirculation', 'article'); ?>
			</div>
		</div>
	</div>
	<div class="mcf-row">
		<?= F::app()->renderPartial('Recirculation', 'storyStream'); ?>
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
	</div>
	<div class="mcf-row">
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
		<?= F::app()->renderPartial('Recirculation', 'storyStream'); ?>
	</div>
	<div class="mcf-row">
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
	</div>
	<div class="mcf-row">
		<?= F::app()->renderPartial('Recirculation', 'topic'); ?>
		<?= F::app()->renderPartial('Recirculation', 'exploreWikis'); ?>
		<?= F::app()->renderPartial('Recirculation', 'article'); ?>
	</div>
</div>
