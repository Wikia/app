/*!
 * VisualEditor user interface MWMediaDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for inserting and editing MediaWiki media.
 *
 * @class
 * @extends ve.ui.NodeDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMediaDialog = function VeUiMWMediaDialog( config ) {
	// Parent constructor
	ve.ui.MWMediaDialog.super.call( this, config );

	// Properties
	this.imageModel = null;
	this.store = null;
	this.fileRepoPromise = null;
	this.pageTitle = '';
	this.isSettingUpModel = false;
	this.isInsertion = false;

	this.$element.addClass( 've-ui-mwMediaDialog' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWMediaDialog, ve.ui.NodeDialog );

/* Static Properties */

ve.ui.MWMediaDialog.static.name = 'media';

ve.ui.MWMediaDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-media-title' );

ve.ui.MWMediaDialog.static.icon = 'picture';

ve.ui.MWMediaDialog.static.size = 'large';

ve.ui.MWMediaDialog.static.actions = [
	{
		action: 'apply',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-apply' ),
		flags: [ 'progressive', 'primary' ],
		modes: 'edit'
	},
	{
		action: 'insert',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-insert' ),
		flags: [ 'primary', 'constructive' ],
		modes: 'insert'
	},
	{
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-cancel' ),
		flags: 'safe',
		modes: [ 'edit', 'insert', 'select' ]
	},
	{
		action: 'back',
		label: OO.ui.deferMsg( 'visualeditor-dialog-media-goback' ),
		flags: 'safe',
		modes: 'change'
	}
];

ve.ui.MWMediaDialog.static.modelClasses = [ ve.dm.MWBlockImageNode, ve.dm.MWInlineImageNode ];

ve.ui.MWMediaDialog.static.excludeCommands = [
	// No formatting
	'paragraph',
	'heading1',
	'heading2',
	'heading3',
	'heading4',
	'heading5',
	'heading6',
	'preformatted',
	'blockquote',
	// TODO: Decide if tables tools should be allowed
	'tableCellHeader',
	'tableCellData',
	// No structure
	'bullet',
	'number',
	'indent',
	'outdent'
];

/**
 * Get the import rules for the surface widget in the dialog
 *
 * @see ve.dm.ElementLinearData#sanitize
 * @return {Object} Import rules
 */
