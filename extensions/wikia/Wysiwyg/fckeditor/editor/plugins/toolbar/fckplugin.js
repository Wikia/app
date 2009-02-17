FCK.log('new toolbar enabled...');

// WikiaSeparator class for separating buckets
var WikiaSeparator = function( bucket  ) { this.Bucket = bucket;  };

WikiaSeparator.prototype.Create = function(node) {
	//FCK.log( this.Bucket );
}

var WikiaToolbar = function() { };

// WikiaToolbar class extends FCKToolbar
FCK.YAHOO.lang.extend(WikiaToolbar, FCKToolbar);

// overload FCKToolbar methods
WikiaToolbar.prototype.CurrentBucket = 0;

WikiaToolbar.prototype.AddSeparator = function()
{
	var bucketName = window.parent.wysiwygToolbarBuckets[this.CurrentBucket++];

	this.AddItem( new WikiaSeparator({'name': bucketName, 'last': (this.CurrentBucket == window.parent.wysiwygToolbarBuckets.length)}) );
}

WikiaToolbar.prototype.Create = function(parentElement) {
	FCK.log('toolbar rendering');

	// hide default FCK toolbar
	parentElement.style.display = 'none';

	// setup new toolbar
	var parentDoc = window.parent.document;
	parentElement = parentDoc.getElementById('page_bar');

	if (parentElement) {
		// setup HTML
		parentElement.innerHTML = '<table id="fck_toolbar"></table>';

		var toolbar = parentDoc.getElementById('fck_toolbar');
		var toolbarRow = toolbar.insertRow(-1);

		var currentBucket;

		// add toolbar items
		for ( var i = 0 ; i < this.Items.length ; i++ ) {

			var item = this.Items[i];

			if (item.Bucket) {
				// create new bucket
				var toolbarCell = toolbarRow.insertCell(-1);
				toolbarCell.innerHTML = '<div class="clearfix">' + 
					'<label title="' + item.Bucket.name + '" class="color1">' + item.Bucket.name  + '</label><ul></ul></div>';

				// set CSS class for last bucket
				if (item.Bucket.last) {
					toolbarCell.className = 'last';
				}

				// get <ul> node - new items will be added there
				currentBucket = toolbarCell.getElementsByTagName('ul')[0];
			}
			else {
				// add item to current bucket
				item.Create( currentBucket ) ;
			}
		}
	}

	// and finally, show new toolar
	parentElement.style.display = 'block';
}

WikiaToolbar.prototype.AddItem = function( item )
{
	//FCK.log( item );
        return this.Items[ this.Items.length ] = item ;
}

// override default toolbar from FCK
FCK.YAHOO.lang.extend(FCKToolbar, WikiaToolbar);


//
// buttons styling
//
var WikiaButtonUI = function( name, label, tooltip, iconPathOrStripInfoArray, style, state )
{
	this.Name		= name ;
	this.Label		= label || name ;
	this.Tooltip		= tooltip || this.Label ;
	this.Style		= style || FCK_TOOLBARITEM_ONLYICON ;
	this.State		= state || FCK_TRISTATE_OFF ;

	this.Icon = new FCKIcon( iconPathOrStripInfoArray ) ;

	if ( FCK.IECleanup )
		FCK.IECleanup.AddItem( this, FCKToolbarButtonUI_Cleanup ) ;
}

// WikiaButtonUI class extends FCKToolbarButtonUI
FCK.YAHOO.lang.extend(WikiaButtonUI, FCKToolbarButtonUI);

WikiaButtonUI.prototype.IconsPath = window.parent.wgExtensionsPath + '/wikia/Wysiwyg/toolbar/';

WikiaButtonUI.prototype.Icons = {
	'Bold': 	'text_bold.png',
	'Italic':	'text_italic.png',
	'Underline':	'text_underline.png',
	'StrikeThrough':'text_strikethrough.png',
	'Indent':	'text_indent.png',
	'Outdent':	'text_indent_remove.png',

	'InsertUnorderedList':	'text_list_bullets.png',
	'InsertOrderedList':	'text_list_numbers.png',
	'Link':			'link.png',
	'Unlink':		'link_break.png',

	'AddImage':	'photo.png',
	'AddVideo':	'film.png',
	'Table':	'table.png',
	'Tildes':	'icon_signature.png',

	'Undo':		'arrow_undo.png',
	'Redo':		'arrow_redo.png',
	'Source':	'application_xp_terminal.png'
};

