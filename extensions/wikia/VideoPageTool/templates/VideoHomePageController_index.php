<?= $app->renderPartial(
	'VideoHomePageController',
	'header'
); ?>

<? if ( $haveProgram ): ?>
	<?= $featuredContent ?>
	<?= $categoryContent ?>
<? endif; ?>