ve.ui.MWMediaDialog.static.getImportRules = function () {
	return ve.extendObject(
		ve.copy( ve.init.target.constructor.static.importRules ),
		{
			all: {
				blacklist: OO.simpleArrayUnion(
					ve.getProp( ve.init.target.constructor.static.importRules, 'all', 'blacklist' ) || [],
					[
						// Tables (but not lists) are possible in wikitext with a leading
						// line break but we prevent creating these with the UI
						'list', 'listItem', 'definitionList', 'definitionListItem',
						'table', 'tableCaption', 'tableSection', 'tableRow', 'tableCell'
					]
				),
				// Headings are also possible, but discouraged
				conversions: {
					mwHeading: 'paragraph'
				}
			}
		}
	);
};

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWMediaDialog.prototype.getBodyHeight = function () {
	return 400;
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaDialog.prototype.initialize = function () {
	var positionFieldset, positionField,
		alignLeftButton, alignCenterButton, alignRightButton, alignButtons;

	// Parent method
	ve.ui.MWMediaDialog.super.prototype.initialize.call( this );

	this.$spinner = this.$( '<div>' ).addClass( 've-specialchar-spinner' );

	this.panels = new OO.ui.StackLayout( { $: this.$ } );

	// Set up the booklet layout
	this.bookletLayout = new OO.ui.BookletLayout( {
		$: this.$,
		outlined: true
	} );

	this.mediaSearchPanel = new OO.ui.PanelLayout( {
		$: this.$,
		scrollable: true
	} );

	this.generalSettingsPage = new OO.ui.PageLayout( 'general', { $: this.$ } );
	this.advancedSettingsPage = new OO.ui.PageLayout( 'advanced', { $: this.$ } );
	this.bookletLayout.addPages( [
		this.generalSettingsPage, this.advancedSettingsPage
	] );
	this.generalSettingsPage.getOutlineItem()
		.setIcon( 'parameter' )
		.setLabel( ve.msg( 'visualeditor-dialog-media-page-general' ) );
	this.advancedSettingsPage.getOutlineItem()
		.setIcon( 'parameter' )
		.setLabel( ve.msg( 'visualeditor-dialog-media-page-advanced' ) );

	// Define the media search page
	this.search = new ve.ui.MWMediaSearchWidget( { $: this.$ } );

	this.$body.append( this.search.$spinner );

	// Define fieldsets for image settings

	// Caption
	this.captionFieldset = new OO.ui.FieldsetLayout( {
		$: this.$,
		label: ve.msg( 'visualeditor-dialog-media-content-section' ),
		icon: 'parameter'
	} );

	// Position
	this.positionSelect = new OO.ui.ButtonSelectWidget( {
		$: this.$
	} );

	alignLeftButton = new OO.ui.ButtonOptionWidget( {
		$: this.$,
		data: 'left',
		icon: 'align-float-left',
		label: ve.msg( 'visualeditor-dialog-media-position-left' )
	} );
	alignCenterButton = new OO.ui.ButtonOptionWidget( {
		$: this.$,
		data: 'center',
		icon: 'align-center',
		label: ve.msg( 'visualeditor-dialog-media-position-center' )
	} );
	alignRightButton = new OO.ui.ButtonOptionWidget( {
		$: this.$,
		data: 'right',
		icon: 'align-float-right',
		label: ve.msg( 'visualeditor-dialog-media-position-right' )
	} );

	alignButtons = ( this.getDir() === 'ltr' ) ?
		[ alignLeftButton, alignCenterButton, alignRightButton ] :
		[ alignRightButton, alignCenterButton, alignLeftButton ];

	this.positionSelect.addItems( alignButtons, 0 );

	this.positionCheckbox = new OO.ui.CheckboxInputWidget( {
		$: this.$
	} );
	positionField = new OO.ui.FieldLayout( this.positionCheckbox, {
		$: this.$,
		align: 'inline',
		label: ve.msg( 'visualeditor-dialog-media-position-checkbox' )
	} );

	positionFieldset = new OO.ui.FieldsetLayout( {
		$: this.$,
		label: ve.msg( 'visualeditor-dialog-media-position-section' ),
		icon: 'parameter'
	} );

	// Build position fieldset
	positionFieldset.$element.append(
		positionField.$element,
		this.positionSelect.$element
	);

	// Size
	this.sizeFieldset = new OO.ui.FieldsetLayout( {
		$: this.$,
		label: ve.msg( 'visualeditor-dialog-media-size-section' ),
		icon: 'parameter'
	} );

	this.sizeErrorLabel = new OO.ui.LabelWidget( {
		$: this.$,
		label: ve.msg( 'visualeditor-dialog-media-size-originalsize-error' )
	} );

	this.sizeWidget = new ve.ui.MediaSizeWidget( {}, {
		$: this.$
	} );

	this.$sizeWidgetElements = this.$( '<div>' ).append(
		this.sizeWidget.$element,
		this.sizeErrorLabel.$element
	);
	this.sizeFieldset.$element.append(
		this.$spinner,
		this.$sizeWidgetElements
	);

	// Events
	this.positionCheckbox.connect( this, { change: 'onPositionCheckboxChange' } );
	this.positionSelect.connect( this, { choose: 'onPositionSelectChoose' } );
	this.search.connect( this, { select: 'onSearchSelect' } );
	// Panel classes
	this.mediaSearchPanel.$element.addClass( 've-ui-mwMediaDialog-panel-search' );
	this.bookletLayout.$element.addClass( 've-ui-mwMediaDialog-panel-settings' );
	this.$body.append( this.panels.$element );

	// Initialization
	this.mediaSearchPanel.$element.append( this.search.$element );
	this.generalSettingsPage.$element.append(
		this.captionFieldset.$element
	);

	this.advancedSettingsPage.$element.append(
		positionFieldset.$element,
		this.sizeFieldset.$element
	);

	this.panels.addItems( [ this.mediaSearchPanel, this.bookletLayout ] );
};

/**
 * Handle search result selection.
 *
 * @param {ve.ui.MWMediaResultWidget|null} item Selected item
 */
ve.ui.MWMediaDialog.prototype.onSearchSelect = function ( item ) {
	var info;

	if ( item ) {
		info = item.imageinfo[0];

		if ( !this.imageModel ) {
			// Create a new image model based on default attributes
			this.imageModel = ve.dm.MWImageModel.static.newFromImageAttributes(
				{
					// Per https://www.mediawiki.org/w/?diff=931265&oldid=prev
					href: './' + item.title,
					src: info.url,
					resource: './' + item.title,
					width: info.thumbwidth,
					height: info.thumbheight,
					mediaType: info.mediatype,
					type: 'thumb',
					align: 'default',
					defaultSize: true
				},
				this.getFragment().getDocument().getDir(),
				this.getFragment().getDocument().getLang()
			);
			this.attachImageModel();
		} else {
			// Update the current image model with the new image source
			this.imageModel.changeImageSource(
				{
					mediaType: info.mediatype,
					href: './' + item.title,
					src: info.url,
					resource: './' + item.title
				},
				{ width: info.width, height: info.height }
			);
		}

		this.checkChanged();
		this.switchPanels( 'edit' );
	}
};

/**
 * Handle image model alignment change
 * @param {string} alignment Image alignment
 */
ve.ui.MWMediaDialog.prototype.onImageModelAlignmentChange = function ( alignment ) {
	var item;
	alignment = alignment || 'none';

	item = alignment !== 'none' ? this.positionSelect.getItemFromData( alignment ) : null;

	// Select the item without triggering the 'choose' event
	this.positionSelect.selectItem( item );

	this.positionCheckbox.setSelected( alignment !== 'none' );
	this.checkChanged();
};

/**
 * Handle change event on the positionCheckbox element.
 *
 * @param {boolean} isSelected Checkbox status
 */
ve.ui.MWMediaDialog.prototype.onPositionCheckboxChange = function ( isSelected ) {
	var newPositionValue,
		currentModelAlignment = this.imageModel.getAlignment();

	this.positionSelect.setDisabled( !isSelected );
	this.checkChanged();
	// Only update the model if the current value is different than that
	// of the image model
	if (
		( currentModelAlignment === 'none' && isSelected ) ||
		( currentModelAlignment !== 'none' && !isSelected )
	) {
		if ( isSelected ) {
			// Picking a floating alignment value will create a block image
			// no matter what the type is, so in here we want to calculate
			// the default alignment of a block to set as our initial alignment
			// in case the checkbox is clicked but there was no alignment set
			// previously.
			newPositionValue = this.imageModel.getDefaultDir( 'mwBlockImage' );
			this.imageModel.setAlignment( newPositionValue );
		} else {
			// If we're unchecking the box, always set alignment to none and unselect the position widget
			this.imageModel.setAlignment( 'none' );
		}
	}
};

/**
 * Handle change event on the positionSelect element.
 *
 * @param {OO.ui.ButtonOptionWidget} item Selected item
 */
ve.ui.MWMediaDialog.prototype.onPositionSelectChoose = function ( item ) {
	var position = item ? item.getData() : 'default';

	// Only update if the value is different than the model
	if ( this.imageModel.getAlignment() !== position ) {
		this.imageModel.setAlignment( position );
		this.checkChanged();
	}
};

/**
 * Respond to change in alternate text
 * @param {string} text New alternate text
 */
ve.ui.MWMediaDialog.prototype.onAlternateTextChange = function ( text ) {
	this.imageModel.setAltText( text );
	this.checkChanged();
};

/**
 * When changes occur, enable the apply button.
 */
ve.ui.MWMediaDialog.prototype.checkChanged = function () {
	var captionChanged = false;

	// Only check 'changed' status after the model has finished
	// building itself
	if ( !this.isSettingUpModel ) {
		if ( this.captionSurface && this.captionSurface.getSurface() ) {
			captionChanged = this.captionSurface.getSurface().getModel().hasBeenModified();
		}

		if (
			// Activate or deactivate the apply/insert buttons
			// Make sure sizes are valid first
			this.sizeWidget.isValid() &&
			(
				// Check that the model or caption changed
				this.isInsertion && this.imageModel ||
				captionChanged ||
				this.imageModel.hasBeenModified()
			)
		) {
			this.actions.setAbilities( { insert: true, apply: true } );
		} else {
			this.actions.setAbilities( { insert: false, apply: false } );
		}
	}
};

/**
 * Get the object of file repos to use for the media search
 *
 * @returns {jQuery.Promise}
 */
ve.ui.MWMediaDialog.prototype.getFileRepos = function () {
	var defaultSource = [ {
			url: mw.util.wikiScript( 'api' ),
			local: true
		} ];

	if ( !this.fileRepoPromise ) {
		this.fileRepoPromise = ve.init.target.constructor.static.apiRequest( {
			action: 'query',
			meta: 'filerepoinfo'
		} ).then(
			function ( resp ) {
				return resp.query && resp.query.repos || defaultSource;
			},
			function () {
				return $.Deferred().resolve( defaultSource );
			}
		);
	}

	return this.fileRepoPromise;
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.MWMediaDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			var pageTitle = mw.config.get( 'wgTitle' ),
				namespace = mw.config.get( 'wgNamespaceNumber' ),
				namespacesWithSubpages = mw.config.get( 'wgVisualEditor' ).namespacesWithSubpages;

			// Read the page title
			if ( namespacesWithSubpages[ namespace ] ) {
				// If we are in a namespace that allows for subpages, strip the entire
				// title except for the part after the last /
				pageTitle = pageTitle.slice( pageTitle.lastIndexOf( '/' ) + 1 );
			}
			this.pageTitle = pageTitle;

			if ( this.selectedNode ) {
				this.isInsertion = false;
				// Create image model
				this.imageModel = ve.dm.MWImageModel.static.newFromImageAttributes(
					this.selectedNode.getAttributes(),
					this.selectedNode.getDocument().getDir(),
					this.selectedNode.getDocument().getLang(),
					this.selectedNode.getType() === 'wikiaInlineVideo' || this.selectedNode.getType() === 'wikiaBlockVideo'
				);
				this.attachImageModel();

				if ( !this.imageModel.isDefaultSize() ) {
					// To avoid dirty diff in case where only the image changes,
					// we will store the initial bounding box, in case the image
					// is not defaultSize
					this.imageModel.setBoundingBox( this.imageModel.getCurrentDimensions() );
				}
				// Store initial hash to compare against
				this.imageModel.storeInitialHash( this.imageModel.getHashObject() );
			} else {
				this.isInsertion = true;
			}

			this.resetCaption();

			this.actions.setAbilities( { insert: false, apply: false } );

			// Initialization
			this.captionFieldset.$element.append( this.captionSurface.$element );
			this.captionSurface.$element.addClass( 'WikiaArticle' );
			this.captionSurface.initialize();

			this.switchPanels( this.selectedNode ? 'edit' : 'search' );
		}, this );
};

