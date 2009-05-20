var sf_initiated = false;

function sf_focus(e) {

	// Let's make sure that we are going only one time thru the initialize procedure
	if(!sf_initiated) {
		sf_initiated = true;

		// On blur - if the search field value is empty then recover it and remove field_active class
		$('#search_field').blur(function() {
			if($("#search_field").val() == '') {
				$("#search_field").val($("#search_field").attr('alt')).removeClass("field_active");
			}
		});

		$.getScript(stylepath+'/common/jquery/jquery.autocomplete.js', function() {
			$('#search_field').autocomplete({
				serviceUrl: wgServer+wgScript+'?action=ajax&rs=getLinkSuggest&format=json',
				fnFormatResult: function(v) { return v; },
				onSelect: function(v, d) { location.href = wgArticlePath.replace(/\$1/, encodeURI(v.replace(/ /g, '_'))); },
				selectedClass: 'navigation-hover',
				deferRequestBy: 1000
			});
		    $('body').children('div').slice(-1).css('zIndex', 20000);
		});
	}

	// On focus - if the search field value is same as default then clean it and add field_active class
	if($('#search_field').val() == $("#search_field").attr('alt')) {
		$('#search_field').val('').addClass('field_active');
	}

}
