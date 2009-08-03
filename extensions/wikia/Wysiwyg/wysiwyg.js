function FCKeditor_OnComplete(editorInstance) {
	editorInstance.LinkedField.form.onsubmit = function() {
		if(editorInstance.EditMode == FCK_EDITMODE_SOURCE) {
			YAHOO.util.Dom.get('wysiwygData').value = '';
		} else {
			YAHOO.util.Dom.get('wysiwygData').value = YAHOO.Tools.JSONEncode(editorInstance.wysiwygData);
		}
	}
}

// start editor in source mode
function wysiwygInitInSourceMode(src) {
	var iFrame = document.getElementById('wpTextbox1___Frame');
	iFrame.style.visibility = 'hidden';

	YAHOO.log('starting in source mode...');

	var intervalId = setInterval(function() {
		// wait for FCKeditorAPI to be fully loaded
		if (typeof FCKeditorAPI != 'undefined') {
			var FCK = FCKeditorAPI.GetInstance('wpTextbox1');
			// wait for FCK to be fully loaded
			if (FCK.Status == FCK_STATUS_COMPLETE) {
				clearInterval(intervalId);
				FCK.originalSwitchEditMode.apply(FCK, []);
				FCK.WysiwygSwitchToolbars(true);
				FCK.SetData(src);
				iFrame.style.visibility = 'visible';
				document.getElementById('wysiwygTemporarySaveType').value = '1';
			}
		}
	}, 250);
}

function initEditor() {
	// hide link to WikiaMiniUpload
	if($G('wmuLink')) {
		$G('wmuLink').parentNode.style.display = 'none';
	}

	var oFCKeditor = new FCKeditor("wpTextbox1");
	oFCKeditor.BasePath = window.wgWysiwygPath + '/fckeditor/';
	oFCKeditor.Config["CustomConfigurationsPath"] = window.wgWysiwygPath + '/wysiwyg_config.js';
	oFCKeditor.ready = true;
	oFCKeditor.Height = '450px';
	oFCKeditor.Width = '100%';
	oFCKeditor.ReplaceTextarea();

	// restore editor state after user returns to edit page?
	var temporarySaveType = document.getElementById('wysiwygTemporarySaveType').value;

	if (temporarySaveType != '' && !fallbackToSourceMode) {
		var content = document.getElementById('wysiwygTemporarySaveContent').value;
		YAHOO.log('restoring from temporary save', 'info', 'Wysiwyg');
		switch( parseInt(temporarySaveType) ) {
			// wysiwyg
			case 0:
				document.getElementById('wpTextbox1').value = content;
				break;

			// source
			case 1:
				wysiwygInitInSourceMode(content);
				break;
		}
	}

	// initialize editor in source mode
	if (fallbackToSourceMode) {
		wysiwygInitInSourceMode(document.getElementById('wpTextbox1').value);
	}

	// macbre: tracking
	if (typeof YAHOO != 'undefined') {
		YAHOO.util.Event.addListener(['wpSave', 'wpPreview', 'wpDiff'], 'click', function(e) {
			var elem = YAHOO.util.Event.getTarget(e);

			var buttonId = elem.id.substring(2).toLowerCase();
			var editorSourceMode = FCK.EditMode;

			WET.byStr('wysiwyg/' + buttonId + '/' + (editorSourceMode ? 'wikitextmode' : 'visualmode'));
		});
		if (fallbackToSourceMode) {
			WET.byStr('wysiwyg/edgecase');

			// track comments in wikitext
			if ($('#wpTextbox1').val().indexOf('<!--') > -1) {
				WET.byStr('wysiwyg/wikitext_comment/fallback');
			}
		}
		if (temporarySaveType != '') {
			WET.byStr('wysiwyg/temporarySave/restore');
		}
	}
}

if (typeof YAHOO.util.Event.onDOMReady != 'undefined') {
	YAHOO.util.Event.onDOMReady(function() {
		initEditor();
	});
}
else {
	addOnloadHook(initEditor);
}
