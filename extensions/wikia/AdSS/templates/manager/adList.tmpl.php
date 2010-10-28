<fieldset class="panel">
<?php echo $filterForm; ?>
<?php echo $adList; ?>
<?php echo $navigationBar; ?>
</fieldset>

<script type="text/javascript">/*<![CDATA[*/
$("a.close").click( function(e) {
	e.preventDefault();
	if( confirm( 'Are you sure you want to delete this ad?' ) ) {
		var id = $(this).parent().attr("id");
		$.getJSON( wgScript, {
			'action': 'ajax',
			'rs': 'AdSS_ManagerController::closeAdAjax',
			'rsargs[0]': id
			}, function( response ) {
				if( response.result == "success" ) {
					var cur = $('span#'+response.id);
					cur.html(response.closed);
				} else {
					alert(response.respmsg);
				}
			}
		);
	}
} );

</script>

