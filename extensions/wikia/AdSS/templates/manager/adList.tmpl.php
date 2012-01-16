<fieldset class="panel">
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
		$.post( wgScript,
			{
				'action': 'ajax',
				'rs': 'AdSS_ManagerController::closeAdAjax',
				'rsargs[0]': id
			},
			function( response ) {
				if( response.result == "success" ) {
					var cur = $('span#'+response.id);
					cur.closest("tr").remove();
				} else {
					alert(response.respmsg);
				}
			},
			"json"
		);
	} } );
} );

$("a.edit").click( function(e) {
	e.preventDefault();
	var id = $(this).parent().attr("id");
	$.post( wgScript,
		{
			'action': 'ajax',
			'rs': 'AdSS_ManagerController::getAdAjax',
			'rsargs[0]': id,
		},
		function( response ) {
			var json = response.ad;
			var dialog = $(".ad-edit-form").clone().show().makeModal({persistent: false, width:600});
			var url = dialog.find("input[name='url']");
			var text = dialog.find("input[name='text']");
			var desc = dialog.find("input[name='desc']");
			url.val(json["url"]);
			text.val(json["text"]);
			desc.val(json["desc"]);

			dialog.find(".save").click(function(evt){
				$.post(wgScript, {
					'action': 'ajax',
					'rs': 'AdSS_ManagerController::editAdAjax',
					rsargs: [json["id"], url.val(), text.val(), desc.val()]
				}, function(res) {
					if(res && res.result == "success") {
						var s = dialog.find(".step-2");
						s.find(".message").html(res.respmsg);
						dialog.find(".step-1").hide(400, function() {
							s.show(400);
						});
					} else {
						alert(res.respmsg);
					}
				});
			});
			dialog.find(".cancel, .ok").click(function(evt){
				dialog.closeModal();
			});
		},
		"json"
	);
} );


/*]]>*/
</script>

<div class="ad-edit-form" style="display:none">
	<h1>Edit Ad</h1>
	<div class="step-1">
		<table class="data-table">
			<tbody>
			</tbody>
		</table>
		<label for="url"><?php echo wfMsgHtml( 'adss-form-url' ); ?></label>
		<input name="url" type="text" value="">
		<label for="text"><?php echo wfMsgHtml( 'adss-form-linktext' ); ?></label>
		<input name="text" type="text" value="">
		<label for="desc"><?php echo wfMsgHtml( 'adss-form-additionaltext' ); ?></label>
		<input name="desc" type="text" value="">
		<div class="buttons">
			<input type="button" value="<?php echo wfMsgHtml( 'adss-button-save' ); ?>" class="save">
			<input type="button" value="<?php echo wfMsgHtml( 'adss-button-cancel' ); ?>" class="cancel">
		</div>
	</div>
	<div class="step-2">
		<div class="message">
		</div>
		<input type="button" value="Ok" class="ok">
	</div>
</div>
