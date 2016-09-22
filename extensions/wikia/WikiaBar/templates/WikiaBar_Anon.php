<div class="ad">
	<?= $app->renderView( 'Ad', 'Index', [ 'slotName' => 'WIKIA_BAR_BOXAD_1' ] ); ?>
</div>
<div
	class="message<?if ( empty( $status ) ): ?> failsafe<? endif; ?>"
	data-messagetooltip="<?= wfMessage('wikiabar-message-tooltip' )->escaped(); ?>"
	data-wikiabarcontent="<?= htmlentities( json_encode( $barContents['messages'] ), ENT_QUOTES ); ?>"
></div>
<? foreach ( $barContents['buttons'] as $idx => $button ): ?>
	<a class="wikiabar-button" href="<?= $button['href'] ?>" data-index="<?= $idx; ?>">
		<img src="<?= $button['image_url'] ?>" class="icon <?= $button['class'] ?>" />
		<span><?= $button['text'] ?></span>
	</a>
<? endforeach; ?>
