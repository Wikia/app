<?= $app->renderPartial(
	'VideoHomePageController',
	'header'
); ?>

<? if ( $haveProgram ): ?>
	<?= $featuredContent ?>
<? endif; ?>
