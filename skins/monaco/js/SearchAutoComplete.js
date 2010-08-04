// onfocus handler for #search_field
function sf_focus(e) {

	// Let's make sure that we are going only one time thru the initialization procedure
	if(!window.sf_initiated) {
		window.sf_initiated = true;

		// onblur handler for #search_field  - if the search field value is empty then recover it to default and remove field_active class
		$('#search_field').blur(function() {
			if($("#search_field").val() == '') {
				$("#search_field").val($("#search_field").attr('alt')).removeClass("field_active");
			}
		});

		// download necessary dependencies (AutoComplete pluign) and initialize search suggest feature for #search_field
		$.getScript(stylepath+'/common/jquery/jquery.autocomplete.js', function() {
			a=$('#search_field').autocomplete({
				serviceUrl: wgServer+wgScript+'?action=ajax&rs=getLinkSuggest&format=json',
				fnFormatResult: function(v) {
					return v;
				},
				onSelect: function(v, d) {
					window.location.href = wgArticlePath.replace(/\$1/, encodeURIComponent(v.replace(/ /g, '_')));
				},
				selectedClass: 'navigation-hover',
				deferRequestBy: 1000,
				appendTo: '#search_box'
			});
		    $('body').children('div').slice(-1).css('zIndex', 20000);
		});
	}

	// if the search field value is same as a default then clean it and add field_active class
	if($('#search_field').val() == $("#search_field").attr('alt')) {
		$('#search_field').val('').addClass('field_active');
	}
}
