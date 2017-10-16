<div >
	<?= wfMessage( 'createpage-ve-body' )->rawParams( htmlspecialchars( $article, ENT_QUOTES ) )->parse() ?>
	<input id="wpCreatePageDialogTitle" value="<?= Sanitizer::encodeAttribute( $article ) ?>" type="text" style="display: none" />
</div>
