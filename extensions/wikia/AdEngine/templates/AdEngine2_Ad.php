<?php if ($showAd): ?>
<!-- BEGIN SLOTNAME: <?= htmlspecialchars($slotName) ?> -->
<div id="<?= htmlspecialchars($slotName) ?>" class="wikia-ad noprint default-height">
<script>
	window.adslots2.push(<?= json_encode([$slotName]) ?>);
</script>
</div>
<!-- END SLOTNAME: <?= htmlspecialchars($slotName) ?> -->
<?php else: ?>
<!-- NO AD <?= htmlspecialchars($slotName) ?> (levels: <?= htmlspecialchars(json_encode($pageTypes)) ?>) -->
<?php endif; ?>
