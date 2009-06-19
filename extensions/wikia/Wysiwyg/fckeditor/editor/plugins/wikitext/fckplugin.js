// Rewrite the link command to use our link.html
FCKCommands.RegisterCommand('Link', new FCKDialogCommand('Link', FCKLang.DlgLnkWindowTitle, FCKConfig.PluginsPath + 'wikitext/dialogs/link.html', 400, 250));

// Register templates editor
FCK.TemplateClickCommand = new FCKDialogCommand('Template', '&nbsp;', FCKConfig.PluginsPath + 'wikitext/dialogs/template.html', 780, 490);

// signature toolbar button
var FCKTildesCommand = function() {
	this.Name = 'Tildes' ;
}
FCKTildesCommand.prototype = {
	Execute : function() {
		FCKUndo.SaveUndoStep() ;

		var text = FCK.EditorDocument.createTextNode('--');
		FCK.InsertElement(text) ;

		var refid = FCK.GetFreeRefId();

		FCK.wysiwygData[refid] = {'type':'tilde','description':'~~~~'};

		var input = FCK.EditorDocument.createElement('input');
		input.value = "~~~~";
		input.className = 'wysiwygDisabled';
		input.type = 'button';
		input.setAttribute('refid', refid);

		FCK.InsertElement(input) ;
	},
	GetState : function() {
		if ( FCK.EditMode != FCK_EDITMODE_WYSIWYG )
			return FCK_TRISTATE_DISABLED ;
		return FCK_TRISTATE_OFF;
	}
} ;
FCKCommands.RegisterCommand('Tildes', new FCKTildesCommand());
var oTildesItem = new FCKToolbarButton( 'Tildes', 'Add your signature' ) ;
oTildesItem.IconPath = FCKConfig.PluginsPath + 'wikitext/sig.gif' ;
FCKToolbarItems.RegisterItem( 'Tildes', oTildesItem );


// "add image" toolbar button
var FCKAddImageCommand = function() {
	this.Name = 'AddImage' ;
}
FCKAddImageCommand.prototype = {
	Execute : function() {
		FCKUndo.SaveUndoStep() ;
		FCK.log('opening "add image" dialog');
		window.parent.WMU_show(-1);
	},
	GetState : function() {
		if ( FCK.EditMode != FCK_EDITMODE_WYSIWYG )
			return FCK_TRISTATE_DISABLED ;
		return FCK_TRISTATE_OFF;
	}
} ;
FCKCommands.RegisterCommand('AddImage', new FCKAddImageCommand());
var oTildesItem = new FCKToolbarButton( 'AddImage', 'Add image' ) ;
oTildesItem.IconPath = FCKConfig.PluginsPath + 'wikitext/addImage.png' ;
FCKToolbarItems.RegisterItem( 'AddImage', oTildesItem );

//
// FCK load time logging
//
//
//

FCK.ToggleEditButtons = function( mode ) {
	var buttons = ['wpSave', 'wpPreview', 'wpDiff'];
	for (b=0; b<buttons.length; b++) {
		window.parent.document.getElementById(buttons[b]).disabled = mode;
	}
}

FCK.EditorInstanceId = (new Date()).getTime();

FCK.LoadTime = false;
FCK.onWysiwygLoad = function() {
	// run just once
	if (FCK.LoadTime == false) {
		// unblock save / preview / show changes button
		FCK.ToggleEditButtons( false );
		FCK.log('Save / preview / show changes buttons have been unblocked');

		// add FCK version info
		FCK.log('FCKeditor v' + window.parent.FCKeditorAPI.Version + ' (build ' + window.parent.FCKeditorAPI.VersionBuild + ')');

		//
		// set wysiwyg load time
		//

		// check existance of wgNow global JS variable
		// should be always defined in Monaco skin
		if (typeof window.parent.wgNow == 'undefined') {
			FCK.log('loaded (wgNow not defined!)');
			FCK.LoadTime = true;
			return;
		}

		FCK.LoadTime = ((new Date()).getTime() - window.parent.wgNow.getTime()) / 1000;

		// report load time
		FCK.log('loaded in ' + FCK.LoadTime + ' s');
	}
}


//
// modes switching
//

FCK.originalSwitchEditMode = FCK.SwitchEditMode;

FCK.WysiwygSwitchToolbars = function(switchToWikitext) {
	var toolbar = FCK.ToolbarSet.Toolbars[0];
	toolbar.WikiaSwitchToolbar(switchToWikitext);
}

