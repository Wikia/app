Publish date: <?= $curProgram->getPublishDate() ?>

<? if ( $haveCurrentProgram ): ?>
	<?= $featuredContent ?>

	<?= $categoryContent ?>

	<?= $fanContent ?>

	<?= $popularContent ?>
<? else: ?>
	<h1>No current program</h1>
<? endif; ?>