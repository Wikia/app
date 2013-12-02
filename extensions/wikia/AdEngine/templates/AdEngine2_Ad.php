<?php if ($showAd) { ?>

<!-- BEGIN SLOTNAME: <?= htmlspecialchars($slotname) ?> -->

<?php if(!empty($selfServeUrl)) { ?>
	<div class="wikia-ad noprint">
<?php } ?>

<div id="<?= htmlspecialchars($slotname) ?>" class="<?php if(empty($selfServeUrl)): ?>wikia-ad noprint <?php endif ?>default-height">
	<script>
		window.adslots2.push(<?= json_encode([$slotname, null, 'AdEngine2']) ?>);
	</script>
</div>
<?php if(!empty($selfServeUrl)) { ?>
	<div class="SelfServeUrl">Advertisement | <a href="<?= htmlspecialchars($selfServeUrl) ?>">Your ad here</a></div>
	</div>
<?php } ?>
<!-- END SLOTNAME: <?= htmlspecialchars($slotname) ?> -->

<?php } ?>
