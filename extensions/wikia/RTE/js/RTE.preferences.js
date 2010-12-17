$(function() {
	var toggle = $('input[name="wpenablerichtext"]');

	function RTETogglePreferences() {
		var RTEEnabled = toggle.attr('checked');

		var fields = ['editwidth', 'showtoolbar', 'previewonfirst', 'previewontop', 'disableeditingtips', 'disablelinksuggest', 'externaleditor', 'externaldiff', 'disablecategoryselect'];

		$(fields).each(function(i, id) {
			var checkboxRow = $('input[name="wp' + id + '"]').closest('tr');

			if (RTEEnabled) {
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
