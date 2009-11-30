$(function() {
	function RTETogglePreferences() {
		var RTEEnabled = $('#enablerichtext').attr('checked');

		var fields = ['editwidth', 'showtoolbar', 'previewonfirst', 'previewontop', 'disableeditingtips', 'disablelinksuggest', 'externaleditor', 'externaldiff', 'disablecategoryselect'];

		$(fields).each(function(i, id) {
			var checkbox = $('#' + id);

			if (RTEEnabled) {
				checkbox.parent().hide();
			}
			else {
				checkbox.parent().show();
			}
		});
	}

	$().log('setting up user preferences', 'RTE');

	$('#enablerichtext').click(RTETogglePreferences);
	RTETogglePreferences();
});
