<fieldset class="panel">
<p><a id="adssBuyAnother" class="wikia-button" href="<?php echo $buyUrl; ?>"><?php echo wfMsgHtml('adss-buy-another'); ?></a></p>
<?php echo $adList; ?>
</fieldset>

<script type="text/javascript">/*<![CDATA[*/
$("#adssBuyAnother").click(function() {
	$.tracker.byStr( "adss/manager/click/buyAnother" );
});

$("a.close").click( function(e) {
	e.preventDefault();
	var id = $(this).parent().attr("id");
	$.confirm( {content:'<?php echo wfMsg('adss-cancel-confirmation'); ?>', width:300, onOk:function() {
		$.getJSON( wgScript, {
			'action': 'ajax',
			'rs': 'AdSS_ManagerController::closeAdAjax',
			'rsargs[0]': id
			}, function( response ) {
				if( response.result == "success" ) {
					var cur = $('span#'+response.id);
					cur.closest("tr").remove();
				} else {
					alert(response.respmsg);
				}
			}
		);
	} } );
} );

</script>

