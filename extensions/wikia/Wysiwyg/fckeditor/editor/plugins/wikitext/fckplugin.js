// Rewrite the link command to use our link.html
FCKCommands.RegisterCommand('Link', new FCKDialogCommand('Link', FCKLang.DlgLnkWindowTitle, FCKConfig.PluginsPath + 'wikitext/dialogs/link.html', 400, 250));

var FCKTildesCommand = function() {
	this.Name = 'Tildes' ;
}
FCKTildesCommand.prototype = {
	Execute : function() {
		FCKUndo.SaveUndoStep() ;

		var text = document.createTextNode('--');
		FCK.InsertElement(text) ;

		FCK.wysiwygData.push({'type':'tilde','description':'~~~~'});

		var input = document.createElement('input');
		input.value = "~~~~";
		input.className = 'wysiwygDisabled';
		input.type = 'button';
		input.setAttribute('refid', FCK.wysiwygData.length-1);

		FCK.InsertElement(input) ;
	},
	GetState : function() {
		if ( FCK.EditMode != FCK_EDITMODE_WYSIWYG )
			return FCK_TRISTATE_DISABLED ;
		return FCK_TRISTATE_OFF;
	}
} ;
FCKCommands.RegisterCommand('Tildes', new FCKTildesCommand());
var oTildesItem = new FCKToolbarButton( 'Tildes', 'Your signature with timestamp' ) ;
oTildesItem.IconPath = FCKConfig.PluginsPath + 'wikitext/sig.gif' ;
FCKToolbarItems.RegisterItem( 'Tildes', oTildesItem );



var inputClickCommand = new FCKDialogCommand('inputClickCommand', '&nbsp;', FCKConfig.PluginsPath + 'wikitext/dialogs/inputClick.html', 400, 100);

FCK.originalSwitchEditMode = FCK.SwitchEditMode;

FCK.WysiwygSwitchToolbars = function(switchToWikitext) {
	var toolbarItems = document.getElementById('xToolbar').getElementsByTagName('tr')[0].childNodes;
	var MWtoolbar = window.parent.document.getElementById('toolbar');
	var FCKiframe = window.parent.document.getElementById('wpTextbox1___Frame');

	// move MW toolbar next to "Source" button
	if (MWtoolbar) {
		MWtoolbar.style.marginLeft = (toolbarItems[1].offsetWidth+27) + 'px';
		MWtoolbar.style.top = (FCKiframe.offsetTop - FCK.GetParentForm().offsetTop + 3) + 'px';
	}

	// show/hide FCK toolbar items
	for (t=0; t<toolbarItems.length; t++) {
		toolbarItems[t].style.display = (switchToWikitext && t > 1) ? 'none' : '';
	}

	// show/hide MW toolbar
	if (MWtoolbar) {
		MWtoolbar.style.visibility = switchToWikitext ? 'visible' : 'hidden';
	}
}

FCK.SwitchEditMode = function() {

	if(FCK.InProgress == true) {
		return true;
	}

	FCK.InProgress = true;

	var args = arguments;

	if(FCK.EditMode == FCK_EDITMODE_WYSIWYG) {

		FCK.EditingArea.TargetElement.className = 'childrenHidden';
		FCK.originalSwitchEditMode.apply(FCK, args);

	} else if(FCK.EditMode == FCK_EDITMODE_SOURCE) {

		FCK.EditingArea.TargetElement.className = 'childrenHidden';

		window.parent.sajax_request_type = 'POST';
		window.parent.sajax_do_call('Wysywig_Ajax', ['wiki2html', FCK.EditingArea.Textarea.value, false, window.parent.wgArticleId], function(res) {
			var edgecases = res.getResponseHeader('X-edgecases');
			if(typeof edgecases == "undefined") edgecases = res.getResponseHeader('X-Edgecases');
			if (edgecases == '1') {
				messages = res.responseText;
				//macbre: just show old-school alert()
				alert(messages);
			} else {
				var separator = res.getResponseHeader('X-sep');
				if(typeof separator == "undefined") separator = res.getResponseHeader('X-Sep');
				var res_array = res.responseText.split('--'+separator+'--');
				FCK.wysiwygData = eval("{"+res_array[1]+"}");
				if(!FCK.wysiwygData) {
					FCK.wysiwygData = [];
				}
				FCK.EditingArea.Textarea.value = res_array[0];
				FCK.originalSwitchEditMode.apply(FCK, args);
				FCK.WysiwygSwitchToolbars(false);
				if (FCK.Track) FCK.Track('/switchMode/wiki2html');
				window.parent.document.getElementById('wysiwygTemporarySaveType').value = "0";
			}
			FCK.EditingArea.TargetElement.className = '';
			setTimeout(function() {FCK.InProgress = false;}, 100);
			FCK.EditingArea.Focus(); // macbre: moved here from fck.js
		});
	}

	return true;
}

