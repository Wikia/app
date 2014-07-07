/*!
 * VisualEditor user interface MWMediaEditDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */
/*global mw */

/**
 * Dialog for editing MediaWiki media objects.
 *
 * @class
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMediaEditDialog = function VeUiMWMediaEditDialog( config ) {
	// Parent constructor
	ve.ui.Dialog.call( this, config );

	// Properties
	this.mediaNode = null;
	this.captionNode = null;
	this.store = null;
	this.scalable = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.MWMediaEditDialog, ve.ui.Dialog );

/* Static Properties */

ve.ui.MWMediaEditDialog.static.name = 'mediaEdit';

ve.ui.MWMediaEditDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-media-title' );

ve.ui.MWMediaEditDialog.static.icon = 'picture';

ve.ui.MWMediaEditDialog.static.toolbarGroups = [
	// History
	{ 'include': [ 'undo', 'redo' ] },
	// No formatting
	/* {
		'type': 'menu',
		'indicator': 'down',
		'title': OO.ui.deferMsg( 'visualeditor-toolbar-format-tooltip' ),
		'include': [ { 'group': 'format' } ],
		'promote': [ 'paragraph' ],
		'demote': [ 'preformatted', 'heading1' ]
	},*/
	// Style
	{
		'type': 'list',
		'icon': 'text-style',
		'indicator': 'down',
		'title': OO.ui.deferMsg( 'visualeditor-toolbar-style-tooltip' ),
		'include': [ { 'group': 'textStyle' }, 'clear' ],
		'promote': [ 'bold', 'italic' ],
		'demote': [ 'strikethrough', 'code', 'underline', 'clear' ]
	},
	// Link
	{ 'include': [ 'link' ] },
	// Cite
	{
		'type': 'list',
		'label': 'Cite',
		'indicator': 'down',
		'include': [ { 'group': 'cite' } ]
	},
	// No structure
	/* {
		'type': 'bar',
		'include': [ 'number', 'bullet', 'outdent', 'indent' ]
	},*/
	// Insert
	{
		'label': OO.ui.deferMsg( 'visualeditor-toolbar-insert' ),
		'indicator': 'down',
		'include': '*',
		'exclude': [
			{ 'group': 'format' },
			{ 'group': 'structure' },
			'referenceList',
			'wikiaMediaInsert',
			'mediaInsert',
			'code',
			'wikiaSourceMode',
			'gallery'
		],
		'promote': [ 'reference', 'mediaInsert' ],
		'demote': [ 'language', 'specialcharacter' ]
	}
];

ve.ui.MWMediaEditDialog.static.surfaceCommands = [
	'undo',
	'redo',
	'bold',
	'italic',
	'link',
	'clear',
	'underline',
	'subscript',
	'superscript',
	'pasteSpecial'
];

