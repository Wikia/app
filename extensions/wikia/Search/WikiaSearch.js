jQuery(function( $ ) {
	$('form#powersearch input[name=title]').val('Special:WikiaSearch');

	var hiddenInputs = $('input.default-tab-value');
	$('section.AdvancedSearch input[type="checkbox"]').change(function() {
		hiddenInputs.remove();
	});
});