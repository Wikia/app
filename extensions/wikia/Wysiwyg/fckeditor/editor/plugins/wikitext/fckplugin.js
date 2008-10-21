// Rewrite the link command to use our link.html
FCKCommands.RegisterCommand('Link', new FCKDialogCommand('Link', FCKLang.DlgLnkWindowTitle, FCKConfig.PluginsPath + 'wikitext/dialogs/link.html', 400, 250));

var inputClickCommand = new FCKDialogCommand('inputClickCommand', '&nbsp;', FCKConfig.PluginsPath + 'wikitext/dialogs/inputClick.html', 400, 100);

var originalSwitchEditMode = FCK.SwitchEditMode;

FCK.WysiwygSwitchToolbars = function(switchToWikitext) {
	var toolbarItems = document.getElementById('xToolbar').getElementsByTagName('tr')[0].childNodes;
	var MWtoolbar = window.parent.document.getElementById('toolbar');

	// move MW toolbar next to "Source" button
	MWtoolbar.style.marginLeft = (toolbarItems[1].offsetWidth+27) + 'px';

	// show/hide FCK toolbar items
	for (t=0; t<toolbarItems.length; t++) {
		toolbarItems[t].style.display = (switchToWikitext && t > 1) ? 'none' : '';
	}

	// show/hide MW toolbar	
	MWtoolbar.style.visibility = switchToWikitext ? 'visible' : 'hidden';
}

FCK.SwitchEditMode = function() {

	if(FCK.InProgress == true) {
		return true;
	}

	FCK.InProgress = true;

	var args = arguments;

	if(FCK.EditMode == FCK_EDITMODE_WYSIWYG) {

		FCK.EditingArea.TargetElement.className = 'childrenHidden';
		originalSwitchEditMode.apply(FCK, args);

	} else if(FCK.EditMode == FCK_EDITMODE_SOURCE) {

		FCK.EditingArea.TargetElement.className = 'childrenHidden';

		window.parent.sajax_request_type = 'POST';
		window.parent.sajax_do_call('Wysywig_Ajax', ['wiki2html', FCK.EditingArea.Textarea.value, false, window.parent.wgArticleId], function(res) {
			var edgecases = res.getResponseHeader('X-edgecases');
			if(typeof edgecases == "undefined") edgecases = res.getResponseHeader('X-Edgecases');
			if (edgecases == '1') {
				messages = res.responseText;
				//macbre: insert div after contentSub
				//marooned: move the div into the contentSub like it's when we fallback on editing article with edgecases inside it
				contentSub = window.parent.document.getElementById('contentSub');
				messagesDiv = window.parent.document.getElementById('FCKEdgeCaseMessages');
				if (!messagesDiv) {
					messagesDiv = window.parent.document.createElement('div');
					messagesDiv.className = 'usermessage';
					messagesDiv.id = 'FCKEdgeCaseMessages';
					contentSub.appendChild(messagesDiv);
				}
				messagesDiv.innerHTML = messages;
			} else {
				messagesDiv = window.parent.document.getElementById('FCKEdgeCaseMessages');
				if (messagesDiv) {
					messagesDiv.parentNode.removeChild(messagesDiv);
				}

				var separator = res.getResponseHeader('X-sep');
				if(typeof separator == "undefined") separator = res.getResponseHeader('X-Sep');
				var res_array = res.responseText.split('--'+separator+'--');
				FCK.wysiwygData = eval("{"+res_array[1]+"}");
				FCK.EditingArea.Textarea.value = res_array[0];
				originalSwitchEditMode.apply(FCK, args);
			}
			FCK.EditingArea.TargetElement.className = '';
			setTimeout(function() {FCK.InProgress = false;}, 100);
			FCK.EditingArea.Focus(); // macbre: moved here from fck.js
			FCK.WysiwygSwitchToolbars(false);
		});

		if (FCK.Track) FCK.Track('/switchMode/wiki2html');
	}

	return true;
}

FCK.Events.AttachEvent( 'OnAfterSetHTML', function() {
	if(FCK.EditingArea.TargetElement.className == 'childrenHidden') {
		var html = FCK.GetData();
		var wysiwygDataEncoded =  window.parent.YAHOO.Tools.JSONEncode(FCK.wysiwygData);

		window.parent.sajax_request_type = 'POST';
		window.parent.sajax_do_call('Wysywig_Ajax', ['html2wiki', html, wysiwygDataEncoded], function(res) {
			FCK.EditingArea.Textarea.value = res.responseText;
			FCK.EditingArea.TargetElement.className = '';
			setTimeout(function() {FCK.InProgress = false;}, 100);
			FCK.EditingArea.Focus(); // macbre: moved here from fck.js
			FCK.WysiwygSwitchToolbars(true);
		});

		if (FCK.Track) FCK.Track('/switchMode/html2wiki');
	}
	if(!FCK.wysiwygData) {
		FCK.wysiwygData = eval("{"+window.parent.document.getElementById('wysiwygData').value+"}");
	}
	if(FCK.EditMode == FCK_EDITMODE_WYSIWYG) {
		FCK.EditorDocument.addEventListener( 'click', function(e) {
			if(e.target.tagName == 'INPUT') {
				var refid = e.target.getAttribute('refid');
				if(refid) {
					if (FCK.Track && FCK.wysiwygData) {
						FCK.Track('/wikitextbox/' + (FCK.wysiwygData[refid] ? FCK.wysiwygData[refid].type : 'unknown'));
					}
					inputClickCommand.Execute();
				}
			}
		}, true);
	}
});

// macbre: setup tracker object
FCK.Tracker = (typeof window.parent.YAHOO != 'undefined' && typeof window.parent.YAHOO.Wikia != 'undefined') ? window.parent.YAHOO.Wikia.Tracker : false;

FCK.Track = function(fakeUrl) {
	if (FCK.Tracker) {
		FCK.Tracker.trackByStr(null, 'wysiwyg'+fakeUrl);
	}
}

// track the fact of using FCK + send the name of edited page
FCK.Track('/init/' + window.parent.wgPageName);