ve.ui.MWMediaEditDialog.static.pasteRules = ve.extendObject(
	ve.copy( ve.init.mw.Target.static.pasteRules ),
	{
		'all': {
			'blacklist': OO.simpleArrayUnion(
				ve.getProp( ve.init.mw.Target.static.pasteRules, 'all', 'blacklist' ) || [],
				[
					// Tables (but not lists) are possible in wikitext with a leading
					// line break but we prevent creating these with the UI
					'list', 'listItem', 'definitionList', 'definitionListItem',
					'table', 'tableCaption', 'tableSection', 'tableRow', 'tableCell'
				]
			),
			// Headings are also possible, but discouraged
			'conversions': {
				'mwHeading': 'paragraph'
			}
		}
	}
);

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWMediaEditDialog.prototype.initialize = function () {
	//var altTextFieldset, positionFieldset, borderField, positionField;
	var positionFieldset, positionField;
	// Parent method
	ve.ui.Dialog.prototype.initialize.call( this );

	this.$spinner = this.$( '<div>' ).addClass( 've-specialchar-spinner' );

	// Set up the booklet layout
	this.bookletLayout = new OO.ui.BookletLayout( {
		'$': this.$,
		'outlined': true
	} );

	this.generalSettingsPage = new OO.ui.PageLayout( 'general', { '$': this.$ } );
	this.advancedSettingsPage = new OO.ui.PageLayout( 'advanced', { '$': this.$ } );
	this.bookletLayout.addPages( [
		this.generalSettingsPage, this.advancedSettingsPage
	] );
	this.generalSettingsPage.getOutlineItem()
		.setIcon( 'parameter' )
		.setLabel( ve.msg( 'visualeditor-dialog-media-page-general' ) );
	this.advancedSettingsPage.getOutlineItem()
		.setIcon( 'parameter' )
		.setLabel( ve.msg( 'visualeditor-dialog-media-page-advanced' ) );

	// Define fieldsets for image settings

	// Caption
	this.captionFieldset = new OO.ui.FieldsetLayout( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-media-content-section' ),
		'icon': 'parameter'
	} );

	// Alt text
	/* altTextFieldset = new OO.ui.FieldsetLayout( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-media-alttext-section' ),
		'icon': 'parameter'
	} );

	this.altTextInput = new OO.ui.TextInputWidget( {
		'$': this.$
	} );

	this.altTextInput.$element.addClass( 've-ui-mwMediaEditDialog-altText' );

	// Build alt text fieldset
	altTextFieldset.$element
		.append( this.altTextInput.$element );*/

	// Position
	this.positionInput =  new OO.ui.ButtonSelectWidget( {
		'$': this.$
	} );
	this.positionInput.addItems( [
		new OO.ui.ButtonOptionWidget( 'left', {
			'$': this.$,
			'icon': 'align-float-left',
			'label': ve.msg( 'visualeditor-dialog-media-position-left' )
		} ),
		new OO.ui.ButtonOptionWidget( 'center', {
			'$': this.$,
			'icon': 'align-center',
			'label': ve.msg( 'visualeditor-dialog-media-position-center' )
		} ),
		new OO.ui.ButtonOptionWidget( 'right', {
			'$': this.$,
			'icon': 'align-float-right',
			'label': ve.msg( 'visualeditor-dialog-media-position-right' )
		} ),
	], 0 );

	this.positionCheckbox = new OO.ui.CheckboxInputWidget( {
		'$': this.$
	} );
	positionField = new OO.ui.FieldLayout( this.positionCheckbox, {
		'$': this.$,
		'align': 'inline',
		'label': ve.msg( 'visualeditor-dialog-media-position-checkbox' )
	} );

	positionFieldset = new OO.ui.FieldsetLayout( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-media-position-section' ),
		'icon': 'parameter'
	} );

	// Build position fieldset
	positionFieldset.$element.append( [
		positionField.$element,
		this.positionInput.$element
	] );

	// Type
	/* this.typeFieldset = new OO.ui.FieldsetLayout( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-media-type-section' ),
		'icon': 'parameter'
	} );

	this.typeInput = new OO.ui.ButtonSelectWidget( {
		'$': this.$
	} );
	this.typeInput.addItems( [
		// TODO: Inline images require a bit of further work, will be coming soon
		new OO.ui.ButtonOptionWidget( 'thumb', {
			'$': this.$,
			'label': ve.msg( 'visualeditor-dialog-media-type-thumb' )
		} ),
		new OO.ui.ButtonOptionWidget( 'frameless', {
			'$': this.$,
			'label': ve.msg( 'visualeditor-dialog-media-type-frameless' )
		} ),
		new OO.ui.ButtonOptionWidget( 'frame', {
			'$': this.$,
			'label': ve.msg( 'visualeditor-dialog-media-type-frame' )
		} ),
		new OO.ui.ButtonOptionWidget( 'none', {
			'$': this.$,
			'label': ve.msg( 'visualeditor-dialog-media-type-none' )
		} )
	] );
	this.borderCheckbox = new OO.ui.CheckboxInputWidget( {
		'$': this.$
	} );
	borderField = new OO.ui.FieldLayout( this.borderCheckbox, {
		'$': this.$,
		'align': 'inline',
		'label': ve.msg( 'visualeditor-dialog-media-type-border' )
	} );

	// Build type fieldset
	this.typeFieldset.$element.append( [
		this.typeInput.$element,
		borderField.$element
	] );*/

	// Size
	this.sizeFieldset = new OO.ui.FieldsetLayout( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-media-size-section' ),
		'icon': 'parameter'
	} );

	this.sizeErrorLabel = new OO.ui.LabelWidget( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-media-size-originalsize-error' )
	} );

	this.sizeWidget = new ve.ui.MediaSizeWidget( {}, {
		'$': this.$
	} );

	this.$sizeWidgetElements = this.$( '<div>' ).append( [
		this.sizeWidget.$element,
		this.sizeErrorLabel.$element
	] );
	this.sizeFieldset.$element.append( [
		this.$spinner,
		this.$sizeWidgetElements
	] );

	// Get wiki default thumbnail size
	this.defaultThumbSize = mw.config.get( 'wgVisualEditorConfig' ).defaultUserOptions.defaultthumbsize;

	this.applyButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-action-apply' ),
		'flags': ['primary']
	} );

	// Events
	this.applyButton.connect( this, { 'click': [ 'close', { 'action': 'apply' } ] } );
	this.positionCheckbox.connect( this, { 'change': 'onPositionCheckboxChange' } );
	this.sizeWidget.connect( this, { 'change': 'onSizeWidgetChange' } );
	//this.typeInput.connect( this, { 'select': 'onTypeChange' } );

	// Initialization
	this.generalSettingsPage.$element.append( [
		this.captionFieldset.$element
		//altTextFieldset.$element
	] );

	this.advancedSettingsPage.$element.append( [
		positionFieldset.$element,
		//this.typeFieldset.$element,
		this.sizeFieldset.$element
	] );

	this.$body.append( this.bookletLayout.$element );
	this.$foot.append( this.applyButton.$element );
};

