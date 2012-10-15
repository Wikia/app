<a href="<?= htmlspecialchars($articleUrl) ?>" style=" font-size: 20px; font-weight:bold; }">
<?php if( !empty( $imgUrl ) ) { ?>
	<img src="<?= htmlspecialchars($imgUrl) ?>" width="100" height="100">
<?php } ?>
<?= $title ?>
</a><p class="placesBelowLinkText"><?=$textSnippet?></p>