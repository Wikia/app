<? if ( $emptyPage ): ?>
	<?= wfMessage( 'noimages' ); ?>
<? else: ?>
	<?= $gallery->toHTML(); ?>
<? endif; ?>

<?php if ( !$noImages ): ?>
	<?= $pagination; ?>
<? endif ?>
