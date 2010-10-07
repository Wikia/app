<?php echo $adList; ?>
<?php echo $navigationBar; ?>

<script type="text/javascript">/*<![CDATA[*/
var token = <?php echo Xml::encodeJsVar( $token ); ?>;

$("a.accept").click( function() {
	if( confirm( 'Are you sure you want to accept this ad?' ) ) {
		var id = $(this).parent().attr("id");
		$.getJSON( wgScript, {
			'action': 'ajax',
			'rs': 'AdSS_AdminController::acceptAdAjax',
			'rsargs[0]': id,
			'rsargs[1]': token
			}, function( response ) {
				if( response.result == "success" ) {
					var cur = $('span#'+response.id);
					cur.closest('tr').find('td.TablePager_col_ad_expires').html(response.expires);
					cur.html( cur.find('a.close') );
				} else {
					alert(response.respmsg);
				}
			}
		);
	}
} );

$("a.close").click( function() {
	if( confirm( 'Are you sure you want to delete this ad?' ) ) {
		var id = $(this).parent().attr("id");
		$.getJSON( wgScript, {
			'action': 'ajax',
			'rs': 'AdSS_AdminController::closeAdAjax',
			'rsargs[0]': id,
			'rsargs[1]': token
			}, function( response ) {
				if( response.result == "success" ) {
					var cur = $('span#'+response.id);
					cur.closest("tr").remove();
				} else {
					alert(response.respmsg);
				}
			}
		);
	}
} );

</script>