WikiaButtonUI.prototype.Create = function( parentElement )
{
	// try to use customized icons
	if (this.Icons[this.Name]) {
		src = this.IconsPath + this.Icons[this.Name];
		this.Icon = new FCKIcon( src );
	}

	var oDoc = FCKTools.GetElementDocument( parentElement ) ;

	// create main wrapping element
	var oMainElement = this.MainElement = oDoc.createElement( 'LI' ) ;
	oMainElement.title = this.Tooltip ;
	oMainElement.id = 'fck_button_' + this.Name.toLowerCase();

	// The following will prevent the button from catching the focus.
	if ( FCKBrowserInfo.IsGecko )
		 oMainElement.onmousedown	= FCKTools.CancelEvent ;

	FCKTools.AddEventListenerEx( oMainElement, 'mouseover', WikiaButtonUI_OnMouseOver, this ) ;
	FCKTools.AddEventListenerEx( oMainElement, 'mouseout', WikiaButtonUI_OnMouseOut, this ) ;
	FCKTools.AddEventListenerEx( oMainElement, 'click', WikiaButtonUI_OnClick, this ) ;

	this.ChangeState( this.State, true ) ;

	if ( this.Style == FCK_TOOLBARITEM_ONLYICON && !this.ShowArrow )
	{
		oMainElement.appendChild( this.Icon.CreateIconElement( oDoc ) ) ;
	}
	else
	{
		var oTable = oMainElement.appendChild( oDoc.createElement( 'TABLE' ) ) ;
		oTable.cellPadding = 0 ;
		oTable.cellSpacing = 0 ;

		var oRow = oTable.insertRow(-1) ;

		// The Image cell (icon or padding).
		var oCell = oRow.insertCell(-1) ;

		if ( this.Style == FCK_TOOLBARITEM_ONLYICON || this.Style == FCK_TOOLBARITEM_ICONTEXT ) {
			oCell.appendChild( this.Icon.CreateIconElement( oDoc ) ) ;
		}
		else {
			oCell.appendChild( this._CreatePaddingElement( oDoc ) ) ;
		}

		if ( this.Style == FCK_TOOLBARITEM_ONLYTEXT || this.Style == FCK_TOOLBARITEM_ICONTEXT )
		{
			// The Text cell.
			oCell = oRow.insertCell(-1) ;
			oCell.className = 'TB_Button_Text' ;
			oCell.noWrap = true ;
			oCell.appendChild( oDoc.createTextNode( this.Label ) ) ;
		}

		if ( this.ShowArrow )
		{
			if ( this.Style != FCK_TOOLBARITEM_ONLYICON )
			{
				// A padding cell.
				oRow.insertCell(-1).appendChild( this._CreatePaddingElement( oDoc ) ) ;
			}

			oCell = oRow.insertCell(-1) ;
			var eImg = oCell.appendChild( oDoc.createElement( 'IMG' ) ) ;
			eImg.src	= FCKConfig.SkinPath + 'images/toolbar.buttonarrow.gif' ;
			eImg.width	= 5 ;
			eImg.height	= 3 ;
		}

		// The last padding cell.
		oCell = oRow.insertCell(-1) ;
		oCell.appendChild( this._CreatePaddingElement( oDoc ) ) ;
	}

	parentElement.appendChild( oMainElement ) ;
}

WikiaButtonUI.prototype.ChangeState = function( newState, force )
{
	if ( !force && this.State == newState )
		return ;

	var e = this.MainElement ;

	// In IE it can happen when the page is reloaded that MainElement is null, so exit here
	if ( !e )
		return ;

	switch ( parseInt( newState, 10 ) )
	{
		case FCK_TRISTATE_OFF :
			e.className		= 'fck_button_of' ;
			break ;

		case FCK_TRISTATE_ON :
			e.className		= 'fck_button_on' ;
			break ;

		case FCK_TRISTATE_DISABLED :
			e.className		= 'fck_button_disabled' ;
			break ;
	}

	this.State = newState ;
}

function WikiaButtonUI_OnMouseOver( ev, button )
{
	if ( button.State == FCK_TRISTATE_OFF ) {
		this.className = 'fck_button_off_over' ;
	}
	else if ( button.State == FCK_TRISTATE_ON ) {
		this.className = 'fck_button_on_over' ;
	}

	// change bucket label
	var label = this.parentNode.parentNode.firstChild;
	label.innerHTML = button.Label;
}

function WikiaButtonUI_OnMouseOut( ev, button )
{
	if ( button.State == FCK_TRISTATE_OFF ) {
		this.className = 'fck_button_off' ;
	}
	else if ( button.State == FCK_TRISTATE_ON ) {
		this.className = 'fck_button_on' ;
	}

	// change bucket label
	var label = this.parentNode.parentNode.firstChild;
	label.innerHTML = label.title;
}

function WikiaButtonUI_OnClick( ev, button )
{
	if ( button.OnClick && button.State != FCK_TRISTATE_DISABLED )
		button.OnClick( button ) ;
}

// override default button from FCK
FCK.YAHOO.lang.extend(FCKToolbarButtonUI, WikiaButtonUI);
