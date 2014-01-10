<?
/**
 * @var $haveProgram bool
 * @var $featuredContent array
 * @var $categoryContent array
 */
?>

<?= $app->renderPartial(
	'VideoHomePageController',
	'header'
); ?>

<? if ( $haveProgram ): ?>
	<?= $featuredContent ?>
	<?= $categoryContent ?>
<? endif; ?>