FCK.InsertDirtySpanBefore = function(node) {
	var span = FCKTools.GetElementDocument(node).createElement('SPAN');
	span.setAttribute('type', '_moz');
	span.className = '_moz_dirty';
	node.parentNode.insertBefore(span, node);
}

FCK.Events.AttachEvent( 'OnAfterSetHTML', function() {
	if(FCK.EditingArea.TargetElement.className == 'childrenHidden') {
		var html = FCK.GetData();
		var wysiwygDataEncoded =  FCK.YAHOO.Tools.encodeArr(FCK.wysiwygData);

		window.parent.sajax_request_type = 'POST';
		window.parent.sajax_do_call('Wysywig_Ajax', ['html2wiki', html, wysiwygDataEncoded], function(res) {
			FCK.EditingArea.Textarea.value = res.responseText;
			FCK.EditingArea.TargetElement.className = '';
			setTimeout(function() {FCK.InProgress = false;}, 100);
			FCK.EditingArea.Focus(); // macbre: moved here from fck.js
			FCK.WysiwygSwitchToolbars(true);
			if (FCK.Track) FCK.Track('/switchMode/html2wiki');
			window.parent.document.getElementById('wysiwygTemporarySaveType').value = "1";
		});
	}
	if(!FCK.wysiwygData) {
		FCK.wysiwygData = eval("{"+window.parent.document.getElementById('wysiwygData').value+"}");
		if(!FCK.wysiwygData) {
			FCK.wysiwygData = [];
		}
		FCK.log(FCK.wysiwygData);

	}
	if(FCK.EditMode == FCK_EDITMODE_WYSIWYG) {

		// handle drag&drop
		FCKTools.AddEventListener(FCK.EditorDocument, 'mousedown', function(e) {
			var target = FCK.YAHOO.util.Event.getTarget(e);
			if(target.tagName == 'INPUT') {
					FCKSelection.SelectNode(target);
			}
		});


		// open wikitext dialog
		FCKTools.AddEventListener(FCK.EditorDocument, 'click', function(e) {
			var target = FCK.YAHOO.util.Event.getTarget(e);
			if(target.tagName == 'INPUT') {
				var refid = target.getAttribute('refid');
				if(refid) {
					if (FCK.Track && FCK.wysiwygData) {
						FCK.Track('/wikitextbox/' + (FCK.wysiwygData[refid] ? FCK.wysiwygData[refid].type : 'unknown'));
					}
					inputClickCommand.Execute();
				}
			}
		});

		// macbre: fix issue with input tags as last child (can't move to end of the line)
		var placeholders = FCK.EditorDocument.getElementsByTagName('input');
		for (p=0; p<placeholders.length; p++) {
			// disable context menu
			placeholders[p].setAttribute('_fckContextMenuDisabled', true);

			// templates preview
			if (FCK.YAHOO.util.Dom.hasClass(placeholders[p], 'wysiwygTemplate')) {
				FCK.TemplatePreviewAdd(placeholders[p]);
			}

			if (placeholders[p].parentNode.nodeName.IEquals(['p', 'div', 'li', 'dt', 'dd']) &&  placeholders[p] == placeholders[p].parentNode.lastChild) {
				if (FCKBrowserInfo.IsGecko10) {
					// add &nbsp; for FF2.x
					var frag = FCK.EditorDocument.createDocumentFragment();
					frag.appendChild(FCK.EditorDocument.createTextNode('\xA0'));
					placeholders[p].parentNode.appendChild(frag);
				}
				else {
					// add 'dirty' <br/>
					FCKTools.AppendBogusBr(placeholders[p].parentNode);
				}
			}

			// insert <span type="_moz"> between input tags
			if ( (placeholders[p].nextSibling && placeholders[p].nextSibling.nodeName.IEquals('input'))) {
				FCK.InsertDirtySpanBefore(placeholders[p].nextSibling);
			}

			// and at the beginning of line
			if (placeholders[p].parentNode.firstChild == placeholders[p]) {
				FCK.InsertDirtySpanBefore(placeholders[p]);
			}
		}

		// macbre: register onClick handler to protect images
		FCKTools.AddEventListener( FCK.EditorDocument, 'mousedown', function(e) {
			target = FCK.YAHOO.util.Event.getTarget(e);

			// go up to find div/table with refId
			while( target ) {
				if (target.nodeName.IEquals(['div', 'table']) && target.getAttribute('refId')) {
					//FCK.log('click blocked'); FCK.log(target);

					// stop event
					e.preventDefault();
					e.stopPropagation();

					// disable context menu
					target.setAttribute('_fckContextMenuDisabled', true);

					// right mouse button
					if (e.button == 2) {
						// this hacky thing will cause image selection to disappear
						FCK.SetHTML(FCK.GetHTML());
					}
					return;
				}
				target = target.parentNode;
			}
		});
	}

	// for QA team tests
	FCK.GetParentForm().className = (FCK.EditMode == FCK_EDITMODE_WYSIWYG ? 'wysiwyg' : 'source') + '_mode';

});