FCK.SwitchEditMode = function() {

	if(FCK.InProgress == true) {
		return true;
	}

	FCK.InProgress = true;

	FCK.ToggleEditButtons(true);

	var args = arguments;

	if(FCK.EditMode == FCK_EDITMODE_WYSIWYG) {

		FCK.EditingArea.TargetElement.className = 'childrenHidden';
		FCK.originalSwitchEditMode.apply(FCK, args);

	} else if(FCK.EditMode == FCK_EDITMODE_SOURCE) {

		FCK.EditingArea.TargetElement.className = 'childrenHidden';

		window.parent.sajax_request_type = 'POST';
		window.parent.sajax_do_call('Wysywig_Ajax', ['wiki2html', FCK.EditingArea.Textarea.value, false, window.parent.wgPageName], function(res) {
			var edgecases = res.getResponseHeader('X-edgecases');
			if(typeof edgecases == "undefined") edgecases = res.getResponseHeader('X-Edgecases');
			if (edgecases == '1' || window.parent.noWysiwygMagicWordMsg) {
				messages = window.parent.noWysiwygMagicWordMsg || res.responseText;

				// track comments in wikitext
				if (FCK.EditingArea.Textarea.value.indexOf('<!--') > -1) {
					FCK.Track('/wikitext_comment/popup');
				}

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
			FCK.ToggleEditButtons(false);
			FCK.EditingArea.Focus(); // macbre: moved here from fck.js
		});
	}

	return true;
}

//
// misc functions
//
FCK.ArrayIndexOf = function( arr, value )
{
	for ( var i = 0 ; i < arr.length ; i++ )
	{
		if ( arr[i] == value )
			return i ;
	}
	return -1 ;
}

FCK.InsertDirtySpanBefore = function(node) {
	var span = FCKTools.GetElementDocument(node).createElement('SPAN');
	span.setAttribute('type', '_moz');
	span.className = '_moz_dirty';
	node.parentNode.insertBefore(span, node);
}

FCK.InsertDirtySpanAfter = function(node) {
	var span = FCKTools.GetElementDocument(node).createElement('SPAN');
	span.setAttribute('type', '_moz');
	span.className = '_moz_dirty';
	FCKDomTools.InsertAfterNode(node, span);
}

// return next free refId
FCK.GetFreeRefId = function() {
	// JSONEncode & JSONParse sometimes breaks FCK.wysiwygData.length value
	var refid = 0;
	for (r in FCK.wysiwygData) {
		r = parseInt(r);
		if (refid < r) {
			refid = r;
		}
	}
	return ++refid;
}

FCK.GetElementByRefId = function(refId) {
	return FCK.NodesWithRefId[refId];
}

FCK.NodesWithRefId = {};

FCK.GetNodesWithRefId = function() {
	var nodes = [];

	FCK.NodesWithRefId = {};

	// get elements using XPath (at least try)
	if (FCKBrowserInfo.IsIE) {
		// of course IE has it's own standards...
		var method = function(node) {
			return (node.getAttribute('refid') != undefined);
		};

		var add = function(node) {
			FCK.NodesWithRefId[ node.getAttribute('refid') ] = node;
		}

		var nodes = FCK.YD.getElementsBy(method, false, FCK.EditorDocument.body, add);
	}
	else {
		// @see http://www.w3schools.com/XPath/xpath_examples.asp
		// Mozilla-based browser - use XPath
		var results = FCK.EditorDocument.evaluate('//@refid', FCK.EditorDocument, null, XPathResult.ANY_TYPE, null);

		while (attr = results.iterateNext()) {
			node = attr.ownerElement;
			nodes.push(node);
			FCK.NodesWithRefId[ node.getAttribute('refid') ] = node;
		}
	}

	FCK.log('returning ' + nodes.length + ' nodes with refId');

	return nodes;
}

//
// block given event (prevenDefault + stopPropagation)
//
FCK.BlockEvent = function(elem, eventType) {
	FCKTools.AddEventListener(elem, eventType, function(e) {
		FCK.YE.stopEvent( FCK.YE.getEvent(e) );
	});
}

//
// setup handlers for placeholders when in wysiwyg mode
//
FCK.Events.AttachEvent( 'OnAfterSetHTML', function() {
	if(FCK.EditingArea.TargetElement.className == 'childrenHidden') {
		var html = FCK.GetData();
		var wysiwygDataEncoded = FCK.YAHOO.Tools.JSONEncode(FCK.wysiwygData);

		FCK.log(FCK.wysiwygData);

		window.parent.sajax_request_type = 'POST';
		window.parent.sajax_do_call('Wysywig_Ajax', ['html2wiki', html, wysiwygDataEncoded], function(res) {
			FCK.EditingArea.Textarea.value = res.responseText;
			FCK.EditingArea.TargetElement.className = '';
			setTimeout(function() {FCK.InProgress = false;}, 100);
			FCK.EditingArea.Focus(); // macbre: moved here from fck.js
			FCK.WysiwygSwitchToolbars(true);
			if (FCK.Track) FCK.Track('/switchMode/html2wiki');
			window.parent.document.getElementById('wysiwygTemporarySaveType').value = "1";
			FCK.ToggleEditButtons(false);
		});
	}

	// initialize meta data
	if(!FCK.wysiwygData) {
		FCK.wysiwygData = eval("{"+window.parent.document.getElementById('wysiwygData').value+"}");
		if(!FCK.wysiwygData) {
			FCK.wysiwygData = [];
		}
		FCK.log(FCK.wysiwygData);

	}

	// setup wysiwyg mode
	if(FCK.EditMode == FCK_EDITMODE_WYSIWYG) {
		// handle drag&drop
		FCKTools.AddEventListener(FCK.EditorDocument, 'mousedown', function(e) {
			var target = FCK.YAHOO.util.Event.getTarget(e);
			if(target.tagName == 'INPUT') {
					FCKSelection.SelectNode(target);
			}
		});

		// Drag'n'Drop (Gecko browsers)
		//
		// @see https://developer.mozilla.org/en/Drag_and_drop_events
		//
		// handle begin of drag&drop -> save Undo step do we can easily revert any prohibited drag&drop
		//
		FCK.DragNDropInProgress = false;
		FCK.DragNDropUndoStep = {};

		FCKTools.AddEventListener(FCK.EditorDocument, 'drag', function(e) {
			if (!FCK.DragNDropInProgress) {
				FCK.log('drag&drop started - saved undo step');
				FCK.DragNDropInProgress = true;
				FCK.DragNDropUndoStep = {html: FCK.EditorDocument.body.innerHTML, cursor: FCKUndo._GetBookmark()};
			}
		});

		// handle finish of drag&drop -> regenerate elements with refId
		//
		FCKTools.AddEventListener(FCK.EditorDocument, 'dragdrop', function(e) {
			FCK.DragNDropInProgress = false;

			// setup elements with refid (templates, images, ...)
			FCK.SetupElementsWithRefId();

			// check where image was droped
			var target = FCK.YE.getTarget(e);

			var selection = FCKSelection.GetSelection();

			// detect prohibited drag&drops inside image <div> (IE handles contentEditable correctly, really!)
			if (target.getAttribute && target.getAttribute('contentEditable') == "false") {
				FCK.log('prohibited drag&drop detected - undo');

				FCK.EditorDocument.body.innerHTML =  FCK.DragNDropUndoStep.html;
				FCKUndo._SelectBookmark(FCK.DragNDropUndoStep.cursor);

				FCK.SetupElementsWithRefId();

				FCK.Events.FireEvent("OnSelectionChange");
			}

			// detect drop outside editing area
			if ( FCK.ImageDragDrop && !FCK.GetElementByRefId(FCK.ImageDragDrop.getAttribute('refid')) ) {
				// add image back to editing area
				FCK.log('adding image back to editing area');
				FCK.EditorDocument.body.appendChild(FCK.ImageDragDrop);

				FCK.SetupElementsWithRefId();
			}

			// reload HTML to remove drag/resize box (dirty hack for FF3+)
			if (FCKBrowserInfo.IsGecko19 && FCK.ImageDragDrop) {
				var html = FCK.EditorDocument.body.innerHTML;
				FCK.EditorDocument.body.innerHTML = html;

				FCK.SetupElementsWithRefId();
			}

			// remove drag&drop undo step
			FCK.DragNDropUndoStep = {};

			// unselect any selection
			if (selection.removeAllRanges) {
				selection.removeAllRanges();
			}

			FCK.ImageDragDrop = false;
		});

		// IE
		if (FCKBrowserInfo.IsIE) {
			FCK.EditorDocument.body.ondrop = function(e) {
				FCK.log('drag&drop finished');

				// setup elements with refid (templates, images, ...)
				FCK.SetupElementsWithRefId();
			};
		}

		// open wikitext dialog
		FCKTools.AddEventListener(FCK.EditorDocument, 'click', function(e) {
			var target = FCK.YAHOO.util.Event.getTarget(e);
			if(target.tagName == 'INPUT') {
				var refid = target.getAttribute('refid');
				var type = target.getAttribute('_fck_type');
				if(refid && type != 'template') {
					if (FCK.Track && FCK.wysiwygData) {
						FCK.Track('/wikitextbox/' + (FCK.wysiwygData[refid] ? FCK.wysiwygData[refid].type : 'unknown'));
					}
					// show simple YUI dialog
					FCK.ShowInfoDialog('To edit this section please switch to WikiText view by clicking the "Source" button');
				}
			}
			// probably IE - go up the DOM tree looking for refid element of the image
			else if (target.getAttribute('contentEditable') == 'false') {
				while (!target.getAttribute('refid')) {
					target = target.parentNode;
				}

				var refid = target.getAttribute('refid');

				// fix list of nodes with refids
				FCK.NodesWithRefId[refid] = target;

				// call WMU dialog (only for images)
				if (FCK.wysiwygData[refid].type == 'image') {
					FCK.ProtectImageEdit(refid);
				}
			}
		});

		// setup elements with refid (templates, images, ...)
		FCK.SetupElementsWithRefId();
	}
	// setup source mode
	else {
		// hide currently shown template preview
		FCK.TemplatePreviewInit();

		// add Tab handler -> move to summary field
		FCKTools.AddEventListener(FCK.EditingArea.Textarea, 'keydown', function(e) {
			e = FCK.YE.getEvent(e);
			if (e.keyCode == 9) {
				FCK.log('tab key pressed');
				FCK.YE.stopEvent(e);

				// focus on #wpSummary / #wpSummaryEnhanced
				var summary = window.parent.document.getElementById('wpSummary') || window.parent.document.getElementById('wpSummaryEnhanced');
				if (summary) {
					summary.focus();
				}
			}
		});

		// initial toolbar positioning
		FCK.WysiwygSwitchToolbars(1);
	}

	// for QA team tests
	FCK.GetParentForm().className = (FCK.EditMode == FCK_EDITMODE_WYSIWYG ? 'wysiwyg' : 'source') + '_mode';

	// log wysiwyg load time
	FCK.onWysiwygLoad();
});

// setup elements with refId (after switching to wysiwyg mode and after drag&drop is finished)
FCK.SetupElementsWithRefId = function() {

	// init templates preview
	FCK.TemplatePreviewInit();

	// get all elements with refid attribute and handle them by value of _fck_type attribute
	var nodes = FCK.GetNodesWithRefId();
	FCK.log(nodes);

	for (n=nodes.length-1; n>=0; n--) {
		var node = nodes[n];
		var refid = node.getAttribute('refid');
		if (!refid) {
			continue;
		}

		var data = FCK.wysiwygData[refid];
		if (!data) {
			continue;
		}

		// add editor instance
		node.setAttribute('_fck_editor_instance', FCK.EditorInstanceId);

		var type = node.getAttribute('_fck_type') || data.type;
		var name = node.nodeName.toLowerCase();

		switch(type) {
			case 'template':
				FCK.TemplatePreviewAdd(node);
				break;

			case 'image':
				FCK.ProtectImage(node);
				break;

			case 'video':
				FCK.ProtectVideo(node);
				break;

			case 'video_add':
				FCK.ProtectVideoAdd(node);
				break;

			// add tooltip to links
			case 'internal link':
				node.title = data.href;
				break;

			case 'external link':
				node.title = data.href;
				break;

			// hooks
			case 'hook':
				// setup <videogallery>
				if ( (typeof FCK.VideoSetupGalleryPlaceholder != 'undefined') && (data.name == 'videogallery') ) {
					FCK.VideoSetupGalleryPlaceholder(node);
				}
		}

		// fix issues with input tags and cursor
		if (name == 'input') {
			FCK.FixWikitextPlaceholder(node);
		}
	}

	FCK.log('setup of nodes with refid finished');

	return true;
}

// show pop-up dialog
FCK.ShowInfoDialog = function(text, title) {
	// use jQuery make modal plugin
	FCK.jQuery.getScript(window.parent.stylepath + '/common/jquery/jquery.wikia.modal.js?' + FCKConfig.StyleVersion, function() {
		// no title provided
		if (!title) {
			title = '&nbsp;';
		}

		var html = '<div id="wysiwygInfobox" title="' + title + '"><div style="padding: 5px">' + text + '</div></div>';
		FCK.jQuery("#positioned_elements").append(html);
		FCK.jQuery("#wysiwygInfobox").makeModal({width: 450});
	});
}

FCK.ShowConfirm = function(question, title, callback) {
	// use jQuery make modal plugin
	FCK.jQuery.getScript(window.parent.stylepath + '/common/jquery/jquery.wikia.modal.js?' + FCKConfig.StyleVersion, function() {
		// no title provided
		if (!title) {
			title = '&nbsp;';
		}

		var html = '<div id="wysiwygConfirm" title="' + title + '">' +
			'<div style="padding: 5px">' + question +
			'<div style="border-top: solid 1px #ddd; text-align: right; padding-top: 5px; margin-top: 5px">' +
				'<button id="wysiwygConfirmOk" style="margin: 0 8px">' + FCKLang.DlgBtnOK + '</button>' +
				'<button id="wysiwygConfirmCancel">' + FCKLang.DlgBtnCancel + '</button>' +
			'</div></div></div>';

		FCK.jQuery("#positioned_elements").append(html);

		// function to close dialog
		var closeDialog = function() {FCK.jQuery('#wysiwygConfirm').closest('.modalWrapper').find('h1 div').click()};

		// onclick handlers
		FCK.jQuery('#wysiwygConfirmOk').click(function() {
			closeDialog();
			if (typeof callback == 'function') {
				callback();
			}
		});
		FCK.jQuery('#wysiwygConfirmCancel').click(closeDialog);

		// show modal
		FCK.jQuery("#wysiwygConfirm").makeModal({width: 450});
	});
}

// setup grey wikitext placeholder: block context menu, add dirty span(s) if needed
FCK.FixWikitextPlaceholder = function(placeholder) {
	// disable context menu
	placeholder.setAttribute('_fckContextMenuDisabled', true);

	// placeholder is last child of p, div, li, dt or dd node - add dirty span
	if (placeholder.parentNode.nodeName.IEquals(['p', 'div', 'li', 'dt', 'dd']) &&
		(placeholder == placeholder.parentNode.lastChild ||
			(placeholder.parentNode.lastChild.previousSibling && placeholder == placeholder.parentNode.lastChild.previousSibling.previousSibling)
		)) {
		if (FCKBrowserInfo.IsGecko10) {
			// add &nbsp; for FF2.x
			var frag = FCK.EditorDocument.createDocumentFragment();
			frag.appendChild(FCK.EditorDocument.createTextNode('\xA0'));
			placeholder.parentNode.appendChild(frag);
		}
		else {
			FCK.InsertDirtySpanAfter(placeholder);
		}
	}

	// insert <span type="_moz">:
	// 1. between input tags
	if ( (placeholder.nextSibling && placeholder.nextSibling.nodeName.IEquals('input'))) {
		FCK.InsertDirtySpanAfter(placeholder);
	}

	// 2. at the beginning of the line
	if (placeholder.parentNode.firstChild == placeholder) {
		FCK.InsertDirtySpanBefore(placeholder);
	}

	// 3. after input tag if parent node is body ("<table>" template placeholder)
	if (placeholder.parentNode.nodeName.IEquals('body')) {
		FCK.InsertDirtySpanBefore(placeholder);
		FCK.InsertDirtySpanAfter(placeholder);
	}
}

// parses given wikitext and fires callback with HTML, FCK and refid
FCK.ParseWikitext = function(wikitext, callback, data, useWysiwygParser) {
	// parse given wikitext
	var callback = {
		success: function(o) {
			html = o.responseText;

			// fire callback
			FCK = o.argument.FCK;
			data =  o.argument.data;
			callback = o.argument.callback;

			callback(html, FCK, data);
		},
		failure: function(o) {},
		argument: {'FCK': FCK, 'data': data, 'callback': callback}
	}

	// build params array
	var params = [];

	params.push('action=ajax');
	params.push('title=' + encodeURIComponent(window.parent.wgPageName));
	params.push('rs=WysiwygParseWikitext');
	params.push('rsargs[]=' + encodeURIComponent(wikitext));

	if (useWysiwygParser) {
		params.push('wysiwyg=1');
	}

	// send request
	FCK.YAHOO.util.Connect.asyncRequest(
		'POST',
		((window.parent.wgScript == null) ? (window.parent.wgScriptPath + "/index.php") : window.parent.wgScript),
		callback,
		params.join('&')
	);
}

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
					FCK.YD.removeClass(link, 'new');
					link.href = window.parent.wgServer + window.parent.wgArticlePath.replace(/\$1/, encodeURI(title.replace(/ /g, '_')));
				} else {
					FCK.YD.addClass(link, 'new');
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

//
// support for non-editable images
//

// image overlay with edit/delete link
FCK.ProtectImageOverlay = false;

FCK.ProtectImage = function(image) {
	var refid = parseInt(image.getAttribute('refid'));

	// for browsers supporting contentEditable
	if (FCK.UseContentEditable) {
		// don't use iframes -> use contentEditable
		image.setAttribute('contentEditable', false);

		// apply contentEditable to all child nodes of image
		FCK.YD.getElementsBy(
			function(node) {
				return true;
			},
			false,
			image,
			function(node) {
				node.setAttribute('contentEditable', false);
			}
		);

		// setup events (remove listener first to avoid multiple event firing)
		FCKTools.RemoveEventListener(image, 'click', FCK.ImageProtectOnClick);
		FCKTools.AddEventListener(image, 'click', FCK.ImageProtectOnClick);

		FCKTools.RemoveEventListener(image, 'mousedown', FCK.ImageProtectOnMousedown);
		FCKTools.AddEventListener(image, 'mousedown', FCK.ImageProtectOnMousedown);

		FCKTools.RemoveEventListener(image, 'mouseup', FCK.ImageProtectOnMouseup);
		FCKTools.AddEventListener(image, 'mouseup', FCK.ImageProtectOnMouseup);

		FCK.BlockEvent(image, 'contextmenu');

		// check whether given image exists
		FCK.wysiwygData[refid].exists = image.nodeName.IEquals('a')
			? (!FCK.YD.hasClass(image, 'new'))
			: !( /class=\"new\"/.test(image.innerHTML) );

		// store node with refId
		FCK.NodesWithRefId[ refid ] = image;

		// image overlay menu (edit / delete)
		FCK.ImageProtectSetupOverlayMenu(refid, image); // image.nodeName.IEquals('a') ? image : image.firstChild);

		return;
	}

	//
	// support older browsers
	//
	var iframe = FCK.EditingArea.Document.createElement('iframe');
	var coveringDiv = FCK.EditingArea.Document.createElement('div');

	// fix FF2.x issue with iframes with "generated content": use "ajax" html provider
	iframe.src = window.parent.wgServer + window.parent.wgScript + '?action=ajax&rs=WysiwygImage&title=' + encodeURIComponent(window.parent.wgPageName) + '&wikitext=' + encodeURIComponent(FCK.wysiwygData[refid].original);

	iframe.name = 'image' + refid;

	iframe.setAttribute('refid', refid);
	iframe.className = image.className;

	// get image size to create proper cover
	if (image.nodeName.IEquals('a')) {
		var size = {width: image.firstChild.width, height: image.firstChild.height + 6};
	}
	else if (image.nodeName.IEquals('iframe')) {
		var size = {width: image.style.width, height: parseInt(image.style.height) + 6};
	}
	else {
		var size = {width: image.firstChild.style.width, height: image.clientHeight + 6};
	}

	FCK.log(image); FCK.log(size);

	// external CSS may not be fully loaded - use style value from inline CSS for width
	iframe.style.width = parseInt(size.width) + 20 + 'px';
	iframe.style.height = parseInt(size.height) + 6 + 'px';
	iframe.style.border = 'none';
	iframe.style.overflow = 'hidden';

	// DOM stuff
	image.parentNode.insertBefore(iframe, image);
	image.parentNode.removeChild(image);

	// update list of nodes with refId
	FCK.NodesWithRefId[refid] = iframe;

	// iframe covering div
	var docObj = FCKTools.GetElementDocument(FCK.EditingArea.TargetElement);

	coveringDiv = docObj.getElementById('cover' + refid);

	if (!coveringDiv) {
		// create cover
		coveringDiv = docObj.createElement('DIV');
		coveringDiv.id = 'cover' + refid;
		coveringDiv.setAttribute('refid', refid);
		docObj.body.appendChild(coveringDiv);
	}

	coveringDiv.className = 'cover ' + image.className;
	coveringDiv.style.width = iframe.style.width;
	coveringDiv.style.height = iframe.style.height;
	coveringDiv.style.position = 'absolute';
	coveringDiv.style.cursor = 'pointer';
	//coveringDiv.style.border = 'solid 1px red';
	coveringDiv.innerHTML = '&nbsp;';

	FCK.ProtectImageRepositionCover(refid);

	// check whether given image exists
	var re = /class=\"new\"/;
	FCK.wysiwygData[refid].exists = !re.test(image.innerHTML);

	// image overlay menu (edit / delete)
	FCK.ImageProtectSetupOverlayMenu(refid, coveringDiv);
}

// go up the DOM tree to find image root element based on its child
FCK.GetParentImage = function(child) {
	var node = child;

	while (node && node.getAttribute && !FCK.YAHOO.lang.isNumber( parseInt(node.getAttribute('refid'))) ) {
		node = node.parentNode;
	}

	if ( node && node.getAttribute && FCK.YAHOO.lang.isNumber(parseInt(node.getAttribute('refid'))) ) {
		return node;
	}
	else {
		return false;
	}
}

FCK.ImageProtectOnClick = function(e) {
	var e = FCK.YE.getEvent(e);
	var target = FCK.YE.getTarget(e);

	FCK.YE.stopEvent(e);

	// ignore buttons different then left
	if (e.button == 0) {

		var image = FCK.GetParentImage(target);
		var refid = parseInt(image.getAttribute('refid'));

		FCK.log('image #' + refid  + ' clicked');
		// choose action based on original target CSS class
		switch (target.className) {
			case 'imageOverlayRemove':
				FCK.ProtectImageRemove(refid);
				break;

			case 'imageOverlayEdit':
				FCK.ProtectImageEdit(refid);
				break;
		}
	}
};

FCK.ImageProtectOnMousedown = function(e) {
	var e = FCK.YE.getEvent(e);
	var target = FCK.YE.getTarget(e);

	if (target.className == 'imageOverlayDrag') {

		var image = FCK.GetParentImage(target);
		var refid = parseInt(image.getAttribute('refid'));

		FCK.log('image #' + refid  + ' drag&drop catched');

		FCK.Track('/image/move');

		// select whole image
		FCK.Selection.SelectNode(image);
		FCK.ImageDragDrop = image;
	}
	else {
		FCK.YE.stopEvent(e);
	}
};

FCK.ImageProtectOnMouseup = function(e) {
	FCK.YE.stopEvent( FCK.YE.getEvent(e) );

	// unselect any selection
	var selection = FCKSelection.GetSelection();
	if (selection.removeAllRanges) {
		selection.removeAllRanges();
	}
};


// set images iframe overlaying divs (FF2.x)
FCK.ImageProtectSetupOverlayMenu = function(refid, div) {

	// remove old overlayMenu (if any)
	if (div.lastChild && div.lastChild.nodeName.IEquals('span') && FCK.YD.hasClass(div.lastChild,'imageOverlay')) {
		FCKDomTools.RemoveNode(div.lastChild);
	}

	div.setAttribute('refid', refid);

	var docObj = FCKTools.GetElementDocument(div);

	var overlay = docObj.createElement('SPAN');

	// position menu based on alignment of an image
	overlay.className = 'imageOverlay' + (FCK.YD.hasClass(div, 'thumb') ?  ' imageOverlayRight' : '');
	overlay.style.visibility = 'hidden';

	div.style.position = 'relative';

	// move to the upper corner when image is wrapped using <a>
	if (div.nodeName.IEquals('a') && !FCKBrowserInfo.IsIE) {
		var height = parseInt(div.firstChild.offsetHeight / 2);
		overlay.style.top = (-height + 8) + 'px';
	}

	div.appendChild(overlay);

	overlay.innerHTML = '<span class="imageOverlayEdit" onclick="FCK.ProtectImageEdit('+refid+')">' + FCKLang.DlgSelectBtnModify + '</span><span class="imageOverlayRemove" onclick="FCK.ProtectImageRemove('+refid+')">' + FCKLang.DlgSelectBtnDelete + '</span>';

	// add "move" option for images handled by contentEditable
	if (FCK.UseContentEditable) {
		overlay.innerHTML += '<span class="imageOverlayDrag">move</span>';
	}

	// show overlay menu
	FCKTools.AddEventListener(div, 'mouseover', function(e) {
		overlay.style.visibility = 'visible';
	});

	// hide overlay menu
	FCKTools.AddEventListener(div, 'mouseout', function(e) {
		overlay.style.visibility = 'hidden';
	});
}


FCK.ProtectImageRepositionCover = function(refid) {

	if (FCK.EditMode == 1) {
		// leave when switched to source mode
		return;
	}

	var iframe = FCK.GetElementByRefId(refid);
	var cover = FCKTools.GetElementDocument(FCK.EditingArea.TargetElement).getElementById('cover' + refid);

	if (!iframe) {
		// image has just been removed
		FCKDomTools.RemoveNode(cover);
		return;
	}

	var xy = FCK.YD.getXY(iframe);
	var offsetY = FCK.EditorDocument.body.scrollTop;

	FCK.YD.setXY(cover, [xy[0],xy[1] -  offsetY + 30]);
	cover.style.width = iframe.style.width;
	cover.style.height = iframe.style.height;

	// recalculate after 750ms
	setTimeout('FCK.ProtectImageRepositionCover('+refid+')', 750);
}

// handle images edit
FCK.ProtectImageEdit = function(refid) {

	FCK.log('click on image #' + refid);
	FCK.log(FCK.wysiwygData[refid]);

	// tracker
	FCK.Track('/image/click');

	// open WikiaMiniUpload
	window.parent.WMU_show( parseInt(refid) );
}

// remove image from the article
FCK.ProtectImageRemove = function(refid, dontAsk) {
	var callback = function() {
		FCKUndo.SaveUndoStep();

		FCK.log('removed image #' + refid);

		var node = FCK.GetElementByRefId(refid);

		FCKDomTools.RemoveNode(node);

		// clear meta data
		delete FCK.wysiwygData[refid];
		delete FCK.NodesWithRefId[refid];

		// tracker
		FCK.Track('/image/remove');
	}

	if (dontAsk) {
		callback();
	} else {
		FCK.ShowConfirm('Are you sure you want to remove this image?', 'Remove this image', callback);
	}
}

// to simplify things we actually replace old image with the new one
FCK.ProtectImageUpdate = function(refid, wikitext, extraData) {
	FCK.log('updating #' + refid +' with >>' + wikitext + '<<');

	FCK.Track('/image/update');

	FCKUndo.SaveUndoStep();

	// update metaData
	var params = wikitext.substring(2, wikitext.length-2).split('|');
	FCK.wysiwygData[refid].href = params.shift();
	FCK.wysiwygData[refid].description = params.join('|');
	FCK.wysiwygData[refid].original = wikitext;

	// merge with extraData
	FCK.wysiwygData[refid] = FCK.YAHOO.lang.merge(FCK.wysiwygData[refid], extraData);

	FCK.log(FCK.wysiwygData[refid]);

	// parse given wikitext
	var callback = {
		success: function(o) {
			FCK = o.argument.FCK;
			refid =  o.argument.refid;

			var oldImage = FCK.GetElementByRefId(refid);
			FCK.log(oldImage);

			result = eval('(' + o.responseText + ')');
			html = result.parse.text['*'];

			// remove newPP comment and whitespaces
			html = FCK.YAHOO.lang.trim(html.split('<!-- \nNewPP limit report')[0]);

			// insert html into editing area (before old image)...
			var wrapper = FCKTools.GetElementDocument(oldImage).createElement('DIV');

			// fix IE's "unknown runtine error" by always adding wrapper before block elements (FF will try to validate, IE will throw an error)
			// @see http://piecesofrakesh.blogspot.com/2007/02/ies-unknown-runtime-error-when-using.html
			if (oldImage.nodeName.IEquals('a') && FCKBrowserInfo.IsIE) {
				oldImage.parentNode.parentNode.insertBefore(wrapper, oldImage.parentNode);
			}
			else {
				oldImage.parentNode.insertBefore(wrapper, oldImage);
			}

			// set HTML
			wrapper.innerHTML = html;

			// is "simple" image wrapped by <p></p> ?
			if (html.substr(0,3) == '<p>') {
				// remove wrapping <p></p>
				wrapper.innerHTML = html.substr(3, html.length-7);
			}

			// ...and "protect" it
			wrapper.firstChild.setAttribute('refid', refid);
			FCK.ProtectImage(wrapper.firstChild);

			// remember current values of _wysiwyg_new_line and _wysiwyg_line_start attributes
			if (oldImage.getAttribute('_wysiwyg_new_line')) {
				wrapper.firstChild.setAttribute('_wysiwyg_new_line', true);
			}

			if (oldImage.getAttribute('_wysiwyg_line_start')) {
				wrapper.firstChild.setAttribute('_wysiwyg_line_start', true);
			}

			// remove wrapper and old image
			FCKDomTools.RemoveNode(oldImage, false); // including child nodes
			FCKDomTools.RemoveNode(wrapper, true); // excluding child nodes
		},
		failure: function(o) {},
		argument: {'FCK': FCK, 'refid': refid}
	}

	FCK.YAHOO.util.Connect.asyncRequest(
		'POST',
		window.parent.wgScriptPath + '/api.php',
		callback,
		"action=parse&format=json&prop=text&title=" + encodeURIComponent(window.parent.wgPageName) + "&text=" +  encodeURIComponent(wikitext)
	);
}

FCK.ProtectImageAdd = function(wikitext, extraData) {
	var refid = FCK.GetFreeRefId();

	FCK.log('adding new image #' + refid + ' using >>' + wikitext + '<<');

	FCK.Track('/image/add');

	// fill metaData up
	var params = wikitext.substring(2, wikitext.length-2).split('|');
	FCK.wysiwygData[refid] = {
		'type': 'image',
		'href': params.shift(),
		'description': params.join('|'),
		'original': wikitext,
		'exists': true
	};

	// merge with extraData
	FCK.wysiwygData[refid] = FCK.YAHOO.lang.merge(FCK.wysiwygData[refid], extraData);

	// parse given wikitext
	var callback = {
		success: function(o) {
			FCK = o.argument.FCK;
			refid =  o.argument.refid;

			result = eval('(' + o.responseText + ')');
			html = result.parse.text['*'];

			// remove newPP comment and whitespaces
			html = FCK.YAHOO.lang.trim(html.split('<!-- \nNewPP limit report')[0]);

			// insert html into editing area...
			var wrapper = FCK.EditorDocument.createElement('DIV');
			FCK.InsertElement(wrapper);
			wrapper.innerHTML = html;

			// is "simple" image wrapped by <p></p> ?
			if (html.substr(0,3) == '<p>') {
				// remove wrapping <p></p>
				wrapper.innerHTML = html.substr(3, html.length-7);
			}

			// ...and "protect" it
			wrapper.firstChild.setAttribute('refid', refid);
			FCK.ProtectImage(wrapper.firstChild);

			// remove wrapper
			FCKDomTools.RemoveNode(wrapper, true);

			FCK.log(FCK.wysiwygData[refid]);
		},
		failure: function(o) {},
		argument: {'FCK': FCK, 'refid': refid}
	}

	FCK.YAHOO.util.Connect.asyncRequest(
		'POST',
		window.parent.wgScriptPath + '/api.php',
		callback,
		"action=parse&format=json&prop=text&title=" + encodeURIComponent(window.parent.wgPageName) + "&text=" +  encodeURIComponent(wikitext)
	);
}

//
// onmouseover template preview
//

FCK.TemplatePreviewCloud = false;
FCK.TemplatePreviewTimeouts = {Tag: false, Cloud: false};

FCK.TemplatePreviewInit = function() {
	if (FCK.TemplatePreviewCloud) {
		FCK.TemplatePreviewCloud.parentNode.removeChild(FCK.TemplatePreviewCloud);
		FCK.TemplatePreviewCloud = false;
		FCK.TemplatePreviewTimeouts = {Tag: false, Cloud: false};
	}
}

FCK.TemplatePreviewAdd = function(placeholder) {

	var docObj = FCKTools.GetElementDocument(FCK.EditingArea.TargetElement);

	// initialize preview cloud
	if (!FCK.TemplatePreviewCloud) {
		FCK.TemplatePreviewCloud = docObj.createElement('DIV');
		docObj.body.appendChild(FCK.TemplatePreviewCloud);

		FCK.TemplatePreviewCloud.id = 'wysiwygTemplatePreviewCloud';
		FCK.TemplatePreviewCloud.innerHTML = '<div id="wysiwygTemplatePreviewCloudInner"></div>';

		FCKTools.AddEventListener(FCK.TemplatePreviewCloud, 'mouseover', function(e) {
			// clear timeouts
			clearTimeout(FCK.TemplatePreviewTimeouts.Tag);
			clearTimeout(FCK.TemplatePreviewTimeouts.Cloud);
		});

		FCKTools.AddEventListener(FCK.TemplatePreviewCloud, 'mouseout', function(e) {
			// hide preview 1 sec. after mouseout from cloud
			FCK.TemplatePreviewTimeouts.Cloud = setTimeout('FCK.TemplatePreviewHide()', 1000);
		});
	}

	var refId = placeholder.getAttribute('refid');

	// remove any existing preview cloud
	var previewDiv = docObj.getElementById('wysiwygTemplatePreview' + refId);

	if (previewDiv) {
		FCKDomTools.RemoveNode(previewDiv);
	}

	// copy template previews to clouds
	var preview = placeholder.nextSibling;
	previewDiv = docObj.createElement('div');

	FCK.TemplatePreviewCloud.firstChild.appendChild( previewDiv );

	previewDiv.id = 'wysiwygTemplatePreview' + refId;
	placeholder.title = 'Click to edit this template or use drag&drop to move template';

	// try to use cached preview from wysiwygData
	previewDiv.innerHTML = (FCK.wysiwygData[refId].preview ? FCK.wysiwygData[refId].preview : preview.value);
	previewDiv.setAttribute('refid', refId);

	// sometimes innerHTML contains whitespices at the end -> fix it
	previewDiv.innerHTML = previewDiv.innerHTML.Trim();
	previewDiv.style.display = 'none';

	// reset template's margin/padding/align
	FCK.TemplatePreviewReset(previewDiv);

	// remove preview div from editing area and store preview in wysiwygData
	if (preview && preview.nodeName.IEquals('input') && preview.type == 'text') {
		preview.parentNode.removeChild(preview);
		FCK.wysiwygData[refId].preview = previewDiv.innerHTML;
	}

	// setup events (remove listener first to avoid multiple event firing)
	FCKTools.RemoveEventListener(placeholder, 'mouseover', FCK.TemplatePreviewOnPlaceholderMouseover);
	FCKTools.RemoveEventListener(placeholder, 'mouseout', FCK.TemplatePreviewOnPlaceholderMouseout);
	FCKTools.RemoveEventListener(placeholder, 'click', FCK.TemplatePreviewOnPlaceholderClick);
	FCKTools.RemoveEventListener(previewDiv, 'click', FCK.TemplatePreviewOnPreviewClick);

	// register events handlers
	FCKTools.AddEventListener(placeholder, 'mouseover', FCK.TemplatePreviewOnPlaceholderMouseover);
	FCKTools.AddEventListener(placeholder, 'mouseout', FCK.TemplatePreviewOnPlaceholderMouseout);

	// events firing template editor
	FCKTools.AddEventListener(placeholder, 'click', FCK.TemplatePreviewOnPlaceholderClick);
	FCKTools.AddEventListener(previewDiv, 'click', FCK.TemplatePreviewOnPreviewClick);
}

FCK.TemplatePreviewOnPlaceholderMouseover = function(e) {
	FCK.TemplatePreviewShow( FCK.YE.getTarget(e) );

	clearTimeout(FCK.TemplatePreviewTimeouts.Tag);
	clearTimeout(FCK.TemplatePreviewTimeouts.Cloud);
}

FCK.TemplatePreviewOnPlaceholderMouseout = function(e) {
	// hide preview 0,5 sec. after mouseout from tag
	FCK.TemplatePreviewTimeouts.Tag = setTimeout('FCK.TemplatePreviewHide()', 500);
}

FCK.TemplatePreviewOnPlaceholderClick = function(e) {
	var e = FCK.YE.getEvent(e);
	var target = FCK.YE.getTarget(e);
	var refid = target.getAttribute('refid');

	FCK.TemplateWizard = {'name':FCK.wysiwygData[refid].name,'params':FCK.wysiwygData[refid].templateParams,'refid':refid};
	FCK.TemplateClickCommand.Execute();
}

FCK.TemplatePreviewOnPreviewClick = function(e) {
	// prevent clicking on links inside template preview
	FCK.YE.stopEvent( FCK.YE.getEvent(e) );
	var refid = FCK.TemplatePreviewCloud.getAttribute('refid');

	FCK.TemplateWizard = {'name':FCK.wysiwygData[refid].name,'params':FCK.wysiwygData[refid].templateParams,'refid':refid};
	FCK.TemplateClickCommand.Execute();
}


// show template preview
FCK.TemplatePreviewShow = function(placeholder) {

	var refId = placeholder.getAttribute('refid');
	var preview = FCKTools.GetElementDocument(FCK.TemplatePreviewCloud).getElementById('wysiwygTemplatePreview' + refId);

	// hide all previews / show just the one we need
	var previews = FCK.TemplatePreviewCloud.firstChild.childNodes;

	for (p=0; p<previews.length; p++) {
		previews[p].style.display = 'none';
	}

	preview.style.display = '';

	// toolbar height (the one build in FCK)
	var toolbarY = FCK.ToolbarSet._TargetElement.offsetHeight;

	// calculate cloud placement
	var x = FCK.YD.getX(placeholder);
	var y = FCK.YD.getY(placeholder) + placeholder.clientHeight + toolbarY + 5;

	// editor area scroll
	var scrollXY = [FCK.EditorDocument.body.scrollLeft, FCK.EditorDocument.body.scrollTop];

	// calculate preview position
	var cloudPos = {x: parseInt(x - scrollXY[0]), y: parseInt(y - scrollXY[1])};

	// should we show preview over the placeholder?
	var iFrameHeight = FCK.EditingArea.IFrame.offsetHeight;
	var previewHeight = preview.offsetHeight < 250 ? preview.offsetHeight : 250;
	var showUnder = true;

	// reset preview height
	FCK.TemplatePreviewCloud.firstChild.style.height = 'auto';

	if (cloudPos.y + previewHeight > iFrameHeight) {
		// if needed decrease preview height
		if (cloudPos.y < 280) {
			previewHeight = cloudPos.y - 80;
			FCK.TemplatePreviewCloud.firstChild.style.height = previewHeight + 'px';
		}

		// show it over the placeholder
		cloudPos.y -= parseInt(placeholder.clientHeight + 25 + previewHeight);
		showUnder = false;
	}

	// set preview position
	FCK.TemplatePreviewCloud.style.left = cloudPos.x + 'px';
	FCK.TemplatePreviewCloud.style.top = cloudPos.y + 'px';

	// show template preview and cloud
	FCK.TemplatePreviewCloud.style.display = 'block';
	FCK.TemplatePreviewCloud.className = showUnder ? 'cloudUnder' : 'cloudOver';

	FCK.TemplatePreviewCloud.setAttribute('refid', refId);
}

FCK.TemplatePreviewHide = function() {
	FCK.TemplatePreviewCloud.style.display = 'none';
}

// set/get preview cloud HTML for given template
FCK.TemplatePreviewSetHTML = function(refid, html) {
	var preview = FCKTools.GetElementDocument(FCK.TemplatePreviewCloud).getElementById('wysiwygTemplatePreview' + refid);
	preview.innerHTML = html;

	FCK.wysiwygData[refid].preview = html;

	// reset margin/padding/align
	FCK.TemplatePreviewReset(preview);

	FCK.log('saved template preview for #' + refid);
}

FCK.TemplatePreviewGetHTML = function(refid) {
	return FCK.wysiwygData[refid].preview;
}

FCK.TemplatePreviewSetName = function(refid, name) {
	var input = FCK.GetElementByRefId(refid);
	input.value = FCK.YAHOO.lang.trim(name);
}

// reset template preview margins/padding/float/align
FCK.TemplatePreviewReset = function(previewDiv) {
	if (previewDiv.firstChild && previewDiv.firstChild.nodeType == 1) {
		FCK.YD.addClass(previewDiv.firstChild, 'resetTemplate');
		previewDiv.firstChild.removeAttribute('align');
	}
}

//
// InsertTemplate - dropdown in menu
//
var FCKInsertTemplateCommand = function() {
	this.Name = 'InsertTemplate' ;
}

FCKInsertTemplateCommand.prototype = {
	Execute : function(name) {
		oInsertTemplateItem._Combo.SetLabel(oInsertTemplateItem.DefaultLabel);

		if(name == ':other:') {
			// user will select template (step #1)
			FCK.TemplateWizard = {};
			FCK.TemplateClickCommand.Execute();
		} else {
			FCK.Track('/templateEditor/dropdown/' + name);
			if(FCK.templateList[name].params) {
				// template selected from drop down has parameters (step #2)
				FCK.TemplateWizard = {'name':name, 'params':FCK.templateList[name].params, 'refid':-1};
				FCK.TemplateClickCommand.Execute();
			} else {
				// template selected from drop down has no parameters (add to article)
				FCK.InsertTemplate(-1, name, null);
			}
		}
	},
	GetState : function() {
		if(FCK.EditMode != FCK_EDITMODE_WYSIWYG) return FCK_TRISTATE_DISABLED;
		return FCK_TRISTATE_OFF;
	}
};

// generate wikitext for template
FCK.GenerateTemplateWikitext = function(name, params) {
	var wikitext = '';

	wikitext = '{{' + name;

	var paramsCount = 0;
	var longestParam = 0;

	// find length of the longest param
	for (key in params) {
		if ( (params[key] != '') && (longestParam < key.length) ) {
			longestParam = key.length;
		}
	}

	// parameters name and value
	for(key in params) {
		var value = FCK.YAHOO.Tools.trim(params[key]);

		if (value == '') continue; // ignore empty parameters

		var fill = FCK.YAHOO.Tools.stringRepeat(' ', longestParam - key.length);

		wikitext += '\n|' + key + fill + ' = ' + value;
		paramsCount++;
	}

	// close template markup
	wikitext += (paramsCount ? '\n}}' : '}}');

	// debug
	FCK.log('template wikisyntax >>' + wikitext + '<< (longest param: ' + longestParam + ')');

	return wikitext;
}

// add new / update template
FCK.InsertTemplate = function(refid, name, params) {
	FCK.log([refid, name, params]);

	var placeholder;

	if (refid > -1) {
		FCK.log('updating template #'+refid);
		var placeholder = FCK.GetElementByRefId(refid);
	}
	else {
		refid = FCK.GetFreeRefId();

		FCK.log('inserting new template as #'+refid);

		// create new placeholder and add it to the article
		placeholder = FCK.EditorDocument.createElement('INPUT');
		placeholder.className = 'wysiwygDisabled wysiwygTemplate';
		placeholder.type = 'button';
		placeholder.value = name;
		placeholder.setAttribute('refid', refid);
		placeholder.setAttribute('_fck_type', 'template');

		FCK.InsertElement(placeholder);

		// add entry to metaData
		FCK.wysiwygData[refid] = {
			'type': 'template'
		}

		FCK.NodesWithRefId[refid] = placeholder;

		// fix placeholder by adding dirty <br /> tag
		FCK.FixWikitextPlaceholder(placeholder);
	}

	// update placeholder data
	placeholder.value = name;

	// generate new wikitext
        var wikitext = FCK.GenerateTemplateWikitext(name, params);

	// update metaData and send AJAX request to generate template preview
	FCK.wysiwygData[refid].name = name;
	FCK.wysiwygData[refid].originalCall = wikitext;
	FCK.wysiwygData[refid].templateParams = params;
	FCK.wysiwygData[refid].preview = '<p><em>please wait</em></p>';

	FCK.log(FCK.wysiwygData[refid]);

	// add placeholder event handlers
	FCK.TemplatePreviewAdd(placeholder);

	// generate template preview
	FCK.ParseWikitext(wikitext, function(html, FCK, data) {
		refid = data.refid;

		// update metaData entry and preview
		FCK.wysiwygData[refid].preview = html;
		FCK.TemplatePreviewAdd(FCK.GetElementByRefId(refid));

		FCK.log('template #'+refid+' preview updated');
	}, {
		'refid': refid
	});
}


FCKCommands.RegisterCommand('InsertTemplate', new FCKInsertTemplateCommand());

var FCKToolbarInsertTemplateCombo = function(tooltip, style) {
	this.CommandName	= 'InsertTemplate';
	this.Label = this.GetLabel();

	this.Tooltip = tooltip ? tooltip : this.Label;
	this.Style = style ? style : FCK_TOOLBARITEM_ICONTEXT;

	this.DefaultLabel = 'Insert template';
	this.FieldWidth = 120 ;
}

FCKToolbarInsertTemplateCombo.prototype = new FCKToolbarSpecialCombo;
FCKToolbarInsertTemplateCombo.prototype.GetLabel = function() {
	return '';
}

FCKToolbarInsertTemplateCombo.prototype.CreateItems = function( targetSpecialCombo ) {
	// name - description
	FCK.templateList = window.parent.templateList;

	for(key in FCK.templateList) {
		targetSpecialCombo.AddItem(key, (FCK.templateList[key].desc) ? FCK.templateList[key].desc : FCK.templateList[key].name);
	}
	targetSpecialCombo.AddItem(":other:", "Other template / magic word", '', true);
}

var oInsertTemplateItem = new FCKToolbarInsertTemplateCombo();
FCKToolbarItems.RegisterItem('InsertTemplate', oInsertTemplateItem);


// regenerate elements with refid after redo/undo
FCK.Events.AttachEvent("OnUndoRedo", function() {
	FCK.log('undo/redo catched');
	FCK.SetupElementsWithRefId();
});

//
// runtime setup
//

// YUI reference
FCK.YAHOO = window.parent.YAHOO;
FCK.YD = FCK.YAHOO.util.Dom;
FCK.YE = FCK.YAHOO.util.Event;

// jQuery reference
FCK.jQuery = window.parent.jQuery;

// log functionality
FCK.log = function(msg) {
	window.parent.$().log(msg, 'Wysiwyg');
}

// macbre: setup tracker object
FCK.Track = function(fakeUrl) {
	window.parent.WET.byStr('wysiwyg'+fakeUrl);
}

// performs quick diff between two strings (original and one with pasted content)
// and returns pasted content
// example: FCK.Diff('<br/><b>', '<br/><foo><b>') => <foo>
// example: FCK.Diff('<br/><span><b>', '<br/><foo><b>') => <foo>
FCK.Diff = function(o, n) {
	// speed-up
	if (o == n) {
		return null;
	}

	var lenDiff = o.length - n.length;
	var idx = {start: 0, end: n.length - 1};

	// search for prefix and suffix common for old and new string
	while (o.charAt(idx.start) == n.charAt(idx.start)) {
		if (idx.start >= o.length) {
			return null;
		}
		idx.start++;
	}

	while (o.charAt(idx.end+lenDiff) == n.charAt(idx.end)) {
		if (idx.end <= idx.start) {
			return null;
		}
		idx.end--;
	}

	// get unchanged parts at the beginning and at the end of diff
	var prefix = n.substring(0, idx.start+1);
	var suffix = n.substring(idx.end, n.length);

	// fix HTML by finding closing > and opening < in suffix and prefix respectively
	if (/<[^>]*$/.test(prefix)) {
		// go to last < in prefix
		idx.start = prefix.lastIndexOf('<');
	}

	if (/^[^<]*>/.test(suffix)) {
		// go to first > in suffix
		idx.end += suffix.indexOf('>') + 1;
	}

	// get changed fragment
	var pasted = n.substring(idx.start, idx.end);

	return {html: pasted, index: idx.start, 'new': n, 'old': o};
}

// RT #14699
FCK._CheckPasteOldHTML = false;
FCK._CheckPasteChecks = 0;
FCK.CheckPaste = function() {
	FCK.log('CheckPaste');

	// block pasting until FCK.CheckPasteCompare is fired
	if (FCK._CheckPasteOldHTML != false) {
		FCK.log('CheckPaste in progress');
		return false;
	}

	// store HTML before paste
	FCK._CheckPasteOldHTML = FCK.EditorDocument.body.innerHTML;

	// check every 10ms
	FCK._CheckPasteChecks = 0;
	setTimeout(FCK.CheckPasteCompare, 10);

	return true;
}

FCK.CheckPasteCompare = function() {
	FCK.log('CheckPasteCompare');

	FCK._CheckPasteChecks++;

	var newHTML = FCK.EditorDocument.body.innerHTML;
	var oldHTML = FCK._CheckPasteOldHTML;

	// nothing has changed, keep trying...
	if (newHTML == oldHTML) {
		if (FCK._CheckPasteChecks > 50) {
			FCK.log('CheckPasteCompare timed out');

			// unblock paste
			FCK._CheckPasteOldHTML = false;
		}
		else {
			setTimeout(FCK.CheckPasteCompare, 10);
		}
		return;
	}

	var diff = FCK.Diff(oldHTML, newHTML);

	FCK.log(diff);

	if (diff != null) {
		// check for _fck_editor_instance attribute
		var editorInstance = diff.html.match(/_fck_editor_instance="(\d+)"[^>]*>/);

		if (editorInstance != null && (parseInt(editorInstance[1]) != FCK.EditorInstanceId) ) {
			FCK.log('Pasted from different editor instance!');
			FCK.Track('/paste/outside');

			// TODO: messagize
			FCK.ShowInfoDialog('To copy from another article you must first click the "wikitext source mode" button on the toolbar of both the original and new pages');

			// replace with old HTML and set events on placeholders
			FCK.EditorDocument.body.innerHTML = oldHTML;
			FCK.SetupElementsWithRefId();

			// unblock paste
			FCK._CheckPasteOldHTML = false;

			return;
		}

		// search for refid attributes in pasted HTML
		var re = /refid="(\d+)"[^>]*>/g;
		var matches = [];

		while (match = re.exec(diff.html)) {
			matches.push(match);
		}

		// scan refids found in pasted HTML
		if (matches.length > 0) {
			// don't touch the begining of HTML
			var html = newHTML.substr(0, diff.index);

			// here's HTML we're going to change
			var newHTML = newHTML.substring(diff.index, newHTML.length);

			// make replacement in diff
			for(n=0; n<matches.length; n++) {
				var refid = parseInt(matches[n][1]);
				FCK.log('Checking refid #' + refid);

				// generate new refid
				var newRefId = FCK.GetFreeRefId();

				// copy meta-data into new refid
				FCK.wysiwygData[newRefId] = window.parent.$().extend(true, {}, FCK.wysiwygData[refid]);
				FCK.log('New refid #' + newRefId);

				// replace old refid with new one
				var re = new RegExp('refid="' + refid + '"([^>]*>)');
				newHTML = newHTML.replace(re, 'refid="' + newRefId + '"$1');
			}

			//FCK.log(newHTML);

			FCK.Track('/paste/inside');

			// set new HTML and events on placeholders
			FCK.EditorDocument.body.innerHTML = html + newHTML;
			FCK.SetupElementsWithRefId();
		}
		else {
			FCK.Track('/paste/plainText');
		}
	}

	// unblock paste
	FCK._CheckPasteOldHTML = false;
}

// autosuggest setup function
FCK.EnableAutocomplete = function(field, onSelectFunc, searchTemplates) {
	FCK.jQuery.getScript(window.parent.stylepath + '/common/jquery/jquery.autocomplete.js?' + FCKConfig.StyleVersion, function() {
		// use LinkSuggest extension
		var url = window.parent.wgServer + window.parent.wgScript + '?action=ajax&rs=getLinkSuggest&format=json';

		if (searchTemplates) {
			url += '&ns=10';
		}

		FCK.jQuery(field).autocomplete({
			serviceUrl: url,
			fnFormatResult: function(v) {
				return v;
			},
			onSelect: function(v, d) {
				if (typeof onSelectFunc == 'function') {
					onSelectFunc();
				}
			},
			deferRequestBy: 110,
			delimiter: "\n",
			maxHeight: 110,
			appendTo: FCK.jQuery(field).parent().parent()
		});
	});
}

// track the fact of using FCK
FCK.Track('/init');

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

// browsers supporting "contentEditable"
FCK.UseContentEditable = FCKBrowserInfo.IsIE || FCKBrowserInfo.IsGecko19; // IE6+ and FF3

if (FCK.UseContentEditable) {
	FCK.log('using contentEditable');
}

// for us, developers ;)
FCK.BrowserInfo = FCKBrowserInfo;
window.parent.FCK = FCK;
