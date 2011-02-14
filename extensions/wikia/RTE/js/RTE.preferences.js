$(function() {
	var toggle = $('input[name="wpenablerichtext"]');

	function RTETogglePreferences() {
		var RTEEnabled = !!toggle.attr('checked'),
			fieldsHide = ['editwidth', 'showtoolbar', 'previewonfirst', 'previewontop', 'disableeditingtips', 'disablelinksuggest', 'externaleditor', 'externaldiff', 'disablecategoryselect'],
			fieldsShow = ['disablespellchecker'];

		// hide certain fields when RTE is enabled
		$(fieldsHide).each(function(i, id) {
			var checkboxRow = $('input[name="wp' + id + '"]').closest('tr');

			if (RTEEnabled) {
				checkboxRow.hide();
			}
			else {
				checkboxRow.show();
			}
		});

		// show certain fields when RTE is enabled
		$(fieldsShow).each(function(i, id) {
			var checkboxRow = $('input[name="wp' + id + '"]').closest('tr');

			if (!RTEEnabled) {
				checkboxRow.hide();
			}
			else {
				checkboxRow.show();
			}
		});
	}

	$().log('setting up user preferences', 'RTE');

	toggle.click(RTETogglePreferences);

	RTETogglePreferences();
});
