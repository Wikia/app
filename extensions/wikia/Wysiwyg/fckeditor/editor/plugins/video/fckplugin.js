// "add video" toolbar button
var FCKAddVideoCommand = function() {
	this.Name = 'AddVideo' ;

	this.IsEnabled = (typeof window.parent.vet_enabled != 'undefined');
}
FCKAddVideoCommand.prototype = {
	Execute : function() {
		FCKUndo.SaveUndoStep() ;
		FCK.log('opening "add video" dialog');
		window.parent.VET_show(-1);
	},
	GetState : function() {
		if ( (FCK.EditMode != FCK_EDITMODE_WYSIWYG) || (this.IsEnabled == false) )
			return FCK_TRISTATE_DISABLED ;
		return FCK_TRISTATE_OFF;
	}
} ;

// register FCK command
FCKCommands.RegisterCommand('AddVideo', new FCKAddVideoCommand());

// toolbar item icon
var oTildesItem = new FCKToolbarButton( 'AddVideo', 'Add video' ) ;
oTildesItem.IconPath = FCKConfig.PluginsPath + 'video/addVideo.png';

// register toolbar item
FCKToolbarItems.RegisterItem( 'AddVideo', oTildesItem );

// video overlay with edit/delete link
FCK.VideoOverlay = false;

// protect video placeholder
FCK.ProtectVideo = function(video) {
	var refid = parseInt(video.getAttribute('refid'));
	
	// for browsers supporting contentEditable
	if (FCK.UseContentEditable) {
		video.setAttribute('contentEditable', false);

		// apply contentEditable to all child nodes of video
		FCK.YD.getElementsBy(
			function(node) {
				return true;
			},
			false,
			video,
			function(node) {
				node.setAttribute('contentEditable', false);
			}
		);

		// setup events (remove listener first to avoid multiple event firing)
		FCKTools.RemoveEventListener(video, 'click', FCK.VideoOnClick);
		FCKTools.AddEventListener(video, 'click', FCK.VideoOnClick);

		FCKTools.RemoveEventListener(video, 'mousedown', FCK.VideoOnMousedown);
		FCKTools.AddEventListener(video, 'mousedown', FCK.VideoOnMousedown);

		FCKTools.RemoveEventListener(video, 'mouseup', FCK.VideoOnMouseup);
		FCKTools.AddEventListener(video, 'mouseup', FCK.VideoOnMouseup);

		FCK.BlockEvent(video, 'contextmenu');

		// store node with refId
		FCK.NodesWithRefId[ refid ] = video;

		// video overlay menu (edit / delete)
		FCK.VideoSetupOverlayMenu(refid, video);

		return;
	}
}

FCK.VideoOnClick = function(e) {
	var e = FCK.YE.getEvent(e);
	var target = FCK.YE.getTarget(e);

	FCK.YE.stopEvent(e);

	// ignore buttons different then left
	if (e.button == 0) {

		var video = FCK.GetParentImage(target);
		var refid = parseInt(video.getAttribute('refid'));

		FCK.log('video #' + refid  + ' clicked');
		// choose action based on original target CSS class
		switch (target.className) {
			case 'videoOverlayRemove':
				FCK.VideoRemove(refid);
				break;

			case 'videoOverlayEdit':
				FCK.VideoEdit(refid);
				break;
		}
	}
};

FCK.VideoOnMousedown = function(e) {
	var e = FCK.YE.getEvent(e);
	var target = FCK.YE.getTarget(e);

	if (target.className == 'videoOverlayDrag') {

		var video = FCK.GetParentImage(target);
		var refid = parseInt(video.getAttribute('refid'));

		FCK.log('video #' + refid  + ' drag&drop catched');

		FCK.Track('/video/move');

		// select whole video
		FCK.Selection.SelectNode(video);
		FCK.VideoDragDrop = video;
	}
	else {
		FCK.YE.stopEvent(e);
	}
};

FCK.VideoOnMouseup = function(e) {
	FCK.YE.stopEvent( FCK.YE.getEvent(e) );

	// unselect any selection
	var selection = FCKSelection.GetSelection();
	if (selection.removeAllRanges) {
		selection.removeAllRanges();
	}
};


