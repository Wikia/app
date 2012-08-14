<figure<? if ( !empty( $class ) ) :?> class="<?= $class; ?>"<? endif ;?>><?
	echo $content;
	?><? if ( $caption !== null ) {
		?><figcaption class=thumbcaption><?= $caption ;?></figcaption><?
	}
?></figure>