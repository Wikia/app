<?php echo $filterForm; ?>
<?php echo $adList; ?>
<?php echo $navigationBar; ?>

<script type="text/javascript">/*<![CDATA[*/
var token = <?php echo Xml::encodeJsVar( $token ); ?>;

$("a.accept").click( function(e) {
	e.preventDefault();
	var id = $(this).parent().attr("id");
	$.confirm( {content:'Are you sure you want to accept this ad?', width:300, onOk:function() {
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
	} } );
} );

$("a.edit").click( function(e) {
	e.preventDefault();
	var id = $(this).parent().attr("id");
	$.getJSON( wgScript, {
		'action': 'ajax',
		'rs': 'AdSS_AdminController::getAdAjax',
		'rsargs[0]': id,
		}, function( response ) {
			var json = response.ad;
			var dialog = $($(".ad-edit-form").clone().show()).makeModal({persistent: false, width:600});
			var dataTable = dialog.find(".data-table tbody");
			var url = dialog.find("input[name='url']");
			var text = dialog.find("input[name='text']");
			var desc = dialog.find("input[name='desc']");
			url.val(json["url"]);
			text.val(json["text"]);
			desc.val(json["desc"]);
			for (var key in json) {
				//dataTable.append("<tr><td>" + key + "</td><td>" + json[key] + "</td></tr>");
			}
			
			dialog.find(".save").click(function(evt){
				$.post(wgScript, {
					'action': 'ajax',
					'rs': 'AdSS_AdminController::editAdAjax',
					rsargs: [json["id"], url.val(), text.val(), desc.val()]
				}, function(res) {
					if(res && res.result == "success") {
						$("#" + id).closest("td").siblings(".TablePager_col_ad_text").html(
							'<a href="' + url.val() + '">' + text.val() + '</a><br>' + desc.val()
						);
						dialog.closeModal();
					} else {
						// error out
					}
				});
			});
			dialog.find(".cancel").click(function(evt){
				dialog.closeModal();
			});
		}
	);
} );

$("a.close").click( function(e) {
	e.preventDefault();
	var id = $(this).parent().attr("id");
	$.confirm( {content:'Are you sure you want to delete this ad?', width:300, onOk:function() {
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
	} } );
} );

</script>

<div class="ad-edit-form">
	<h1>Edit Ad</h1>
	<table class="data-table">
		<tbody>
		</tbody>
	</table>
	<label for="url">URL</label>
	<input name="url" type="text" value="">
	<label for="text">Link Text:</label>
	<input name="text" type="text" value="">
	<label for="desc">Description Text:</label>
	<input name="desc" type="text" value="">
	<div class="buttons">
		<input type="button" value="Save" class="save">
		<input type="button" value="Cancel" class="cancel">
	</div>
</div>