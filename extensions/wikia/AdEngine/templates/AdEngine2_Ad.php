<?php if ($showAd): ?>
	<!-- BEGIN SLOTNAME: <?= htmlspecialchars( $slotName ) ?> -->
	<div id="<?= htmlspecialchars( $slotName ) ?>" class="wikia-ad noprint default-height">
	<? if ($includeLabel): ?>
		<label class="wikia-ad-label"><?= wfMessage( 'adengine-advertisement' )->escaped() ?></label>
	<? endif; ?>
	<? if ($addToAdQueue): ?>
		<script>
			<? if ($onLoad) { ?>
				wgAfterContentAndJS.push(function () {
					window.adslots2.push(<?= json_encode([$slotName]) ?>);
				});
			<? } else { ?>
				window.adslots2.push(<?= json_encode([$slotName]) ?>);
			<? } ?>
		</script>
	<? endif; ?>
	</div>
	<!-- END SLOTNAME: <?= htmlspecialchars($slotName) ?> -->
<?php else: ?>
<!-- NO AD <?= htmlspecialchars($slotName) ?> (levels: <?= htmlspecialchars(json_encode($pageTypes)) ?>) -->
<?php endif; ?>
