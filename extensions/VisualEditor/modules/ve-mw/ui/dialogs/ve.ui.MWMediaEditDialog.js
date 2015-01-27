/*!
 * VisualEditor user interface MWMediaEditDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for editing MediaWiki media objects.
 *
 * @class
 * @extends ve.ui.NodeDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMediaEditDialog = function VeUiMWMediaEditDialog( config ) {
	// Parent constructor
	ve.ui.MWMediaEditDialog.super.call( this, config );

	// Properties
	this.mediaNode = null;
	this.imageModel = null;
	this.store = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.MWMediaEditDialog, ve.ui.NodeDialog );

/* Static Properties */

ve.ui.MWMediaEditDialog.static.name = 'mediaEdit';

ve.ui.MWMediaEditDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-media-title' );

ve.ui.MWMediaEditDialog.static.icon = 'picture';

ve.ui.MWMediaEditDialog.static.defaultSize = 'large';

ve.ui.MWMediaEditDialog.static.modelClasses = [ ve.dm.MWBlockImageNode ];

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
		'label': OO.ui.deferMsg( 'visualeditor-toolbar-cite-label' ),
		'indicator': 'down',
		'include': [ { 'group': 'cite' } ]
	},
	// No structure
	/* {
		'type': 'list',
		'icon': 'bullet-list',
		'indicator': 'down',
		'include': [ { 'group': 'structure' } ],
		'demote': [ 'outdent', 'indent' ]
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

/**
 * Get the paste rules for the surface widget in the dialog
 *
 * @see ve.dm.ElementLinearData#sanitize
 * @return {Object} Paste rules
 */
