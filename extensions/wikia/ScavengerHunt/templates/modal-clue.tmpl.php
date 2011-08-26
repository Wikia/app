<?php $hasSprite = ( !empty( $imgSprite['X'] ) || !empty( $imgSprite['X1'] ) || !empty( $imgSprite['X2'] )
	|| !empty( $imgSprite['Y'] ) || !empty( $imgSprite['Y1'] ) || !empty( $imgSprite['Y2'] ) ); ?>

<div class="scavenger-clue-text">
	<?= $text ?>
</div>
<?php if (!empty($buttonTarget)) { ?>
<div class="scavenger-clue-button">
	<a class="button" href="<?= $buttonTarget ?>"><?= $buttonText ?></a>
</div>
<?php }
if (!empty($shareUrl)) {
?>
<div class="scavenger-share-button">
	<fb:like layout="button_count" width="50" colorscheme="light" ref="content_page" href="<?= $shareUrl ?>" class=" fb_edge_widget_with_comment fb_iframe_widget"></fb:like>
</div>
<?php }
if ( $hasSprite ) { ?>
	<div id="scavenger-ingame-image"
	     class="scavenger-ingame-image"
	     style="background-image: url('<?= $imageSrc ?>');
			cursor: default;
			left: <?= $imgSprite['X'] ?>px;
			top: <?= $imgSprite['Y'] ?>px;
			width: <?= $imgSprite['X2'] - $imgSprite['X1'] ?>px;
			height: <?= $imgSprite['Y2'] - $imgSprite['Y1'] ?>px;
			z-index: 1001;
			background-position: <?= -$imgSprite['X1'] ?>px <?= -$imgSprite['Y1'] ?>px;"></div>
<?php } ?>