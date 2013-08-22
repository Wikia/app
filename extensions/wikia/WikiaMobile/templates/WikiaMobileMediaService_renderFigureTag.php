<?
/**
 * @var $class String
 * @var $content String
 * @var $caption String
 * @var $showRibbon Bool
 */
?>
<figure<? if ( !empty( $class ) ) :?> class="<?= $class; ?>"<? endif ;?>><?
	echo $content;
	?><? if ( $caption !== null && !$isSmall ) {
		?><figcaption class=thumbcaption><?= $caption ;?></figcaption><?
	}
?></figure>