ve.ui.MWMediaEditDialog.static.getPasteRules = function () {
	return ve.extendObject(
		ve.copy( ve.init.target.constructor.static.pasteRules ),
		{
			'all': {
				'blacklist': OO.simpleArrayUnion(
					ve.getProp( ve.init.target.constructor.static.pasteRules, 'all', 'blacklist' ) || [],
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
};

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWMediaEditDialog.prototype.initialize = function () {
	//var altTextFieldset, positionFieldset, borderField, positionField;
	var positionFieldset, positionField;

	// Parent method
	ve.ui.MWMediaEditDialog.super.prototype.initialize.call( this );

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
			'label': ve.msg( 'visualeditor-dialog-media-position-left' ),
			'flags': ['secondary']
		} ),
		new OO.ui.ButtonOptionWidget( 'center', {
			'$': this.$,
			'icon': 'align-center',
			'label': ve.msg( 'visualeditor-dialog-media-position-center' ),
			'flags': ['secondary']
		} ),
		new OO.ui.ButtonOptionWidget( 'right', {
			'$': this.$,
			'icon': 'align-float-right',
			'label': ve.msg( 'visualeditor-dialog-media-position-right' ),
			'flags': ['secondary']
		} )
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
			'icon': 'image-thumbnail',
			'label': ve.msg( 'visualeditor-dialog-media-type-thumb' )
		} ),
		new OO.ui.ButtonOptionWidget( 'frameless', {
			'$': this.$,
			'icon': 'image-frameless',
			'label': ve.msg( 'visualeditor-dialog-media-type-frameless' )
		} ),
		new OO.ui.ButtonOptionWidget( 'frame', {
			'$': this.$,
			'icon': 'image-frame',
			'label': ve.msg( 'visualeditor-dialog-media-type-frame' )
		} ),
		new OO.ui.ButtonOptionWidget( 'none', {
			'$': this.$,
			'icon': 'image-none',
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

	// Events
	this.positionCheckbox.connect( this, { 'change': 'onPositionCheckboxChange' } );
	//this.borderCheckbox.connect( this, { 'change': 'onBorderCheckboxChange' } );
	this.positionInput.connect( this, { 'choose': 'onPositionInputChoose' } );
	//this.typeInput.connect( this, { 'choose': 'onTypeInputChoose' } );

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

	this.panels.addItems( [ this.bookletLayout ] );
};

/**
 * Handle image model alignment change
 * @param {string} alignment Image alignment
 */
ve.ui.MWMediaEditDialog.prototype.onImageModelAlignmentChange = function ( alignment ) {
	var item;
	alignment = alignment || 'none';

	item = alignment !== 'none' ? this.positionInput.getItemFromData( alignment ) : null;

	// Select the item without triggering the 'choose' event
	this.positionInput.selectItem( item );

	this.positionCheckbox.setValue( alignment !== 'none' );
};

/**
 * Handle image model type change
 * @param {string} alignment Image alignment
 */
ve.ui.MWMediaEditDialog.prototype.onImageModelTypeChange = function ( type ) {
	var item = type ? this.typeInput.getItemFromData( type ) : null;

	this.typeInput.selectItem( item );

	this.borderCheckbox.setDisabled(
		!this.imageModel.isBorderable()
	);

	this.borderCheckbox.setValue(
		this.imageModel.isBorderable() && this.imageModel.hasBorder()
	);
};

/**
 * Handle change event on the positionCheckbox element.
 *
 * @param {boolean} checked Checkbox status
 */
ve.ui.MWMediaEditDialog.prototype.onPositionCheckboxChange = function ( checked ) {
	var newPositionValue,
		currentModelAlignment = this.imageModel.getAlignment();

	this.positionInput.setDisabled( !checked );
	// Only update the model if the current value is different than that
	// of the image model
	if (
		( currentModelAlignment === 'none' && checked ) ||
		( currentModelAlignment !== 'none' && !checked )
	) {
		if ( checked ) {
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
 * Handle change event on the positionCheckbox element.
 *
 * @param {boolean} checked Checkbox status
 */
ve.ui.MWMediaEditDialog.prototype.onBorderCheckboxChange = function ( checked ) {
	// Only update if the value is different than the model
	if ( this.imageModel.hasBorder() !== checked ) {
		// Update the image model
		this.imageModel.toggleBorder( checked );
	}
};

/**
 * Handle change event on the positionInput element.
 *
 * @param {OO.ui.ButtonOptionWidget} item Selected item
 */
ve.ui.MWMediaEditDialog.prototype.onPositionInputChoose = function ( item ) {
	var position = item ? item.getData() : 'default';

	// Only update if the value is different than the model
	if ( this.imageModel.getAlignment() !== position ) {
		this.imageModel.setAlignment( position );
	}
};

/**
 * Handle change event on the typeInput element.
 *
 * @param {OO.ui.ButtonOptionWidget} item Selected item
 */
ve.ui.MWMediaEditDialog.prototype.onTypeInputChoose = function ( item ) {
	var type = item ? item.getData() : 'default';

	// Only update if the value is different than the model
	if ( this.imageModel.getType() !== type ) {
		this.imageModel.setType( type );
	}

	// If type is 'frame', disable the size input widget completely
	this.sizeWidget.setDisabled( type === 'frame' );
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaEditDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.MWMediaEditDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			var doc = this.getFragment().getSurface().getDocument();

			// Properties
			this.mediaNode = this.getFragment().getSelectedNode();
			// Image model
			this.imageModel = ve.dm.MWImageModel.static.newFromImageNode( this.mediaNode );
			// Events
			this.imageModel.connect( this, {
				'alignmentChange': 'onImageModelAlignmentChange'
				//'typeChange': 'onImageModelTypeChange'
			} );

			this.store = doc.getStore();
			// Set up the caption surface
			this.captionSurface = new ve.ui.SurfaceWidget(
				this.imageModel.getCaptionDocument(),
				{
					'$': this.$,
					'tools': this.constructor.static.toolbarGroups,
					'commands': this.constructor.static.surfaceCommands,
					'pasteRules': this.constructor.static.getPasteRules()
				}
			);
			this.captionSurface.getSurface().getModel().connect( this, {
				'documentUpdate': function () {
					this.wikitextWarning = ve.init.mw.ViewPageTarget.static.checkForWikitextWarning(
						this.captionSurface.getSurface(),
						this.wikitextWarning
					);
				}
			} );

			// Size widget
			this.$spinner.hide();
			this.sizeErrorLabel.$element.hide();
			this.sizeWidget.setScalable( this.imageModel.getScalable() );

			// Initialize size
			this.sizeWidget.setSizeType(
				this.imageModel.isDefaultSize() ?
				'default' :
				'custom'
			);

			this.sizeWidget.setDisabled( this.imageModel.getType() === 'frame' );

			// Set initial alt text
			/*this.altTextInput.setValue(
				this.imageModel.getAltText()
			);*/

			// Set initial alignment
			this.positionInput.setDisabled(
				!this.imageModel.isAligned()
			);
			this.positionInput.selectItem(
				this.imageModel.isAligned() ?
				this.positionInput.getItemFromData(
					this.imageModel.getAlignment()
				) :
				null
			);
			this.positionCheckbox.setValue(
				this.imageModel.isAligned()
			);

			// Border flag
			/*this.borderCheckbox.setDisabled(
				!this.imageModel.isBorderable()
			);
			this.borderCheckbox.setValue(
				this.imageModel.isBorderable() && this.imageModel.hasBorder()
			);*/

			// Type select
			/*this.typeInput.selectItem(
				this.typeInput.getItemFromData(
					this.imageModel.getType() || 'none'
				)
			);*/

			// Initialization
			this.captionSurface.$element.addClass( 'WikiaArticle' );
			this.captionFieldset.$element.append( this.captionSurface.$element );
			this.captionSurface.initialize();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaEditDialog.prototype.getReadyProcess = function ( data ) {
	return ve.ui.MWMediaEditDialog.super.prototype.getReadyProcess.call( this, data )
		.next( function () {
			// Focus the caption surface
			this.captionSurface.focus();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaEditDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.MWMediaEditDialog.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			// Cleanup
			this.imageModel.disconnect( this );
			if ( this.wikitextWarning ) {
				this.wikitextWarning.close();
			}
			this.captionSurface.destroy();
			this.captionSurface = null;
			this.captionNode = null;
			// Reset the considerations for the scalable
			// in the image node
			this.mediaNode.syncScalableToType();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaEditDialog.prototype.applyChanges = function () {
	var surfaceModel = this.getFragment().getSurface();

	// Update from the form
	/*this.imageModel.setAltText(
		this.altTextInput.getValue()
	);*/

	this.imageModel.setCaptionDocument(
		this.captionSurface.getSurface().getModel().getDocument()
	);

	// Check if the image node changed from inline to block or
	// vise versa
	if ( this.mediaNode.type !== this.imageModel.getImageNodeType() ) {
		// Remove the old image
		this.fragment = this.getFragment().clone( this.mediaNode.getOuterRange() );
		this.fragment.removeContent();
		// Insert the new image
		this.fragment = this.imageModel.insertImageNode( this.getFragment() );
	} else {
		// Update current node
		this.imageModel.updateImageNode( surfaceModel );
	}

	// Parent method
	return ve.ui.MWMediaEditDialog.super.prototype.applyChanges.call( this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWMediaEditDialog );
