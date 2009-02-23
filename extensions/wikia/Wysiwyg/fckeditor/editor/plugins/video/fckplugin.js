// "add image" toolbar button
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

// add new [[Video:foo]] link
FCK.VideoAdd = function(wikitext, options) {
	var refid = FCK.GetFreeRefId();

	FCK.log('adding new video #' + refid + ' using >>' + wikitext + '<<');

	FCK.Track('/video/add');

	// add meta data entry
	FCK.wysiwygData[refid] = {
		'type': 'video',
		'original': wikitext
	};

	// create new placeholder and add it to the article
	placeholder = FCK.EditorDocument.createElement('INPUT');
	placeholder.className = 'wysiwygDisabled';
	placeholder.type = 'button';
	placeholder.value = wikitext;
	placeholder.setAttribute('refid', refid);
	placeholder.setAttribute('_fck_type', 'video');

	FCK.InsertElement(placeholder);
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
		'description': wikitext
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
	// change HTML
	placeholder.value = '<videogallery>';
	placeholder.className = 'wysiwygDisabled wysiwygVideoGallery';
	placeholder.setAttribute('_fck_type', 'videogallery');

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