/**
 * Switch between the edit and insert/search panels
 * @param {string} panel Panel name
 */
ve.ui.MWMediaDialog.prototype.switchPanels = function ( panel ) {
	switch ( panel ) {
		case 'edit':
			// Set the edit panel
			this.panels.setItem( this.bookletLayout );
			// Focus the general settings page
			this.bookletLayout.setPage( 'general' );
			// Hide/show buttons
			this.actions.setMode( this.selectedNode ? 'edit' : 'insert' );
			// HACK: OO.ui.Dialog needs an API for this
			this.$content.removeClass( 'oo-ui-dialog-content-footless' );
			// Focus the caption surface
			this.captionSurface.focus();
			// Hide/show the panels
			this.bookletLayout.$element.show();
			this.mediaSearchPanel.$element.hide();
			break;
		default:
		case 'search':
			// Show a spinner while we check for file repos.
			// this will only be done once per session.
			// The filerepo promise will be sent to the API
			// only once per session so this will be resolved
			// every time the search panel reloads
			this.$spinner.show();
			this.search.$element.hide();

			// Get the repos from the API first
			// The ajax request will only be done once per session
			this.getFileRepos().done( function ( repos ) {
				this.search.setSources( repos );
				// Done, hide the spinner
				this.$spinner.hide();
				// Show the search and query the media sources
				this.search.$element.show();
				this.search.query.setValue( this.pageTitle );
				this.search.queryMediaSources();
				// Initialization
				// This must be done only after there are proper
				// sources defined
				this.search.getQuery().focus().select();
				this.search.getResults().selectItem();
				this.search.getResults().highlightItem();
			}.bind( this ) );

			// Set the edit panel
			this.panels.setItem( this.mediaSearchPanel );
			this.actions.setMode( this.imageModel ? 'change' : 'select' );

			// HACK: OO.ui.Dialog needs an API for this
			this.$content.toggleClass( 'oo-ui-dialog-content-footless', !this.imageModel );

			// Hide/show the panels
			this.bookletLayout.$element.hide();
			this.mediaSearchPanel.$element.show();
			break;
	}
};