// handle video edit
FCK.VideoEdit = function(refid) {

	FCK.log('click on video #' + refid);
	FCK.log(FCK.wysiwygData[refid]);

	// tracker
	FCK.Track('/video/click');

	// open VideoEmbedTool
	window.parent.VET_show( parseInt(refid) );
}

// remove video from the article
FCK.VideoRemove = function(refid, dontAsk) {
	if (dontAsk || confirm('Are you sure you want to remove this video?')) {

		FCKUndo.SaveUndoStep();

		FCK.log('removed video #' + refid);

		var node = FCK.GetElementByRefId(refid);

		FCKDomTools.RemoveNode(node);

		// clear meta data
		delete FCK.wysiwygData[refid];
		delete FCK.NodesWithRefId[refid];

		// tracker
		FCK.Track('/video/remove');
	}
}

// to simplify things we actually replace old video with the new one
FCK.VideoUpdate = function(refid, wikitext, extraData) {
	FCK.log('updating #' + refid +' with >>' + wikitext + '<<');

	FCK.Track('/video/update');

	FCKUndo.SaveUndoStep();

	// update metaData
	FCK.wysiwygData[refid] = {"type": "video", "original": wikitext};

	// merge with extraData
	FCK.wysiwygData[refid] = FCK.YAHOO.lang.merge(FCK.wysiwygData[refid], extraData);

	FCK.log(FCK.wysiwygData[refid]);

	// parse given wikitext
	var callback = {
		success: function(o) {
			FCK = o.argument.FCK;
			refid =  o.argument.refid;

			var oldVideo = FCK.GetElementByRefId(refid);
			FCK.log(oldVideo);

			result = eval('(' + o.responseText + ')');
			html = result.parse.text['*'];

			// remove newPP comment and whitespaces
			html = FCK.YAHOO.lang.trim(html.split('<!-- \nNewPP limit report')[0]);

			// insert html into editing area (before old video)...
			var wrapper = FCKTools.GetElementDocument(oldVideo).createElement('DIV');

			// fix IE's "unknown runtine error" by always adding wrapper before block elements (FF will try to validate, IE will throw an error)
			// @see http://piecesofrakesh.blogspot.com/2007/02/ies-unknown-runtime-error-when-using.html
			if (oldVideo.nodeName.IEquals('a') && FCKBrowserInfo.IsIE) {
				oldVideo.parentNode.parentNode.insertBefore(wrapper, oldVideo.parentNode);
			}
			else {
				oldVideo.parentNode.insertBefore(wrapper, oldVideo);
			}

			// set HTML
			wrapper.innerHTML = html;

			// ...and "protect" it
			wrapper.firstChild.setAttribute('refid', refid);
			FCK.ProtectVideo(wrapper.firstChild);

			// remember current values of _wysiwyg_new_line and _wysiwyg_line_start attributes
			if (oldVideo.getAttribute('_wysiwyg_new_line')) {
				wrapper.firstChild.setAttribute('_wysiwyg_new_line', true);
			}

			if (oldVideo.getAttribute('_wysiwyg_line_start')) {
				wrapper.firstChild.setAttribute('_wysiwyg_line_start', true);
			}

			// remove wrapper and old video
			FCKDomTools.RemoveNode(oldVideo, false); // including child nodes
			FCKDomTools.RemoveNode(wrapper, true); // excluding child nodes
		},
		failure: function(o) {},
		argument: {'FCK': FCK, 'refid': refid}
	}

	FCK.YAHOO.util.Connect.asyncRequest(
		'POST',
		window.parent.wgScriptPath + '/api.php',
		callback,
		"action=parse&format=json&wysiwyg=true&prop=text&title=" + encodeURIComponent(window.parent.wgPageName) + "&text=" +  encodeURIComponent(wikitext)
	);
}

