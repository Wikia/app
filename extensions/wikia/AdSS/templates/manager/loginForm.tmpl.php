<form method="post" action="<?php echo $action; ?>">
	<input name="wpToken" type="hidden" value="<?php echo $token; ?>" />

	<table>
	<tr>
	<td class="mw-label">
	<label for="wpEmail"><?php echo wfMsgHtml( 'adss-form-email' ); ?></label>
	</td>
	<td class="mw-input">
	<?php echo $form->error( 'wpEmail' ); ?>
	<input type="text" name="wpEmail" value="<?php $form->output( 'wpEmail' ); ?>" />
	</td>
	</tr>

	<tr>
	<td class="mw-label">
	<label for="wpPassword"><?php echo wfMsgHtml( 'adss-form-password' ); ?></label>
	</td>
	<td class="mw-input">
	<?php echo $form->error( 'wpPassword' ); ?>
	<input type="password" name="wpPassword" value="<?php $form->output( 'wpPassword' ); ?>" />
	</td>
	</tr>

	<tr>
	<td />
	<td class="mw-submit">
	<input class="wikia-button" type="submit" name="wpSubmit" value="<?php echo $submit; ?>" />
	</td>
	</tr>
	</table>
</form>