/**
 * Attach the image model to the dialog
 */
ve.ui.MWMediaDialog.prototype.attachImageModel = function () {
	if ( this.imageModel ) {
		this.imageModel.disconnect( this );
		this.sizeWidget.disconnect( this );
	}

	// Events
	this.imageModel.connect( this, {
		alignmentChange: 'onImageModelAlignmentChange',
		sizeDefaultChange: 'checkChanged'
	} );

	// Set up
	// Ignore the following changes in validation while we are
	// setting up the initial tools according to the model state
	this.isSettingUpModel = true;

	// Size widget
	this.sizeErrorLabel.$element.hide();
	this.sizeWidget.setScalable( this.imageModel.getScalable() );
	this.sizeWidget.connect( this, {
		changeSizeType: 'checkChanged',
		change: 'checkChanged',
		valid: 'checkChanged'
	} );

	// Initialize size
	this.sizeWidget.setSizeType(
		this.imageModel.isDefaultSize() ?
		'default' :
		'custom'
	);
	this.sizeWidget.setDisabled( this.imageModel.getType() === 'frame' );

	// Update default dimensions
	this.sizeWidget.updateDefaultDimensions();

	// Set initial alignment
	this.positionSelect.setDisabled(
		!this.imageModel.isAligned()
	);
	this.positionSelect.selectItem(
		this.imageModel.isAligned() ?
		this.positionSelect.getItemFromData(
			this.imageModel.getAlignment()
		) :
		null
	);
	this.positionCheckbox.setSelected(
		this.imageModel.isAligned()
	);

	this.isSettingUpModel = false;
};

