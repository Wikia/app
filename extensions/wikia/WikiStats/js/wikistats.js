var sdomain = '';
function ws_focus(field, method) {
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
		sdomain = $('#' + textfield).val();
		$('#' + textfield).val('');
	} else {
		$('#' + textfield).val(sdomain);
	}
}

function ws_make_param() {
	var fmonth = $('#ws-month-from').val();
	var fyear = $('#ws-year-from').val();
	
	fmonth = ( fmonth < 10 ) ? '0' + fmonth : fmonth;

	var tmonth = $('#ws-month-to').val();
	var tyear = $('#ws-year-to').val();
	
	tmonth = ( tmonth < 10 ) ? '0' + tmonth : tmonth;
		
	var fdate = fyear + '' + fmonth;
	var tdate = tyear + '' + tmonth;
	
	$('#wsfrom').val(fdate);
	$('#wsto').val(tdate);
}
