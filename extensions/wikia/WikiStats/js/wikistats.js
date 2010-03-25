function ws_focus(e, field, method) {
	if(!window.sf_initiated) {
		window.sf_initiated = true;

		$.getScript(stylepath+'/common/jquery/jquery.autocomplete.js', function() {
			$('#' + field).autocomplete({
				serviceUrl: wgServer+wgScript+'?action=ajax&rs=' + method,
				fnFormatResult: function(v) { return v; },
				minChars:3,
				deferRequestBy: 1000
			});
		});
	}
}

function ws_disable(e, checkbox, textfield) {
	var is_checked = $('#' + checkbox ).is(':checked');
	if ( is_checked ) {
		$('#' + textfield).val('');
	} 
}