/**
 * Reset the caption surface
 */
ve.ui.MWMediaDialog.prototype.resetCaption = function () {
	var captionDocument,
		doc = this.getFragment().getDocument(),
		toolbarGroups = [
			// History
			{ include: [ 'undo' ] },
			// Style
			{ include: [ 'bold', 'italic', 'link' ] },
			{
				type: 'list',
				icon: 'text-style',
				indicator: 'down',
				title: OO.ui.deferMsg( 'visualeditor-toolbar-style-tooltip' ),
				include: [ 'subscript', 'superscript', 'strikethrough', 'underline', 'indent', 'outdent', 'clear' ]
			}
		];

	if ( this.captionSurface ) {
		// Reset the caption surface if it already exists
		this.captionSurface.destroy();
		this.captionSurface = null;
		this.captionNode = null;
	}
	// Get existing caption. We only do this in setup, because the caption
	// should not reset to original if the image is replaced or edited.

	// If the selected node is a block image and the caption already exists,
	// store the initial caption and set it as the caption document
	if (
		this.imageModel &&
		this.selectedNode &&
		this.selectedNode.getDocument() &&
		this.selectedNode instanceof ve.dm.MWBlockImageNode
	) {
		this.captionNode = this.selectedNode.getCaptionNode();
		if ( this.captionNode && this.captionNode.getLength() > 0 ) {
			this.imageModel.setCaptionDocument(
				this.selectedNode.getDocument().cloneFromRange( this.captionNode.getRange() )
			);
		}
	}

	if ( this.imageModel ) {
		captionDocument = this.imageModel.getCaptionDocument();
	} else {
		captionDocument = new ve.dm.Document( [
			{ type: 'paragraph', internal: { generated: 'wrapper' } },
			{ type: '/paragraph' },
			{ type: 'internalList' },
			{ type: '/internalList' }
		],
		// The ve.dm.Document constructor expects
		// ( data, htmlDocument, parentDocument, internalList, innerWhitespace, lang, dir )
		// as parameters. We are only interested in setting up language, hence the
		// multiple 'null' values.
		null, null, null, null, doc.getLang(), doc.getDir() );
	}

	this.store = doc.getStore();

	// Set up the caption surface
	this.captionSurface = new ve.ui.MWSurfaceWidget(
		captionDocument,
		{
			$: this.$,
			tools: toolbarGroups,
			excludeCommands: this.constructor.static.excludeCommands,
			importRules: this.constructor.static.getImportRules()
		}
	);

	// Events

	this.captionSurface.getSurface().getModel().getDocument().connect( this, {
		transact: this.checkChanged.bind( this )
	} );
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaDialog.prototype.getReadyProcess = function ( data ) {
	return ve.ui.MWMediaDialog.super.prototype.getReadyProcess.call( this, data )
		.next( function () {
			// Focus the caption surface
			this.captionSurface.focus();
			// Revalidate size
			this.sizeWidget.validateDimensions();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.MWMediaDialog.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			// Cleanup
			this.search.getQuery().setValue( '' );
			if ( this.imageModel ) {
				this.imageModel.disconnect( this );
				this.sizeWidget.disconnect( this );
			}
			this.captionSurface.destroy();
			this.captionSurface = null;
			this.captionNode = null;
			this.imageModel = null;
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaDialog.prototype.getActionProcess = function ( action ) {
	if ( action === 'change' ) {
		return new OO.ui.Process( function () {
			this.switchPanels( 'search' );
		}, this );
	}
	if ( action === 'back' ) {
		return new OO.ui.Process( function () {
			this.switchPanels( 'edit' );
		}, this );
	}
	if ( action === 'apply' || action === 'insert' ) {
		return new OO.ui.Process( function () {
			var surfaceModel = this.getFragment().getSurface();

			// Update from the form
			this.imageModel.setCaptionDocument(
				this.captionSurface.getSurface().getModel().getDocument()
			);

			// TODO: Simplify this condition
			if ( this.imageModel ) {
				if (
					// There was an initial node
					this.selectedNode &&
					// And we didn't change the image type block/inline or vise versa
					this.selectedNode.type === this.imageModel.getImageNodeType() &&
					// And we didn't change the image itself
					this.selectedNode.getAttribute( 'src' ) ===
						this.imageModel.getImageSource()
				) {
					// We only need to update the attributes of the current node
					this.imageModel.updateImageNode( this.selectedNode, surfaceModel );
				} else {
					// Replacing an image or inserting a brand new one

					// If there was a previous node, remove it first
					if ( this.selectedNode ) {
						// Remove the old image
						this.fragment = this.getFragment().clone(
							new ve.dm.LinearSelection( this.fragment.getDocument(), this.selectedNode.getOuterRange() )
						);
						this.fragment.removeContent();
					}
					// Insert the new image
					this.fragment = this.imageModel.insertImageNode( this.getFragment() );
				}
			}

			this.close( { action: action } );
		}, this );
	}
	return ve.ui.MWMediaDialog.super.prototype.getActionProcess.call( this, action );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWMediaDialog );
