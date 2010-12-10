<form id="cancelBA" method="post" action="<?php echo $action; ?>">
<input name="wpToken" type="hidden" value="<?php echo $token; ?>" />
<input class="wikia-button" type="submit" name="wpSubmit" value="<?php echo wfMsgHtml( 'adss-button-cancel' ); ?>" />
</form>

<script type="text/javascript">/*<![CDATA[*/
var AdSS_cancel_confirmed = false;
$("#cancelBA").submit(function(e) {
	if( !AdSS_cancel_confirmed ) {
		$.confirm( {
			content:'<?php echo wfMsgHtml('adss-cancel-billing-agreement-confirmation'); ?>',
			width:400,
			okMsg:'<?php echo wfMsgHtml('adss-button-yes'); ?>',
			cancelMsg:'<?php echo wfMsgHtml('adss-button-no'); ?>',
			onOk:function() {
				AdSS_cancel_confirmed = true;
				$("#cancelBA").submit();
			}
		});
	}
	return AdSS_cancel_confirmed;
});
/*]]>*/
</script>
