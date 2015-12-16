<? if ( $emptyPage ): ?>
	<?= wfMessage( 'noimages' ); ?>
<? else: ?>
	<?= $gallery->toHTML(); ?>
<? endif; ?>

<?php if ( $showUi && !$noImages ): ?>
	<?= $pagination; ?>
<? endif ?>