// check whether given page exists (API query returns pageid != 0)
// if not -> add "new" class to simulate MW parser behaviour
FCK.CheckInternalLink = function(title, link) {
	var callback = {
		success: function(o) {
			FCK = o.argument.FCK;
			title = o.argument.title;
			link =  o.argument.link;

			result = eval('(' + o.responseText + ')');
			pageExists = (typeof result.query.pages[-1] == 'undefined');

			FCK.log('"' + title + '" ' + (pageExists ? 'exists' : 'doesn\'t exist'));

			if (link) {
				if (pageExists) {
					FCK.YAHOO.util.Dom.removeClass(link, 'new');
					link.href = window.parent.wgServer + window.parent.wgArticlePath.replace(/\$1/, encodeURI(title.replace(/ /g, '_')));
				} else {
					FCK.YAHOO.util.Dom.addClass(link, 'new');
					link.href = window.parent.wgServer + window.parent.wgScript + '?title=' + encodeURIComponent(title.replace(/ /g, '_')) + '&action=edit&redlink=1';
				}
				FCK.log('href: ' + link.href);
			}
		},
		failure: function(o) {},
		argument: {'FCK': FCK, 'link': link, 'title': title}
	}
	FCK.YAHOO.util.Connect.asyncRequest("POST", window.parent.wgScriptPath + '/api.php', callback, "action=query&format=json&prop=info&titles=" +   encodeURIComponent(title) );
}

// onmouseover template preview
FCK.TemplatePreviewCloud = false;

FCK.TemplatePreviewAdd = function(placeholder) {

	//var docObj = FCK.EditingArea.TargetElement.ownerDocument;
	var docObj = FCK.LinkedField.ownerDocument;

	// initialize preview cloud
	if (!FCK.TemplatePreviewCloud) {
		FCK.TemplatePreviewCloud = docObj.createElement('DIV');
		docObj.body.appendChild(FCK.TemplatePreviewCloud);

		FCK.TemplatePreviewCloud.id = 'wysiwygTemplatePreviewCloud';
		FCK.TemplatePreviewCloud.innerHTML = '<div id="wysiwygTemplatePreviewCloudInner"></div>';
	}

	var refId = placeholder.getAttribute('refid');

	//FCK.log('registering template preview for refId #' + refId);

	// copy template previews to clouds
	var preview = placeholder.nextSibling;
	var previewDiv = docObj.createElement('div');
	
	FCK.TemplatePreviewCloud.firstChild.appendChild( previewDiv );
	
	previewDiv.id = 'wysiwygTemplatePreview' + refId;
	previewDiv.innerHTML = preview.value + '<br style="clear:both" />';

	// sometimes innerHTML contains </p> at the beginning -> fix it
	previewDiv.innerHTML = previewDiv.innerHTML.Trim();

	previewDiv.style.display = 'none';

	// remove preview div from editing area
	preview.parentNode.removeChild(preview);

	// register events handlers
	FCKTools.AddEventListener(placeholder, 'mouseover', function(e) {
		FCK.TemplatePreviewShow(FCK.YAHOO.util.Event.getTarget(e));
	});
	
	FCKTools.AddEventListener(placeholder, 'mouseout', function(e) {
		FCK.TemplatePreviewHide(FCK.YAHOO.util.Event.getTarget(e));
	});

}

