FCK.log('new toolbar enabled...');

// show toolbar tooltip
FCK.WikiaToolbarShowTooltip = function(content) {
	FCK.log('showing toolbar tooltip');

	// create tooltip node
	var docObj = window.parent.document;
	var tooltip = docObj.createElement('DIV');
	tooltip.id = 'wysiwygToolbarTooltip';

	docObj.body.appendChild(tooltip);

	// set HTML & CSS
	tooltip.innerHTML = content;
	tooltip.style.top = parseInt(FCK.YD.getY('editform') - 30) + 'px';
	tooltip.style.left = '500px';

	// add close handler
	FCK.YE.addListener('wysiwygToolbarTooltipClose', 'click', function(e) {
		FCK.YD.get('wysiwygToolbarTooltip').style.display = 'none';
		window.parent.sajax_do_call('WysiwygToolbarRemoveTooltip', [], function() {});
	});
}

// WikiaSeparator class for separating buckets
var WikiaSeparator = function( bucket  ) { this.Bucket = bucket; };
WikiaSeparator.prototype.Create = function(node) { }

var WikiaToolbar = function() {
	this.Buckets = window.parent.wysiwygToolbarBuckets;
	this.CurrentBucket = 0;
 };

// WikiaToolbar class extends FCKToolbar
WikiaToolbar.prototype = new FCKToolbar;

// overload FCKToolbar methods
WikiaToolbar.prototype.AddSeparator = function() {
	var bucketName = this.Buckets[this.CurrentBucket++];

	this.AddItem( new WikiaSeparator({'name': bucketName, 'last': (this.CurrentBucket == this.Buckets.length)}) );
}

WikiaToolbar.prototype.Create = function(parentElement) {
	FCK.log('toolbar rendering');

	// setup new toolbar
	var toolbarDoc = FCKTools.GetElementDocument(parentElement);
	var toolbar = toolbarDoc.createElement('TABLE');
	toolbar.id = 'fck_toolbar';
	toolbar.className = 'reset';
	
	parentElement.appendChild(toolbar);

	// toolbar will be shown when its CSS is fully loaded
	parentElement.style.display = 'none';

	// store toolbar object
	this.Toolbar = toolbar;

	// add new toolbar CSS
	FCKTools.AppendStyleSheet(toolbarDoc, window.parent.wgExtensionsPath + '/wikia/Wysiwyg/fckeditor/editor/plugins/toolbar/toolbar.css');

	// fix IE6/7
	if (FCKBrowserInfo.IsIE) {
		FCKTools.AppendStyleSheet(toolbarDoc, window.parent.wgExtensionsPath + '/wikia/Wysiwyg/fckeditor/editor/plugins/toolbar/toolbar_ie.css');
	}

	// set toolbar foreground / background color based on #page_bar (.color1 CSS class)
	var pageBar = new FCK.YAHOO.util.Element('page_bar');

	var backgroundColor= pageBar.getStyle('backgroundColor') || '#efefde';

	toolbar.style.color= pageBar.getStyle('color') || '#000';
	parentElement.style.backgroundColor= backgroundColor;

	var toolbarRow = toolbar.insertRow(-1);
	var currentBucket = false;
	var currentBucketItems = 0;
	var bucketsCount = 0;

	// add toolbar items
	for ( var i = 0 ; i < this.Items.length ; i++ ) {

		var item = this.Items[i];

		if (item.Bucket) {
			// set width of previous bucket <UL>
			if (currentBucket && currentBucketItems > 1) {
				currentBucket.style.maxWidth = (currentBucketItems*27) + 'px';
				this.addBucketIEFixes(currentBucket);
			}

			// create new bucket
			var toolbarCell = toolbarRow.insertCell(-1);
			toolbarCell.innerHTML = '<div class="clearfix" style="background-color: ' + backgroundColor  + '">' + 
				'<label title="' + item.Bucket.name + '">' + item.Bucket.name  + '</label><ul class="clearfix"></ul></div>';

			// set CSS class for last bucket
			if (item.Bucket.last) {
				toolbarCell.className = 'last';
			}

			// get <ul> node - new items will be added there
			currentBucket = toolbarCell.getElementsByTagName('ul')[0];
			currentBucketItems = 0;

			// set id
			currentBucket.id = 'fck_toolbar_bucket_' + (++bucketsCount);

		}
		else {
			// add item to current bucket
			item.Create( currentBucket ) ;

			currentBucketItems++;
		}
	}

	this.addBucketIEFixes(currentBucket);

	// set width of last bucket <UL>
	if (currentBucket && currentBucketItems > 1) {
		currentBucket.style.maxWidth = (currentBucketItems*27) + 'px';
	}

	// show tooltip
	if (typeof window.parent.wysiwygToolbarTooltip != 'undefined') {
		FCK.WikiaToolbarShowTooltip(window.parent.wysiwygToolbarTooltip);
	}
	else {
		FCK.log('not showing toolbar tooltip');
	}
}

