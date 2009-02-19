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

FCK.VideoAdd = function(wikitext, options) {
	var refid = FCK.GetFreeRefId();

	FCK.log('adding new video #' + refid + ' using >>' + wikitext + '<<');

	FCK.Track('/video/add');

	// add meta data entry
	FCK.wysiwygData[refid] = {
		'type': 'video',
		'description': wikitext
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
