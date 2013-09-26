<?= $app->renderPartial(
	'VideoHomePageController',
	'header'
); ?>

<? if ( $haveProgram ): ?>
	<?= $featuredContent ?>

	<?= $categoryContent ?>

	<?= $fanContent ?>

	<?= $popularContent ?>
<? endif; ?>
