<!-- BEGIN SLOTNAME: <?= htmlspecialchars($slotname) ?> -->
<div id="<?= htmlspecialchars($slotname) ?>" class="wikia-ad noprint default-height">
	<script>
		window.adslots2.push(<?= json_encode([$slotname, null, 'AdEngine2']) ?>);
	</script>
</div>
<?php if(!empty($selfServeUrl)) { ?>
	<div class="SelfServeUrl">Advertisement | <a href="<?= $selfServeUrl?>">Your ad here</a></div>
<?php } ?>
<!-- END SLOTNAME: <?= htmlspecialchars($slotname) ?> -->
