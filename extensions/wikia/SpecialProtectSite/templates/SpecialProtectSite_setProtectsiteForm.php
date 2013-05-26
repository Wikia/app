<? echo wfMessage( 'protectsite-text-protect' )->text(); ?>
<form id="Protectsite" action="<?= $action ?>" method="post">
	<fieldset>
		<legend><? echo wfMessage( 'protectsite-title' )->text(); ?></legend>
		<? foreach ( $radios as $k => $v ) } ?>
		<fieldset>
			<legend><? echo wfMessage( 'protectsite-' . $k )->text(); ?></legend>
			<? foreach ( $v as $value => $checked ) { ?>
			<div>
				<label for="<?= $k ?>"><? echo wfMessage( 'protectsite-' . $k . '-' . $value )->text(); ?></label>
				<input type="radio" id="<?= $k ?>" value="<?= $value ?>" <? echo ( $checked ? 'checked="checked"' : '' ); ?> />
			</div>
			<? } ?>
		</fieldset>
		<? } ?>
		<div>
			<label for="timeout"><? echo wfMessage( 'protectsite-timeout' )->text() . $timelimitText; ?></label>
			<input type="text" id="timeout" value="<?= $default_timeout ?>" />
		</div>
		<div>
			<label for="comment"><? echo wfMessage( 'protectsite-comment' )->text(); ?></label>
			<input type="text" id="comment" value="<?= $comment ?>" />
		</div>
		<? if ( $noLogCheck ) { ?>
		<div>
			<label for="nolog"><? echo wfMessage( 'protectsite-hide-time-length' )->text() ?></label>
			<input type="checkbox" id="nolog" />
		</div>
		<? } ?> 
		<input type="submit" id="protect" value="<? echo wfMessage( 'protectsite-protect' )->text(); ?>" />
	</fieldset>
</form>
