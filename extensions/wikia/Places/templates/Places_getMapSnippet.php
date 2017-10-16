<a href="<?= Sanitizer::encodeAttribute( $url ); ?>" class="placesBoldLink">
<?php if( !empty( $imgUrl ) ) { ?>
	<img src="<?= Sanitizer::encodeAttribute( $imgUrl ); ?>" width="100" height="100">
<?php } ?>
<?= $title ?>
</a><p class="placesBelowLinkText"><?=htmlspecialchars($textSnippet)?></p>