// setup onmouseover / onmouseout event handlers for IE
WikiaToolbar.prototype.addBucketIEFixes = function(bucket) {

	// apply only to IE
	if (!FCKBrowserInfo.IsIE) {
		return;
	}

	var timeout;

	FCKTools.AddEventListener(bucket.parentNode.parentNode, 'mouseover', function(e) {
		if (FCK.EditMode != FCK_EDITMODE_WYSIWYG) {
			return;
		}

		var id = bucket.id.split('_').pop();
		if (bucket.getElementsByTagName('li').length * 27 > bucket.offsetWidth) {
			bucket.parentNode.style.height = 'auto';
		}
		setTimeout("var node = document.getElementById('fck_toolbar_bucket_" + id  + "').parentNode;" +
			"node.style.height = node.offsetHeight + 'px'", 50);

		// emulate min-width
		/*
		if (bucket.parentNode.offsetWidth < 125) {
			bucket.parentNode.style.width = '120px';
		}
		else {
			bucket.parentNode.style.width = 'auto';
		}
		*/
		clearTimeout(timeout);
	});

	FCKTools.AddEventListener(bucket.parentNode.parentNode, 'mouseout', function(e) {
		if (FCK.EditMode != FCK_EDITMODE_WYSIWYG) {
			return;
		}
		bucket.parentNode.style.height = '49px';
	});
}


FCK.WikiaUsingNewToolbar = true;

WikiaToolbar.prototype.WikiaSwitchToolbar = function(switchToWikitext) {

	var MWtoolbar = window.parent.document.getElementById('toolbar');
	var iframe = window.parent.document.getElementById('wpTextbox1___Frame');

	if (switchToWikitext) {
		MWtoolbar.style.top = (iframe.offsetTop + 14) + 'px';
		MWtoolbar.style.left = '12px';
		MWtoolbar.style.visibility = 'visible';

		this.Toolbar.className = 'toolbarSource';
	}
	else {
		MWtoolbar.style.visibility = 'hidden';

		this.Toolbar.className = 'toolbarWysiwyg';
	}
}

WikiaToolbar.prototype.AddItem = function( item )
{
	//FCK.log( item );
        return this.Items[ this.Items.length ] = item ;
}

// override default FCK toolbar class
FCKToolbar.prototype = new WikiaToolbar;

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

	this.IconsPath = window.parent.wgExtensionsPath + '/wikia/Wysiwyg/fckeditor/editor/plugins/toolbar/icons/';
	this.Icons = {
		'H2':		'text_heading_2.png',
		'H3':		'text_heading_3.png',
		'Bold': 	'text_bold.png',
		'Italic':	'text_italic.png',
		'Underline':	'text_underline.png',
		'StrikeThrough':'text_strikethrough.png',
		'Normal':	'icon_normal.png',
		'Pre':		'icon_pre.png',
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
		'Widescreen':	'icon_widescreen.png',
		'Source':	'application_xp_terminal.png'
	};

	if ( FCK.IECleanup )
		FCK.IECleanup.AddItem( this, FCKToolbarButtonUI_Cleanup ) ;
}

// WikiaButtonUI class extends FCKToolbarButtonUI
WikiaButtonUI.prototype = new FCKToolbarButtonUI;

