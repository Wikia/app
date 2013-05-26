<form id="unProtectsite" action="<?= $action ?>" method="post">
	<fieldset>
		<legend><? echo wfMessage( 'protectsite-' . $title )->text(); ?></legend>
		<? foreach ( $restrictions as $k => $v ) { ?>
		<h3><? echo wfMessage( 'protectsite-' . $k )->text() ?>
		<span style="font-style: italic; color: <?= ( ( $v > 0 ) ? 'red' : 'green' ) ?>"><? echo wfMessage( 'protectsite-' . $k . '-' . $v )->text(); ?></span></h3><br />
		<? } ?>
		<h3><? echo wfMessage( 'protectsite-timeout' )->text(); ?></h3>
		<p style="font-style: italic;"><? echo $lang->timeAndDate( wfTimestamp( TS_MW, $until ), true ) ?></p>
		<? if ( $comment != '' ) { ?>
		<h3><? echo wfMessage( 'protectsite-comment' )->text(); ?></h3>
		<p style="font-style: italic;"><?= $comment ?></p>
		<? } ?>
		<div>
			<label for="ucomment"><? echo wfMessage( 'protectsite-ucomment' )->text(); ?></label>
			<input type="text" id="ucomment" value="" />
		</div>
		<input type="submit" id="unprotect" value="<? echo wfMessage( 'protectsite-unprotect' )->text(); ?>" />
	</fieldset>
</form>