FCK.VideoAdd = function(wikitext, extraData) {
	var refid = FCK.GetFreeRefId();

	FCK.log('adding new video #' + refid + ' using >>' + wikitext + '<<');

	FCK.Track('/video/add');

	// fill metaData up
	var params = wikitext.substring(2, wikitext.length-2).split('|');
	FCK.wysiwygData[refid] = {
		'type': 'video',
		'original': wikitext,
		'href': params[0]
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

			// is "simple" video wrapped by <p></p> ?
			if (html.substr(0,3) == '<p>') {
				// remove wrapping <p></p>
				wrapper.innerHTML = html.substr(3, html.length-7);
			}

			// ...and "protect" it
			wrapper.firstChild.setAttribute('refid', refid);
			FCK.ProtectVideo(wrapper.firstChild);

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
		"action=parse&format=json&wysiwyg=true&prop=text&title=" + encodeURIComponent(window.parent.wgPageName) + "&text=" +  encodeURIComponent(wikitext)
	);
}


// setup video overlaying menu
FCK.VideoSetupOverlayMenu = function(refid, div) {

	// remove old overlayMenu (if any)
	if (div.lastChild && div.lastChild.nodeName.IEquals('span') && FCK.YD.hasClass(div.lastChild,'videoOverlay')) {
		FCKDomTools.RemoveNode(div.lastChild);
	}

	div.setAttribute('refid', refid);

	var docObj = FCKTools.GetElementDocument(div);

	var overlay = docObj.createElement('SPAN');

	// position menu based on alignment of an video
	overlay.className = 'imageOverlay' + (FCK.YD.hasClass(div, 'thumb') ?  ' imageOverlayRight' : '');
	overlay.style.visibility = 'hidden';

	div.style.position = 'relative';

	// move to the upper corner when video is wrapped using <a>
	if (div.nodeName.IEquals('a') && !FCKBrowserInfo.IsIE) {
		var height = parseInt(div.firstChild.offsetHeight / 2);
		overlay.style.top = (-height + 8) + 'px';
	}

	div.appendChild(overlay);

	overlay.innerHTML = '<span class="videoOverlayEdit" onclick="FCK.VideoEdit('+refid+')">' + FCKLang.DlgSelectBtnModify + '</span><span class="videoOverlayRemove" onclick="FCK.VideoRemove('+refid+')">' + FCKLang.DlgSelectBtnDelete + '</span>';

	// add "move" option for videos handled by contentEditable
	if (FCK.UseContentEditable) {
		overlay.innerHTML += '<span class="videoOverlayDrag">move</span>';
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




// add new <videogallery>
FCK.VideoGalleryAdd = function(wikitext) {
	var refid = FCK.GetFreeRefId();

	FCK.log('adding new <videogallery> #' + refid + ': ' + wikitext);

	FCK.Track('/video/add/gallery');

	// add meta data entry
	FCK.wysiwygData[refid] = {
		'type': 'hook',
		'name': 'videogallery',
		'original': wikitext
	};

	// create new placeholder and add it to the article
	placeholder = FCK.EditorDocument.createElement('INPUT');
	placeholder.type = 'button';
	placeholder.value = '<videogallery>';
	placeholder.setAttribute('refid', refid);
	placeholder.setAttribute('_fck_type', 'videogallery');

	FCK.InsertElement(placeholder);

	// setup placeholder
	FCK.VideoSetupGalleryPlaceholder(placeholder);
}

// setup <videogallery> hook placeholder
FCK.VideoSetupGalleryPlaceholder = function(placeholder) {
	// add onclick handler
	FCKTools.AddEventListener(placeholder, 'click', FCK.VideoGalleryClick);
}

FCK.VideoGalleryClick = function(e) {
	var e = FCK.YE.getEvent(e);
	var target = FCK.YE.getTarget(e);

	FCK.YE.stopEvent(e);

	var refid = parseInt(target.getAttribute('refid'));

	if (typeof window.parent.VET_show != 'undefined') {
		window.parent.VET_show(refid, 1);
	}
}

// add video to <videogallery>
FCK.VideoGalleryUpdate = function(refid, newVideo) {
	var data = FCK.wysiwygData[refid];

	if ( data && (data.type == 'hook') ) {
		// add new video wikitext to the end of wikitext
		var desc = data.description;
		desc = desc.substr(14, desc.length - 29);
		desc = FCK.YAHOO.Tools.trim(desc);

		// update entry in meta data
		data.description = "<videogallery>\n" + desc + "\n" + newVideo + "\n</videogallery>";

		FCK.log('<videogallery> #' + refid + ' updated to: ' + data.description);
	}
}