WikiaButtonUI.prototype.Create = function( parentElement )
{
	// change Source button style, so only icon will be shown
	if (this.Name == 'Source') {
		this.Style = 0;
	}

	// try to use customized icons
	if (this.Icons[this.Name]) {
		src = this.IconsPath + this.Icons[this.Name];
		this.Icon = new FCKIcon( src );
	}

	var oDoc = FCKTools.GetElementDocument( parentElement ) ;

	// create main wrapping element
	var oMainElement = this.MainElement = oDoc.createElement( 'LI' ) ;
	oMainElement.title = this.Tooltip ;
	oMainElement.id = 'fck_toolbar_item_' + this.Name.toLowerCase();

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
			e.className		= 'fck_button_off' ;
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

// override default FCK button class
FCKToolbarButtonUI.prototype = new WikiaButtonUI;

//
// simple combo boxes
//
var WikiaCombo = function()
{
	this.Items = new Object() ;
}

WikiaCombo.prototype = FCKSpecialCombo.prototype;

WikiaCombo.prototype.AddItem = function( id, html, label, bold )
{
	this.Items[ id.toString() ] = {'html': html, 'label': label, 'bold': bold ? true : false};
}

WikiaCombo.prototype.Create = function( targetElement )
{
	var oDoc = FCKTools.GetElementDocument( targetElement ) ;

	// create the main SELECT node
	this.Select = oDoc.createElement('SELECT');
	targetElement.appendChild( this.Select );

	this.Select.style.width = this.FieldWidth + 'px';

	// add OPTION nodes
	this.Select.appendChild( oDoc.createElement('OPTION') );

	for (Item in this.Items) {
		var option = oDoc.createElement('OPTION');

		option.value = Item;
		option.innerHTML = this.Items[Item].html;

		if (this.Items[Item].bold) {
			option.style.fontWeight = 'bold';
		}

		this.Select.appendChild(option);
	}

	// change bucket style
	this.Select.parentNode.parentNode.style.overflow = 'visible';

	// Event handlers
	FCKTools.AddEventListenerEx( this.Select, 'change', WikiaCombo_OnClick, [ this ] ) ;
}

WikiaCombo.prototype.SetEnabled = function( isEnabled ) {
	this.Select.disabled = isEnabled ? false : true;
}

WikiaCombo.prototype.SetLabel = function( text ) { }

function WikiaCombo_OnClick(ev, combo) {
	var selectedValue = combo.Select.options[ combo.Select.selectedIndex ].value;

	// switch back to default value
	combo.Select.selectedIndex = 0;

	FCK.log('WikiaCombo: selected ' + selectedValue);

	// create and execute command associated with combo
	var command = FCKCommands.GetCommand(combo.CommandName);
	command.Execute(selectedValue);
}

FCKSpecialCombo.prototype = new WikiaCombo;

//
// extra toolbar buttons used for text styling
//

// general class
var StyleCommand = function(id, name) {
        this.Name = name;
	this.Command = new FCKCoreStyleCommand(id);
	this.IsActive = false;
	this.IsDisabled = false;

	// handle state of block style buttons when cursor is inside list
	if (id == 'h2' || id == 'h3' || id == 'pre' || id == 'p') {
		this.disableWhenInsideList = true;
		FCK.log(id + ' will be disabled inside list');
	}

	FCKStyles.AttachStyleStateChange(this.Command.StyleName, this._OnStyleStateChange, this);
}
StyleCommand.prototype = {
	IsInsideList : function() {
		var startContainer = FCKSelection.GetBoundaryParentElement(true);
		var listNode = startContainer;

		if (listNode && listNode.nodeName.IEquals(['ul', 'ol', 'li'])) {
			return true;
		}
		else {
			return false;
		}
	},
        Execute : function() {
		this.Command.Execute();
        },
        GetState : function() {
		if ( FCK.EditMode != FCK_EDITMODE_WYSIWYG ) {
			return FCK_TRISTATE_DISABLED ;
		}
		else if (this.IsDisabled) {
			return FCK_TRISTATE_DISABLED ;
		}
		else {
			return this.IsActive ? FCK_TRISTATE_ON : FCK_TRISTATE_OFF ;
		}
	 },
	_OnStyleStateChange : function( styleName, isActive ) {
		this.IsActive = isActive;
		this.IsDisabled = (this.disableWhenInsideList && this.IsInsideList());

		if (isActive) {
			FCK.log('current style: ' + this.Name);
		}

		// hack: refresh toolbar items state
		var items = FCK.ToolbarSet.Items;
		for (i=0; i<items.length; i++) {
			items[i].RefreshState();
		}
	}
} ;

// widescreen switching
var WideScreenToggle = function() {
	this.toggleWideScreenLink = window.parent.document.getElementById("toggleWideScreen");

	// get current widescreen mode state
	this.isActive = FCK.YD.hasClass(window.parent.document.body, 'editingWide');

	// store listener function
	this.listener = false;
 }

WideScreenToggle.prototype = {

	Toggle: function() {
		// use previously stored listener function
		if (this.listener) {
			this.listener(true);
			return true;
		}

		if (this.toggleWideScreenLink && FCK.YE.getListeners) {
			// store listener function
			this.listener = FCK.YE.getListeners(this.toggleWideScreenLink).pop().fn;
			this.listener(true);
			return true;
		}
		else {
			return false;
		}
	},
	Execute : function() {
		this.Toggle();
		this.isActive = !this.isActive;

		// hack: refresh toolbar items state
		var items = FCK.ToolbarSet.Items;
		for (i=0; i<items.length; i++) {
			items[i].RefreshState();
		}
        },
        GetState : function() {
		return this.isActive ? FCK_TRISTATE_ON : FCK_TRISTATE_OFF ;
	}
};

// register new toolbar items
FCKCommands.RegisterCommand('H2', new StyleCommand('h2', 'Heading 2'));
FCKToolbarItems.RegisterItem('H2', new FCKToolbarButton('H2', 'Section Heading')  );

FCKCommands.RegisterCommand('H3', new StyleCommand('h3', 'Heading 3'));
FCKToolbarItems.RegisterItem('H3', new FCKToolbarButton('H3', 'Sub Heading'));

FCKCommands.RegisterCommand('Pre', new StyleCommand('pre', 'Preformatted'));
FCKToolbarItems.RegisterItem('Pre', new FCKToolbarButton('Pre', 'Preformatted'));

FCKCommands.RegisterCommand('Normal', new StyleCommand('p', 'Normal Text'));
FCKToolbarItems.RegisterItem('Normal', new FCKToolbarButton('Normal', 'Remove Heading'));

FCKCommands.RegisterCommand('Widescreen', new WideScreenToggle());
FCKToolbarItems.RegisterItem('Widescreen', new FCKToolbarButton('Widescreen', 'Toggle widescreen'));
