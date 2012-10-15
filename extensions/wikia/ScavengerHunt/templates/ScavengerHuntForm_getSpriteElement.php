<? foreach ( $sprites as $sprite ) { ?>
<div class="scavengerhunt-editor-tips-sprite">
	<?= wfMsg( 'scavengerhunt-editor-tip-' . $sprite )?>
</div>
<div class="scavenger-half-dimension-box-wrapper">
	<label>
		<?= wfMsg('scavengerhunt-label-' . $sprite) ?>
	</label><br />
	<? $switch = 1;
	$source = ( !empty( $article ) && isset( $article[ $sprite ] ) )
		? $article[ $sprite ]
		: ScavengerHuntGameArticle::getSpriteTemplate();

	foreach ( $source as $key => $dimension ) {
		if ( $switch % 2 ){
		?>
			<div class="scavenger-half-dimension-box"><label><?= wfMsg('scavengerhunt-label-sprite-' . $key) ?>
		<? } ?>
			<input class="scavenger-image-offset <?=in_array( $sprite . $key . $sufix ,$highlight) ? ' sh-error' : '' ?>" type="text" name="<?= $sprite . $key . $sufix ?>" data-param="<?= $sprite ?>" data-dimension="<?= $key ?>" data-sufix="<?= empty($sufix) ?>" value="<?= $dimension ?>">
		<?
			if ( $switch % 2 ){ ?></label><? } else { ?></div><? }
			$switch++;
		?>
	<? } ?>
</div>
<? } ?>