/**
 * Handle change event on the sizeWidget. Switch the size select
 * from default to custom and vise versa based on the values in
 * the widget.
 */
ve.ui.MWMediaEditDialog.prototype.onSizeWidgetChange = function () {
	// Switch to 'default' or 'custom' size
	if ( this.sizeWidget.isEmpty() ) {
		this.sizeWidget.setSizeType( 'default' );
	} else {
		this.sizeWidget.setSizeType( 'custom' );
	}
};

/**
 * Handle type change, particularly to and from 'thumb' to make
 * sure size is limited.
 * @param {OO.ui.ButtonOptionWidget} item Selected item
 */
ve.ui.MWMediaEditDialog.prototype.onTypeChange = function ( item ) {
	var selectedType = item ? item.getData() : '',
		thumbOrFrameless = selectedType === 'thumb' || selectedType === 'frameless',
		originalDimensions = this.scalable.getOriginalDimensions();

	// As per wikitext docs, both 'thumb' and 'frameless' images are
	// limited in max size to their original size
	if ( thumbOrFrameless ) {
		if ( originalDimensions ) {
			// Set original dimensions as the max. In the future we may
			// want to switch between original dimensions (in frameless
			// and thumb) and perhaps some preset maximum dimensions for
			// basic and frameless.
			this.scalable.setMaxDimensions( originalDimensions );
			this.scalable.setEnforcedMax( true );
		} else {
			// We don't have maximum dimensions available, so we can't
			// enforce any max size
			this.scalable.setEnforcedMax( false );
		}
		// Disable border option
		//this.borderCheckbox.setDisabled( true );
		//this.borderCheckbox.setValue( false );
	} else {
		// Don't limit maximum dimensions on basic and frameless images
		this.scalable.setEnforcedMax( false );
		// Enable border option
		//this.borderCheckbox.setDisabled( false );
	}

	// Re-validate the existing dimensions
	this.sizeWidget.validateDimensions();
};

/**
 * Handle change event on the positionCheckbox element. If an option
 * is selected, mark the checkbox
 */
