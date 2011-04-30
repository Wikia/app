$(function() {
	var RTETogglePreferences = function() {
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
	};

	var RTEMonobookOnlyPreferences = function() {
		var sections = ['editarea-size', 'monobook-layout'];

		if (window.skin != 'monobook') {
			$.each(sections, function() {
				var section = $('#mw-htmlform-' + this).parent();
				section.hide();
			});
		}
	};

	$().log('setting up user preferences', 'RTE');

	var toggle = $('input[name="wpenablerichtext"]');
	toggle.click(RTETogglePreferences);

	RTETogglePreferences();
	RTEMonobookOnlyPreferences();
});
