FCK.log('new toolbar enabled...');

var WikiaToolbar = function() { };

// WikiaToolbar class extends FCKToolbar
FCK.YAHOO.lang.extend(WikiaToolbar, FCKToolbar);

// overload FCKToolbar methods
WikiaToolbar.prototype.Create = function(parentElement) {
	FCK.log('toolbar rendering');

	// hide default FCK toolbar
	parentElement.style.display = 'none';

	// setup new toolbar
	var parentDoc = window.parent.document;
	parentElement = parentDoc.getElementById('page_bar');

	// add toolbar items
	if (parentElement) {
		// toolbar HTML
		parentElement.innerHTML = '<table id="fck_toolbar"><tr><td class="last"><div class="clearfix"><label>Label</label><ul id="fck_toolbar_items"></ul></div></td></tr></table>';

		var toolbar = parentDoc.getElementById('fck_toolbar_items');

		for ( var i = 0 ; i < this.Items.length ; i++ ) {
			this.Items[i].Create( toolbar ) ;
		}
	}

	// and finally, show new toolar
	parentElement.style.display = 'block';
}

WikiaToolbar.prototype.AddItem = function( item )
{
	FCK.log( item );
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
	this.Tooltip	= tooltip || this.Label ;
	this.Style		= style || FCK_TOOLBARITEM_ONLYICON ;
	this.State		= state || FCK_TRISTATE_OFF ;

	this.Icon = new FCKIcon( iconPathOrStripInfoArray ) ;

	if ( FCK.IECleanup )
		FCK.IECleanup.AddItem( this, FCKToolbarButtonUI_Cleanup ) ;

	FCK.log(this);
}

// WikiaButtonUI class extends FCKToolbarButtonUI
FCK.YAHOO.lang.extend(WikiaButtonUI, FCKToolbarButtonUI);

WikiaButtonUI.prototype.Create = function( parentElement )
{
	var oDoc = FCKTools.GetElementDocument( parentElement ) ;

	// create main wrapping element
	var oMainElement = this.MainElement = oDoc.createElement( 'LI' ) ;
	oMainElement.title = this.Tooltip ;

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
		/*
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
		*/
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
			e.className		= 'fwysiwygToolbarButtonOff' ;
			break ;

		case FCK_TRISTATE_ON :
			e.className		= 'wysiwygToolbarButtonOn' ;
			break ;

		case FCK_TRISTATE_DISABLED :
			e.className		= 'wysiwygToolbarButtonDisabled' ;
			break ;
	}

	this.State = newState ;
}

function WikiaButtonUI_OnMouseOver( ev, button )
{
	if ( button.State == FCK_TRISTATE_OFF )
		this.className = 'wysiwygToolbarButtonOffOver' ;
	else if ( button.State == FCK_TRISTATE_ON )
		this.className = 'wysiwygToolbarButtonOnOver' ;
}

function WikiaButtonUI_OnMouseOut( ev, button )
{
	if ( button.State == FCK_TRISTATE_OFF )
		this.className = 'wysiwygToolbarButtonOff' ;
	else if ( button.State == FCK_TRISTATE_ON )
		this.className = 'wysiwygToolvarButtonOn' ;
}

function WikiaButtonUI_OnClick( ev, button )
{
	if ( button.OnClick && button.State != FCK_TRISTATE_DISABLED )
		button.OnClick( button ) ;
}

// override default button from FCK
FCK.YAHOO.lang.extend(FCKToolbarButtonUI, WikiaButtonUI);
