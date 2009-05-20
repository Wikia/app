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
		    var a = $('#search_field').autocomplete({
		      width: 300,
		      lookup: 'January,February,March,April,May,June,July,August,September,October,November,December'.split(',')
		    });
		    $('body').children('div').slice(-1).css('zIndex', 20000);
		});
	}

	// On focus - if the search field value is same as default then clean it and add field_active class
	if($('#search_field').val() == $("#search_field").attr('alt')) {
		$('#search_field').val('').addClass('field_active');
	}

}
