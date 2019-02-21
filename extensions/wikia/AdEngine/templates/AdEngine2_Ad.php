<?php
	$slotId = AdEngine3::isEnabled() ? strtolower( $slotName ) : $slotName;
?>

<?php if ($showAd): ?>
	<?php // For Ad Mix experiment - XW-3156 ?>
	<?php // Let's keep 'top-right-boxad-wrapper' id because of custom wiki scripts ?>
	<?php if ( $slotName === 'TOP_BOXAD' ): ?>
		<div id="top-right-boxad-wrapper">
	<?php endif; ?>
	<!-- BEGIN SLOTNAME: <?= htmlspecialchars( $slotId ) ?> -->
	<div id="<?= htmlspecialchars( $slotId ) ?>" class="wikia-ad noprint default-height">
	<? if ($includeLabel): ?>
		<label class="wikia-ad-label"><?= wfMessage( 'adengine-advertisement' )->escaped() ?></label>
	<? endif; ?>
	<? if ($addToAdQueue): ?>
		<script>
			<? if ($onLoad) { ?>
				wgAfterContentAndJS.push(function () {
					window.adslots2.push(<?= json_encode([ $slotId ]) ?>);
				});
			<? } else { ?>
				window.adslots2.push(<?= json_encode([ $slotId ]) ?>);
			<? } ?>
		</script>
	<? endif; ?>
	</div>
	<!-- END SLOTNAME: <?= htmlspecialchars( $slotId ) ?> -->
	<?php if ( $slotName === 'TOP_BOXAD' ): ?>
		</div>
	<?php endif; ?>
<?php else: ?>
<!-- NO AD <?= htmlspecialchars( $slotId ) ?> (levels: <?= htmlspecialchars(json_encode($pageTypes)) ?>) -->
<?php endif; ?>
