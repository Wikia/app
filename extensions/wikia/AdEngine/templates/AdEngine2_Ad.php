<?php if ($showAd): ?>
<!-- BEGIN SLOTNAME: <?= htmlspecialchars( $slotName ) ?> -->
<div id="<?= htmlspecialchars( $slotName ) ?>" class="wikia-ad noprint default-height">
	<? if ($includeLabel): ?>
		<label class="wikia-ad-label"><?= htmlspecialchars( wfMessage( 'adengine-advertisement' )->text() ) ?></label>
	<? endif; ?>
<script>
	window.adslots2.push(<?= json_encode([$slotName]) ?>);
</script>
</div>
<!-- END SLOTNAME: <?= htmlspecialchars($slotName) ?> -->
<?php else: ?>
<!-- NO AD <?= htmlspecialchars($slotName) ?> (levels: <?= htmlspecialchars(json_encode($pageTypes)) ?>) -->
<?php endif; ?>