ve.ui.MWMediaEditDialog.prototype.onPositionCheckboxChange = function () {
	var checked = this.positionCheckbox.getValue();

	if ( !checked ) {
		// If unchecked, remove selection
		this.positionInput.selectItem( null );
	} else {
		// If checked, choose default position
		if ( this.getFragment().getDocument().getDir() === 'ltr' ) {
			// Assume default is 'right'
			this.positionInput.selectItem(
				this.positionInput.getItemFromData( 'right' )
			);
		} else {
			// Assume default is 'left'
			this.positionInput.selectItem(
				this.positionInput.getItemFromData( 'left' )
			);
		}
	}

	this.positionInput.setDisabled( !checked );
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaEditDialog.prototype.setup = function ( data ) {
	var newDoc,
		dialog = this,
		doc = this.getFragment().getSurface().getDocument();

	// Parent method
	ve.ui.Dialog.prototype.setup.call( this, data );

	// Properties
	this.mediaNode = this.getFragment().getSelectedNode();
	this.captionNode = this.mediaNode.getCaptionNode();
	this.store = doc.getStore();

	if ( this.captionNode && this.captionNode.getLength() > 0 ) {
		newDoc = doc.cloneFromRange( this.captionNode.getRange() );
	} else {
		newDoc = new ve.dm.Document( [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		] );
	}

	this.captionSurface = new ve.ui.SurfaceWidget(
		newDoc,
		{
			'$': this.$,
			'tools': this.constructor.static.toolbarGroups,
			'commands': this.constructor.static.surfaceCommands,
			'pasteRules': this.constructor.static.pasteRules
		}
	);

	this.$spinner.show();
	this.$sizeWidgetElements.hide();
	this.sizeErrorLabel.$element.hide();
	// Ask for the asynchronous call to get a full scalable object
	// with original dimensions and imageinfo from the API
	this.mediaNode.getScalablePromise()
		.done( ve.bind( function () {
			this.scalable = this.mediaNode.getScalable();
			this.$spinner.hide();
			this.$sizeWidgetElements.show();

			if (
				this.mediaNode.getAttribute( 'type' ) === 'thumb' &&
				this.scalable.getOriginalDimensions()
			) {
				// Set the max dimensions to the image's original dimensions
				this.scalable.setMaxDimensions(
					this.scalable.getOriginalDimensions()
				);
				// Tell the size widget to limit maxDimensions to image's original dimensions
				this.scalable.setEnforcedMax( true );
			} else {
				this.scalable.setEnforcedMax( false );
			}

			// Send the scalable object to the size widget
			this.sizeWidget.setScalable( this.scalable );
			this.scalable.setDefaultDimensions(
				this.scalable.getDimensionsFromValue( { 'width': this.defaultThumbSize } )
			);
		}, this ) )
		.fail( ve.bind( function () {
			dialog.sizeErrorLabel.$element.show();
		}, this ) );

	// Initialize size
	this.sizeWidget.setSizeType(
		this.mediaNode.getAttribute( 'defaultSize' ) ?
		'default' :
		'custom'
	);

	// Set initial alt text
	//this.altTextInput.setValue( this.mediaNode.getAttribute( 'alt' ) || '' );

	// Set initial position
	if (
		!this.mediaNode.getAttribute( 'align' ) ||
		this.mediaNode.getAttribute( 'align' ) === 'none'
	) {
		this.positionCheckbox.setValue( false );
		this.positionInput.setDisabled( true );
		this.positionInput.selectItem( null );
	} else {
		this.positionCheckbox.setValue( true );
		this.positionInput.setDisabled( false );
		if ( this.mediaNode.getAttribute( 'align' ) === 'default' ) {
			// Assume wiki default according to wiki dir
			if ( this.getFragment().getDocument().getDir() === 'ltr' ) {
				// Assume default is 'right'
				this.positionInput.selectItem(
					this.positionInput.getItemFromData( 'right' )
				);
			} else {
				// Assume default is 'left'
				this.positionInput.selectItem(
					this.positionInput.getItemFromData( 'left' )
				);
			}
		} else {
			this.positionInput.selectItem(
				this.positionInput.getItemFromData( this.mediaNode.getAttribute( 'align' ) )
			);
		}
	}

	// Border flag
	//this.borderCheckbox.setValue( !!this.mediaNode.getAttribute( 'borderImage' ) );

	// Set image type
	/* this.typeInput.selectItem( null );
	if ( this.mediaNode.getAttribute( 'type' ) !== undefined ) {
		this.typeInput.selectItem(
			this.typeInput.getItemFromData( this.mediaNode.getAttribute( 'type' ) )
		);
	} else {
		// Explicitly show 'none' if no type was specified
		this.typeInput.selectItem(
			this.typeInput.getItemFromData( 'none' )
		);
	}*/

	// Initialization
	this.captionSurface.$element.addClass( 'WikiaArticle' );
	this.captionFieldset.$element.append( this.captionSurface.$element );
	this.captionSurface.initialize();
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaEditDialog.prototype.teardown = function ( data ) {
	var newDoc, doc, /* originalAlt, */ attr, transactionAttributes = {},
		imageSizeType, /* imageType, */ imageAlignmentCheckbox,
		imageAlignmentValue, originalDimensions,
		surfaceModel = this.getFragment().getSurface();

	// Data initialization
	data = data || {};

	if ( data.action === 'apply' ) {
		newDoc = this.captionSurface.getSurface().getModel().getDocument();
		doc = surfaceModel.getDocument();
		if ( !this.captionNode ) {
			// Insert a new caption at the beginning of the image node
			surfaceModel.getFragment()
				.adjustRange( 1 )
				.collapseRangeToStart()
				.insertContent( [ { 'type': 'mwImageCaption' }, { 'type': '/mwImageCaption' } ] );
			this.captionNode = this.mediaNode.getCaptionNode();
		}
		// Replace the contents of the caption
		surfaceModel.change(
			ve.dm.Transaction.newFromRemoval( doc, this.captionNode.getRange(), true )
		);
		surfaceModel.change(
			ve.dm.Transaction.newFromDocumentInsertion( doc, this.captionNode.getRange().start, newDoc )
		);

		// Get all the details and their fallbacks
		imageSizeType = this.sizeWidget.getSizeType() || 'default';
		//imageType = this.typeInput.getSelectedItem() ? this.typeInput.getSelectedItem().getData() : '';
		imageAlignmentCheckbox = this.positionCheckbox.getValue();
		if ( imageAlignmentCheckbox && this.positionInput.getSelectedItem() ) {
			imageAlignmentValue = this.positionInput.getSelectedItem().getData();
		}

		// Size and scalabletravaganza
		attr = null;
		if ( imageSizeType === 'default' ) {
			transactionAttributes.defaultSize = true;
			originalDimensions = this.scalable.getOriginalDimensions();
			// Figure out the default size
			// if ( imageType === 'thumb' || imageType === 'frame' ) {
				// Default is thumb-default unless the image is originally smaller
				if ( originalDimensions.width > this.defaultThumbSize ) {
					attr = this.scalable.getDimensionsFromValue( { 'width': this.defaultThumbSize } );
				} else {
					attr = originalDimensions;
				}
			/* } else {
				// Default is full size
				if ( originalDimensions ) {
					attr = originalDimensions;
				}
			}*/

			// Apply
			if ( attr ) {
				transactionAttributes.width = attr.width;
				transactionAttributes.height = attr.height;
			}
		// Upright is not yet implemented in Parsoid. When it is,
		// the scale properties should be implemented here
		//} else if ( imageSizeType === 'scale' ) {
		} else if ( imageSizeType === 'custom' && this.sizeWidget.isValid() ) {
			attr = this.sizeWidget.getCurrentDimensions();
			transactionAttributes.width = attr.width;
			transactionAttributes.height = attr.height;
			transactionAttributes.defaultSize = false;
		}

		// Set alternate text
		/* attr = $.trim( this.altTextInput.getValue() );
		originalAlt = this.mediaNode.getAttribute( 'alt' );
		// Allow the user to submit an empty alternate text but
		// not if there was no alternate text originally to avoid
		// dirty diffing images with empty |alt=
		if (
			// If there was no original alternate text but there
			// is a value now, update
			( originalAlt === undefined && attr ) ||
			// If original alternate text was defined, always
			// update, even if the input is empty to allow the
			// user to unset it
			originalAlt !== undefined
		) {
			transactionAttributes.alt = attr;
		}*/

		if ( !imageAlignmentCheckbox ) {
			// Only change to 'none' if alignment was originally
			// set to anything else
			if (
				this.mediaNode.getAttribute( 'align' ) &&
				this.mediaNode.getAttribute( 'align' ) !== 'none'
			) {
				transactionAttributes.align = 'none';
			}
		} else {
			// If alignment was originally default and is still
			// set to the default position according to the wiki
			// content direction, do not change it
			if (
				(
					this.mediaNode.getAttribute( 'align' ) === 'default' &&
					(
						this.getFragment().getDocument().getDir() === 'ltr' &&
						imageAlignmentValue !== 'right'
					) ||
					(
						this.getFragment().getDocument().getDir() === 'rtl' &&
						imageAlignmentValue !== 'left'
					)
				) ||
				this.mediaNode.getAttribute( 'align' ) !== 'default'
			) {
				transactionAttributes.align = imageAlignmentValue;
			}
		}

		// Border
		/* if (
			!this.borderCheckbox.isDisabled() &&
			this.borderCheckbox.getValue() === true
		) {
			transactionAttributes.borderImage = true;
		} else {
			transactionAttributes.borderImage = false;
		}*/

		// Image type
		/* if ( imageType ) {
			transactionAttributes.type = imageType;
		}*/
		surfaceModel.change(
			ve.dm.Transaction.newFromAttributeChanges( doc, this.mediaNode.getOffset(), transactionAttributes )
		);
	}

	// Cleanup
	this.captionSurface.destroy();
	this.captionSurface = null;
	this.captionNode = null;

	// Parent method
	ve.ui.Dialog.prototype.teardown.call( this, data );
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.MWMediaEditDialog );
