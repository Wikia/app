<?php if ($showAd): ?>
	<!-- BEGIN CONTAINER: <?= htmlspecialchars( $slotName ) ?> -->
	<div id="<?= htmlspecialchars( $slotName ) ?>">
		<script>
			window.adslots2.push(<?= json_encode([$slotName]) ?>);
		</script>
	</div>
	<!-- END CONTAINER: <?= htmlspecialchars($slotName) ?> -->
<?php else: ?>
	<!-- NO CONTAINER <?= htmlspecialchars($slotName) ?> (levels: <?= htmlspecialchars(json_encode($pageTypes)) ?>) -->
<?php endif; ?>
