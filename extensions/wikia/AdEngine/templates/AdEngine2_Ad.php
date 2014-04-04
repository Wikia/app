<?php if ($showAd): ?>
<!-- BEGIN SLOTNAME: <?= htmlspecialchars($slotname) ?> -->
<div id="<?= htmlspecialchars($slotname) ?>" class="wikia-ad noprint default-height">
<script>
	window.adslots2.push(<?= json_encode([$slotname, null, 'AdEngine2']) ?>);
</script>
</div>
<!-- END SLOTNAME: <?= htmlspecialchars($slotname) ?> -->
<?php else: ?>
<!-- NO AD <?= htmlspecialchars($slotname) ?> -->
<?php endif; ?>
