function wysiwygTogglePreferences() {
	var state = YAHOO.util.Dom.get('disablewysiwyg').checked;
	var fields = ['editwidth', 'showtoolbar', 'previewonfirst', 'previewontop', 'disableeditingtips', 'disablelinksuggest', 'externaleditor', 'externaldiff', 'disablecategoryselect'];

	for (f=0; f<fields.length; f++) {
		var checkbox = YAHOO.util.Dom.get(fields[f]);
		if (checkbox) {
			checkbox.parentNode.style.display = state ? '' : 'none';
		}
	}
}

function wysiwygSetupPreferences() {
	YAHOO.log('Wysiwyg: setting up user preferences');
	YAHOO.util.Event.addListener('disablewysiwyg', 'click', function(e) {
		wysiwygTogglePreferences();
	});
	wysiwygTogglePreferences();
}

addOnloadHook(wysiwygSetupPreferences);
