<?php $slotId = strtolower( $slotName ); ?>

<?php if ($showAd): ?>
	<!-- BEGIN CONTAINER: <?= htmlspecialchars( $slotId ) ?> -->
	<div id="<?= htmlspecialchars( $slotId ) ?>">
		<script>
            window.adslots2.push(<?= json_encode([$slotId]) ?>);
		</script>
	</div>
	<!-- END CONTAINER: <?= htmlspecialchars($slotId) ?> -->
<?php else: ?>
	<!-- NO CONTAINER <?= htmlspecialchars($slotId) ?> (levels: <?= htmlspecialchars(json_encode($pageTypes)) ?>) -->
<?php endif; ?>