FCK.TemplatePreviewShow = function(placeholder) {
	
	var refId = placeholder.getAttribute('refid');
	var preview = FCK.TemplatePreviewCloud.ownerDocument.getElementById('wysiwygTemplatePreview' + refId);

	// reset margin/padding
	if (preview.firstChild && preview.firstChild.nodeType == 1) {
		preview.firstChild.style.padding = 0;
		preview.firstChild.style.margin = 0;
	}

	// calculate cloud placement
	var x = placeholder.offsetLeft;
	var y = placeholder.offsetTop + placeholder.clientHeight + 32;

	// iframe position
	var iFrameXY = FCK.YAHOO.util.Dom.getXY('wpTextbox1___Frame');

	FCK.TemplatePreviewCloud.style.left = parseInt(x + iFrameXY[0]) + 'px';
	FCK.TemplatePreviewCloud.style.top = parseInt(y + iFrameXY[1]) + 'px';

	// show template preview and cloud
	preview.style.display = '';
	FCK.TemplatePreviewCloud.style.visibility = 'visible';
}

FCK.TemplatePreviewHide = function(placeholder) {
	
	var refId = placeholder.getAttribute('refid');
	var preview = FCK.TemplatePreviewCloud.ownerDocument.getElementById('wysiwygTemplatePreview' + refId);

	// hide template preview and cloud
	preview.style.display = 'none';
	FCK.TemplatePreviewCloud.style.visibility = 'hidden';
}

// YUI reference
FCK.YAHOO = window.parent.YAHOO;

// log functionality
FCK.log = function(msg) {
	if (FCK.YAHOO) {
		FCK.YAHOO.log(msg, 'info', 'Wysiwyg');
	}
}

// macbre: setup tracker object
FCK.Tracker = (typeof window.parent.YAHOO != 'undefined' && typeof window.parent.YAHOO.Wikia != 'undefined') ? window.parent.YAHOO.Wikia.Tracker : false;

FCK.Track = function(fakeUrl) {
	if (FCK.Tracker) {
		FCK.Tracker.trackByStr(null, 'wysiwyg'+fakeUrl);
	}
}

// track the fact of using FCK + send the name of edited page
FCK.Track('/init/' + window.parent.wgPageName);

// store editor state (current mode and data) when leaving editor
// IE doesn't seem to support that
if (!FCKBrowserInfo.IsIE) {
	FCKTools.AddEventListener(window, 'beforeunload', function() {
		var typeField = window.parent.document.getElementById('wysiwygTemporarySaveType');
		var contentField = window.parent.document.getElementById('wysiwygTemporarySaveContent');
		var metaField = window.parent.document.getElementById('wysiwygData');

		// save editor state in hidden editor fields
		typeField.value = FCK.EditMode;
		contentField.value = (FCK.EditMode == FCK_EDITMODE_SOURCE) ? FCK.GetData() : FCK.EditorDocument.body.innerHTML;
		metaField.value = FCK.YAHOO.Tools.encodeArr(FCK.wysiwygData);

		FCK.log('editor state saved');
		FCK.Track('/temporarySave/store');
	});
}
else {
	FCK.log('temporary save not supported in your browser');
}

// for us, developers ;)
window.parent.FCK = FCK;
