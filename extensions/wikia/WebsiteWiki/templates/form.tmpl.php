<!-- s:<?= __FILE__ ?> -->
<?php
if( $error ):
	print Wikia::errorbox( $error );
endif;
?>
<form action="" method="get">
<fieldset>
	<legend><?php $this->msg( "newsite-form-legend" ); ?></legend>
	<?php $this->msg( "newsite-form-more-info" ); ?>
	<p>
		<strong><?php $this->msg( "newsite-form-label" ); ?></strong>
		<input type="text" name="param" size="40" maxlength="80" />
		<input type="submit" value="<?php $this->msg( "newsite-form-submit" ) ?>"  />
	</p>
</fieldset>
</form>

<!-- e:<?= __FILE__ ?> -->
