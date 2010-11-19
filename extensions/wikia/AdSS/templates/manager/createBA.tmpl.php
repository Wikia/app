<form method="post" action="<?php echo $action; ?>">
<input name="wpToken" type="hidden" value="<?php echo $token; ?>" />
<input class="wikia-button" type="submit" name="wpSubmit" value="<?php echo wfMsgHtml( 'adss-create-billing-agreement' ); ?>" />
</form>
