/*!
 * VisualEditor user interface MWMediaDialog class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
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
	this.selectedImageInfo = null;
	this.searchCache = {};

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
		action: 'change',
		label: OO.ui.deferMsg( 'visualeditor-dialog-media-change-image' ),
		modes: [ 'edit', 'insert' ]
	},
	{
		action: 'choose',
		label: OO.ui.deferMsg( 'visualeditor-dialog-media-choose-image' ),
		flags: [ 'primary', 'progressive' ],
		modes: [ 'info' ]
	},
	{
		action: 'cancelchoose',
		label: OO.ui.deferMsg( 'visualeditor-dialog-media-goback' ),
		flags: [ 'safe', 'back' ],
		modes: [ 'info' ]
	},
	{
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-cancel' ),
		flags: [ 'safe', 'back' ],
		modes: [ 'edit', 'insert', 'select' ]
	},
	{
		action: 'back',
		label: OO.ui.deferMsg( 'visualeditor-dialog-media-goback' ),
		flags: [ 'safe', 'back' ],
		modes: [ 'change' ]
	}
];

ve.ui.MWMediaDialog.static.modelClasses = [ ve.dm.MWBlockImageNode, ve.dm.MWInlineImageNode ];

ve.ui.MWMediaDialog.static.includeCommands = null;

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
	// FIXME: This should vary on panel.
	return 500;
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaDialog.prototype.initialize = function () {
	var altTextFieldset, positionFieldset, borderField, positionField;

	// Parent method
	ve.ui.MWMediaDialog.super.prototype.initialize.call( this );

	this.panels = new OO.ui.StackLayout();

	// Set up the booklet layout
	this.bookletLayout = new OO.ui.BookletLayout( {
		classes: [ 've-ui-mwMediaDialog-panel-settings' ],
		outlined: true
	} );

	this.mediaSearchPanel = new OO.ui.PanelLayout( {
		classes: [ 've-ui-mwMediaDialog-panel-search' ],
		scrollable: true
	} );

	this.mediaImageInfoPanel = new OO.ui.PanelLayout( {
		classes: [ 've-ui-mwMediaDialog-panel-imageinfo' ],
		scrollable: false
	} );

	this.$infoPanelWrapper = $( '<div>' ).addClass( 've-ui-mwMediaDialog-panel-imageinfo-wrapper' );

	this.generalSettingsPage = new OO.ui.PageLayout( 'general' );
	this.advancedSettingsPage = new OO.ui.PageLayout( 'advanced' );
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
	this.search = new ve.ui.MWMediaSearchWidget();

	// Define fieldsets for image settings

	// Filename
	this.filenameFieldset = new OO.ui.FieldsetLayout( {
		label: ve.msg( 'visualeditor-dialog-media-content-filename' ),
		icon: 'picture'
	} );

	// Caption
	this.captionFieldset = new OO.ui.FieldsetLayout( {
		label: ve.msg( 'visualeditor-dialog-media-content-section' ),
		help: ve.msg( 'visualeditor-dialog-media-content-section-help' ),
		icon: 'parameter',
		classes: [ 've-ui-mwMediaDialog-caption-fielset' ]
	} );

	// Alt text
	altTextFieldset = new OO.ui.FieldsetLayout( {
		label: ve.msg( 'visualeditor-dialog-media-alttext-section' ),
		help: ve.msg( 'visualeditor-dialog-media-alttext-section-help' ),
		icon: 'parameter'
	} );

	this.altTextInput = new OO.ui.TextInputWidget();

	this.altTextInput.$element.addClass( 've-ui-mwMediaDialog-altText' );

	// Build alt text fieldset
	altTextFieldset.$element
		.append( this.altTextInput.$element );

	// Position
	this.positionSelect = new ve.ui.AlignWidget( {
		dir: this.getDir()
	} );

	this.positionCheckbox = new OO.ui.CheckboxInputWidget();
	positionField = new OO.ui.FieldLayout( this.positionCheckbox, {
		align: 'inline',
		label: ve.msg( 'visualeditor-dialog-media-position-checkbox' ),
		help: ve.msg( 'visualeditor-dialog-media-position-checkbox-help' )
	} );

	positionFieldset = new OO.ui.FieldsetLayout( {
		label: ve.msg( 'visualeditor-dialog-media-position-section' ),
		help: ve.msg( 'visualeditor-dialog-media-position-section-help' ),
		icon: 'parameter'
	} );

	// Build position fieldset
	positionFieldset.$element.append(
		positionField.$element,
		this.positionSelect.$element
	);

	// Type
	this.typeFieldset = new OO.ui.FieldsetLayout( {
		label: ve.msg( 'visualeditor-dialog-media-type-section' ),
		help: ve.msg( 'visualeditor-dialog-media-type-section-help' ),
		icon: 'parameter'
	} );

	this.typeSelect = new OO.ui.ButtonSelectWidget();
	this.typeSelect.addItems( [
		// TODO: Inline images require a bit of further work, will be coming soon
		new OO.ui.ButtonOptionWidget( {
			data: 'thumb',
			icon: 'image-thumbnail',
			label: ve.msg( 'visualeditor-dialog-media-type-thumb' )
		} ),
		new OO.ui.ButtonOptionWidget( {
			data: 'frameless',
			icon: 'image-frameless',
			label: ve.msg( 'visualeditor-dialog-media-type-frameless' )
		} ),
		new OO.ui.ButtonOptionWidget( {
			data: 'frame',
			icon: 'image-frame',
			label: ve.msg( 'visualeditor-dialog-media-type-frame' )
		} ),
		new OO.ui.ButtonOptionWidget( {
			data: 'none',
			icon: 'image-none',
			label: ve.msg( 'visualeditor-dialog-media-type-none' )
		} )
	] );
	this.borderCheckbox = new OO.ui.CheckboxInputWidget();
	borderField = new OO.ui.FieldLayout( this.borderCheckbox, {
		align: 'inline',
		label: ve.msg( 'visualeditor-dialog-media-type-border' )
	} );

	// Build type fieldset
	this.typeFieldset.$element.append(
		this.typeSelect.$element,
		borderField.$element
	);

	// Size
	this.sizeFieldset = new OO.ui.FieldsetLayout( {
		label: ve.msg( 'visualeditor-dialog-media-size-section' ),
		icon: 'parameter',
		help: ve.msg( 'visualeditor-dialog-media-size-section-help' )
	} );

	this.sizeErrorLabel = new OO.ui.LabelWidget( {
		label: ve.msg( 'visualeditor-dialog-media-size-originalsize-error' )
	} );

	this.sizeWidget = new ve.ui.MediaSizeWidget( {} );

	this.$sizeWidgetElements = $( '<div>' ).append(
		this.sizeWidget.$element,
		this.sizeErrorLabel.$element
	);
	this.sizeFieldset.$element.append(
		this.$sizeWidgetElements
	);

	// Events
	this.positionCheckbox.connect( this, { change: 'onPositionCheckboxChange' } );
	this.borderCheckbox.connect( this, { change: 'onBorderCheckboxChange' } );
	this.positionSelect.connect( this, { choose: 'onPositionSelectChoose' } );
	this.typeSelect.connect( this, { choose: 'onTypeSelectChoose' } );
	this.search.getResults().connect( this, { choose: 'onSearchResultsChoose' } );
	this.altTextInput.connect( this, { change: 'onAlternateTextChange' } );

	// Initialization
	this.mediaSearchPanel.$element.append( this.search.$element );
	this.generalSettingsPage.$element.append(
		this.filenameFieldset.$element,
		this.captionFieldset.$element,
		altTextFieldset.$element
	);

	this.advancedSettingsPage.$element.append(
		positionFieldset.$element,
		this.typeFieldset.$element,
		this.sizeFieldset.$element
	);

	this.panels.addItems( [
		this.mediaSearchPanel,
		this.mediaImageInfoPanel,
		this.bookletLayout
	] );

	this.$body.append( this.panels.$element );
};

/**
 * Build the image info panel from the information in the API.
 * Use the metadata info if it exists.
 * Note: Some information in the metadata object needs to be safely
 * stripped from its html wrappers.
 *
 * @param {Object} imageinfo Image info
 */
ve.ui.MWMediaDialog.prototype.buildMediaInfoPanel = function ( imageinfo ) {
	var i, newDimensions, field, isPortrait, $info, $section, windowWidth,
		contentDirection = this.getFragment().getDocument().getDir(),
		imageTitle = new OO.ui.LabelWidget( {
			label: mw.Title.newFromText( imageinfo.title ).getNameText()
		} ),
		metadata = imageinfo.extmetadata,
		// Field configuration (in order)
		apiDataKeysConfig = [
			{
				name: 'ImageDescription',
				value: ve.getProp( metadata, 'ImageDescription', 'value' ),
				data: {
					keepOriginal: true
				},
				view: {
					type: 'description',
					primary: true,
					descriptionHeight: '5em'
				}
			},
			{
				name: 'fileDetails',
				data: { skipProcessing: true },
				view: { icon: 'picture' }
			},
			{
				name: 'LicenseShortName',
				value: ve.getProp( metadata, 'LicenseShortName', 'value' ),
				data: {},
				view: {
					href: ve.getProp( metadata, 'LicenseUrl', 'value' ),
					icon: this.getLicenseIcon( ve.getProp( metadata, 'LicenseShortName', 'value' ) )
				}
			},
			{
				name: 'Artist',
				value: ve.getProp( metadata, 'Artist', 'value' ),
				data: {},
				view: {
					// "Artist" label
					label: 'visualeditor-dialog-media-info-meta-artist',
					icon: 'profile'
				}
			},
			{
				name: 'Credit',
				value: ve.getProp( metadata, 'Credit', 'value' ),
				data: {},
				view: { icon: 'profile' }
			},
			{
				name: 'user',
				value: imageinfo.user,
				data: { skipProcessing: true },
				view: {
					icon: 'profile',
					// This is 'uploaded by'
					label: 'visualeditor-dialog-media-info-artist'
				}
			},
			{
				name: 'timestamp',
				value: imageinfo.timestamp,
				data: {
					ignoreCharLimit: true
				},
				view: {
					icon: 'time',
					label: 'visualeditor-dialog-media-info-uploaded',
					isDate: true
				}
			},
			{
				name: 'DateTimeOriginal',
				value: ve.getProp( metadata, 'DateTimeOriginal', 'value' ),
				data: {},
				view: {
					icon: 'time',
					label: 'visualeditor-dialog-media-info-created'
				}
			},
			{
				name: 'moreinfo',
				value: ve.msg( 'visualeditor-dialog-media-info-moreinfo' ),
				data: {},
				view: {
					icon: 'info',
					href: imageinfo.descriptionurl
				}
			}
		],
		fields = {},
		// Store clean API data
		apiData = {},
		fileType = this.getFileType( imageinfo.url ),
		$thumbContainer = $( '<div>' )
			.addClass( 've-ui-mwMediaDialog-panel-imageinfo-thumb' ),
		$main = $( '<div>' )
			.addClass( 've-ui-mwMediaDialog-panel-imageinfo-main' ),
		$details = $( '<div>' )
			.addClass( 've-ui-mwMediaDialog-panel-imageinfo-details' ),
		$image = $( '<img>' );

	// Main section - title
	$main.append(
		imageTitle.$element
			.addClass( 've-ui-mwMediaDialog-panel-imageinfo-title' )
	);

	// Clean data from the API responses
	for ( i = 0; i < apiDataKeysConfig.length; i++ ) {
		field = apiDataKeysConfig[ i ].name;
		// Skip empty fields and those that are specifically configured to be skipped
		if ( apiDataKeysConfig[ i ].data.skipProcessing ) {
			apiData[ field ] = apiDataKeysConfig[ i ].value;
		} else {
			// Store a clean information from the API.
			if ( apiDataKeysConfig[ i ].value ) {
				apiData[ field ] = this.cleanAPIresponse( apiDataKeysConfig[ i ].value, apiDataKeysConfig[ i ].data );
			}
		}
	}

	// Add sizing info for non-audio images
	if ( imageinfo.mediatype === 'AUDIO' ) {
		// Label this file as an audio
		apiData.fileDetails =  $( '<span>' )
			.append( ve.msg( 'visualeditor-dialog-media-info-audiofile' ) );
	} else {
		// Build the display for image size and type
		apiData.fileDetails = $( '<div>' )
			.append(
				$( '<span>' ).text(
					imageinfo.width +
					'\u00a0' +
					ve.msg( 'visualeditor-dimensionswidget-times' ) +
					'\u00a0' +
					imageinfo.height +
					ve.msg( 'visualeditor-dimensionswidget-px' )
				),
				$( '<span>' )
					.addClass( 've-ui-mwMediaDialog-panel-imageinfo-separator' )
					.text( mw.msg( 'visualeditor-dialog-media-info-separator' ) ),
				$( '<span>' ).text( fileType )
			);
	}

	// Attach all fields in order
	for ( i = 0; i < apiDataKeysConfig.length; i++ ) {
		field = apiDataKeysConfig[ i ].name;
		if ( apiData[ field ] ) {
			$section = apiDataKeysConfig[ i ].view.primary ? $main : $details;

			fields[ field ] = new ve.ui.MWMediaInfoFieldWidget( apiData[ field ], apiDataKeysConfig[ i ].view );
			$section.append( fields[ field ].$element );
		}
	}

	// Build the info panel
	$info = $( '<div>' )
		.addClass( 've-ui-mwMediaDialog-panel-imageinfo-info' )
		.append(
			$main.prop( 'dir', contentDirection ),
			$details
		);

	// Make sure all links open in a new window
	$info.find( 'a' ).prop( 'target', '_blank' );

	// Initialize thumb container
	$thumbContainer
		.append( $image.prop( 'src', imageinfo.thumburl ) );

	this.$infoPanelWrapper.append(
		$thumbContainer,
		$info
	);

	// Force a scrollbar to the screen before we measure it
	this.mediaImageInfoPanel.$element.css( 'overflow-y', 'scroll' );
	windowWidth = this.mediaImageInfoPanel.$element.width();

	// Define thumbnail size
	if ( imageinfo.mediatype === 'AUDIO' ) {
		// HACK: We are getting the wrong information from the
		// API about audio files. Set their thumbnail to square
		newDimensions = {
			width: imageinfo.thumbwidth,
			height: imageinfo.thumbwidth
		};
	} else {
		// For regular images, calculate a bigger image dimensions
		newDimensions = ve.dm.MWImageNode.static.resizeToBoundingBox(
			// Original image dimensions
			{
				width: imageinfo.width,
				height: imageinfo.height
			},
			// Bounding box -- the size of the dialog, minus padding
			{
				width: windowWidth,
				height: this.getBodyHeight() - 120
			}
		);
	}
	// Resize the image
	$image.css( {
		width: newDimensions.width,
		height: newDimensions.height
	} );

	// Call for a bigger image
	this.fetchThumbnail( imageinfo.title, newDimensions )
		.done( function ( thumburl ) {
			if ( thumburl ) {
				$image.prop( 'src', thumburl );
			}
		} );

	isPortrait = newDimensions.width < ( windowWidth * 3 / 5 );
	this.mediaImageInfoPanel.$element.toggleClass( 've-ui-mwMediaDialog-panel-imageinfo-portrait', isPortrait );
	this.mediaImageInfoPanel.$element.append( this.$infoPanelWrapper );
	if ( isPortrait ) {
		$info.outerWidth( Math.floor( windowWidth - $thumbContainer.outerWidth( true ) - 15 ) );
	}

	// Initialize fields
	for ( field in fields ) {
		fields[ field ].initialize();
	}
	// Let the scrollbar appear naturally if it should
	this.mediaImageInfoPanel.$element.css( 'overflow', '' );
};

/**
 * Fetch a bigger image thumbnail from the API.
 *
 * @param {string} imageName Image source
 * @param {Object} dimensions Image dimensions
 * @return {jQuery.Promise} Thumbnail promise that resolves with new thumb url
 */
ve.ui.MWMediaDialog.prototype.fetchThumbnail = function ( imageName, dimensions ) {
	var dialog = this,
		apiObj = {
			action: 'query',
			prop: 'imageinfo',
			indexpageids: '1',
			iiprop: 'url',
			titles: imageName
		};

	// Check cache first
	if ( this.searchCache[ imageName ] ) {
		return $.Deferred().resolve( this.searchCache[ imageName ] );
	}

	if ( dimensions.width ) {
		apiObj.iiurlwidth = dimensions.width;
	}
	if ( dimensions.height ) {
		apiObj.iiurlheight = dimensions.height;
	}
	return new mw.Api().get( apiObj )
		.then( function ( response ) {
			var thumburl = ve.getProp(
				response.query.pages[ response.query.pageids[ 0 ] ],
				'imageinfo',
				0,
				'thumburl'
			);
			// Cache
			dialog.searchCache[ imageName ] = thumburl;
			return thumburl;
		} );
};

/**
 * Clean the API responses and return it in plaintext. If needed, truncate.
 *
 * @param {string} rawResponse Raw response from the API
 * @param {Object} config Configuration options
 * @return {string} Plaintext clean response
 */
ve.ui.MWMediaDialog.prototype.cleanAPIresponse = function ( rawResponse, config ) {
	var isTruncated, charLimit,
		html = $.parseHTML( rawResponse ),
		ellipsis = ve.msg( 'visualeditor-dialog-media-info-ellipsis' ),
		originalText = $( '<div>' ).append( html ).text();

	config = config || {};

	charLimit = config.charLimit || 50;
	isTruncated = originalText.length > charLimit;

	if ( config.keepOriginal ) {
		return html;
	}

	// Check if the string should be truncated
	return isTruncated && !config.ignoreCharLimit ?
		originalText.substring( 0, charLimit ) + ellipsis :
		originalText;
};

/**
 * Get the file type from the suffix of the url
 *
 * @param {string} url Full file url
 * @return {string} File type
 */
ve.ui.MWMediaDialog.prototype.getFileType = function ( url ) {
	// TODO: Validate these types, and work with icons
	// SVG, PNG, JPEG, GIF, TIFF, XCF;
	// OGA, OGG, MIDI, WAV;
	// WEBM, OGV, OGX;
	// APNG;
	// PDF, DJVU
	return url.split( '.' ).pop().toUpperCase();
};

/**
 * Get the proper icon for the license if it is recognized
 * or general info icon if it is not recognized.
 *
 * @param {string} license License short name
 * @return {string} Icon name
 */
ve.ui.MWMediaDialog.prototype.getLicenseIcon = function ( license ) {
	var normalized;

	if ( !license ) {
		return 'info';
	}

	normalized = license.toLowerCase().replace( /[-_]/g, ' ' );

	// FIXME: Structured data from Commons will make this properly
	// multilingual. For now, this is the limit of what is sensible.
	if ( normalized.match( /^((cc )?pd|public domain)/ ) ) {
		return 'public-domain';
	} else if ( normalized.match( /^cc (by|sa)?/ ) ) {
		return 'creative-commons';
	} else {
		return 'info';
	}
};

/**
 * Handle search results choose event.
 *
 * @param {ve.ui.MWMediaResultWidget} item Chosen item
 */
ve.ui.MWMediaDialog.prototype.onSearchResultsChoose = function ( item ) {
	var info = item.getData();
	this.$infoPanelWrapper.empty();
	// Switch panels
	this.selectedImageInfo = info;
	this.switchPanels( 'imageInfo' );
	// Build info panel
	this.buildMediaInfoPanel( info );
};

/**
 * Handle new image being chosen.
 *
 * @param {ve.ui.MWMediaResultWidget|null} item Selected item
 */
ve.ui.MWMediaDialog.prototype.confirmSelectedImage = function () {
	var title,
		obj = {},
		info = this.selectedImageInfo;

	if ( info ) {
		// Run title through mw.Title so the File: prefix is localised
		title = mw.Title.newFromText( info.title ).getPrefixedText();
		if ( !this.imageModel ) {
			// Create a new image model based on default attributes
			this.imageModel = ve.dm.MWImageModel.static.newFromImageAttributes(
				{
					// Per https://www.mediawiki.org/w/?diff=931265&oldid=prev
					href: './' + title,
					src: info.url,
					resource: './' + title,
					width: info.thumbwidth,
					height: info.thumbheight,
					mediaType: info.mediatype,
					type: 'thumb',
					align: 'default',
					defaultSize: true
				},
				this.getFragment().getDocument()
			);
			this.attachImageModel();
			this.resetCaption();
		} else {
			// Update the current image model with the new image source
			this.imageModel.changeImageSource(
				{
					mediaType: info.mediatype,
					href: './' + title,
					src: info.url,
					resource: './' + title
				},
				info
			);
			// Update filename
			this.filenameFieldset.setLabel(
				this.imageModel.getFilename()
			);
		}

		// Cache
		obj[ info.title ] = info;
		ve.init.platform.imageInfoCache.set( obj );

		this.checkChanged();
		this.switchPanels( 'edit' );
	}
};

/**
 * Handle image model alignment change
 *
 * @param {string} alignment Image alignment
 */
ve.ui.MWMediaDialog.prototype.onImageModelAlignmentChange = function ( alignment ) {
	alignment = alignment || 'none';

	// Select the item without triggering the 'choose' event
	this.positionSelect.selectItemByData( alignment !== 'none' ? alignment : undefined );

	this.positionCheckbox.setSelected( alignment !== 'none' );
	this.checkChanged();
};

/**
 * Handle image model type change
 *
 * @param {string} type Image type
 */
ve.ui.MWMediaDialog.prototype.onImageModelTypeChange = function ( type ) {
	this.typeSelect.selectItemByData( type );

	this.borderCheckbox.setDisabled(
		!this.imageModel.isBorderable()
	);

	this.borderCheckbox.setSelected(
		this.imageModel.isBorderable() && this.imageModel.hasBorder()
	);
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
 * Handle change event on the positionCheckbox element.
 *
 * @param {boolean} isSelected Checkbox status
 */
ve.ui.MWMediaDialog.prototype.onBorderCheckboxChange = function ( isSelected ) {
	// Only update if the value is different than the model
	if ( this.imageModel.hasBorder() !== isSelected ) {
		// Update the image model
		this.imageModel.toggleBorder( isSelected );
		this.checkChanged();
	}
};

/**
 * Handle change event on the positionSelect element.
 *
 * @param {OO.ui.ButtonOptionWidget} item Selected item
 */
ve.ui.MWMediaDialog.prototype.onPositionSelectChoose = function ( item ) {
	var position = item.getData();

	// Only update if the value is different than the model
	if ( this.imageModel.getAlignment() !== position ) {
		this.imageModel.setAlignment( position );
		this.checkChanged();
	}
};

/**
 * Handle change event on the typeSelect element.
 *
 * @param {OO.ui.ButtonOptionWidget} item Selected item
 */
ve.ui.MWMediaDialog.prototype.onTypeSelectChoose = function ( item ) {
	var type = item.getData();

	// Only update if the value is different than the model
	if ( this.imageModel.getType() !== type ) {
		this.imageModel.setType( type );
		this.checkChanged();
	}

	// If type is 'frame', disable the size input widget completely
	this.sizeWidget.setDisabled( type === 'frame' );
};

/**
 * Respond to change in alternate text
 *
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
		if ( this.captionTarget && this.captionTarget.getSurface() ) {
			captionChanged = this.captionTarget.getSurface().getModel().hasBeenModified();
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
 * @inheritdoc
 */
ve.ui.MWMediaDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.MWMediaDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			var pageTitle = mw.config.get( 'wgTitle' ),
				namespace = mw.config.get( 'wgNamespaceNumber' ),
				namespacesWithSubpages = mw.config.get( 'wgVisualEditorConfig' ).namespacesWithSubpages;

			// Read the page title
			if ( namespacesWithSubpages[ namespace ] ) {
				// If we are in a namespace that allows for subpages, strip the entire
				// title except for the part after the last /
				pageTitle = pageTitle.slice( pageTitle.lastIndexOf( '/' ) + 1 );
			}
			this.pageTitle = pageTitle;

			// Set language for search results
			this.search.setLang( this.getFragment().getDocument().getLang() );

			if ( this.selectedNode ) {
				this.isInsertion = false;
				// Create image model
				this.imageModel = ve.dm.MWImageModel.static.newFromImageNode( this.selectedNode );
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

			this.search.setup();

			this.resetCaption();

			this.actions.setAbilities( { insert: false, apply: false } );

			this.switchPanels( this.selectedNode ? 'edit' : 'search' );
		}, this );
};

/**
 * Switch between the edit and insert/search panels
 *
 * @param {string} panel Panel name
 * @param {boolean} [stopSearchRequery] Do not re-query the API for the search panel
 */
ve.ui.MWMediaDialog.prototype.switchPanels = function ( panel, stopSearchRequery ) {
	var dialog = this;
	switch ( panel ) {
		case 'edit':
			this.setSize( 'large' );
			// Set the edit panel
			this.panels.setItem( this.bookletLayout );
			// Focus the general settings page
			this.bookletLayout.setPage( 'general' );
			// Hide/show buttons
			this.actions.setMode( this.selectedNode ? 'edit' : 'insert' );
			// Focus the caption surface
			this.captionTarget.focus();
			break;
		case 'search':
			this.setSize( 'larger' );
			this.selectedImageInfo = null;
			if ( !stopSearchRequery ) {
				this.search.getQuery().setValue( dialog.pageTitle );
				this.search.getQuery().focus().select();
			}
			// Set the edit panel
			this.panels.setItem( this.mediaSearchPanel );
			this.actions.setMode( this.imageModel ? 'change' : 'select' );
			// Layout pending items
			this.search.runLayoutQueue();
			break;
		default:
		case 'imageInfo':
			this.setSize( 'larger' );
			// Hide/show buttons
			this.actions.setMode( 'info' );
			// Hide/show the panels
			this.panels.setItem( this.mediaImageInfoPanel );
			break;
	}
	this.currentPanel = panel || 'imageinfo';
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
		typeChange: 'onImageModelTypeChange',
		sizeDefaultChange: 'checkChanged'
	} );

	// Set up
	// Ignore the following changes in validation while we are
	// setting up the initial tools according to the model state
	this.isSettingUpModel = true;

	// Filename
	this.filenameFieldset.setLabel(
		this.imageModel.getFilename()
	);

	// Size widget
	this.sizeErrorLabel.toggle( false );
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

	// Set initial alt text
	this.altTextInput.setValue( this.imageModel.getAltText() );

	// Set initial alignment
	this.positionSelect.setDisabled( !this.imageModel.isAligned() );
	this.positionSelect.selectItemByData( this.imageModel.isAligned() && this.imageModel.getAlignment() );
	this.positionCheckbox.setSelected( this.imageModel.isAligned() );

	// Border flag
	this.borderCheckbox.setDisabled( !this.imageModel.isBorderable() );
	this.borderCheckbox.setSelected( this.imageModel.isBorderable() && this.imageModel.hasBorder() );

	// Type select
	this.typeSelect.selectItemByData( this.imageModel.getType() || 'none' );

	this.isSettingUpModel = false;
};

/**
 * Reset the caption surface
 */
ve.ui.MWMediaDialog.prototype.resetCaption = function () {
	var captionDocument,
		doc = this.getFragment().getDocument();

	if ( this.captionTarget ) {
		// Reset the caption surface if it already exists
		this.captionTarget.destroy();
		this.captionTarget = null;
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

	// Set up the caption target
	this.captionTarget = new ve.ui.MWTargetWidget(
		captionDocument,
		{
			tools: ve.init.target.constructor.static.toolbarGroups,
			includeCommands: this.constructor.static.includeCommands,
			excludeCommands: this.constructor.static.excludeCommands,
			importRules: this.constructor.static.getImportRules()
		}
	);

	// Initialization
	this.captionFieldset.$element.append( this.captionTarget.$element );
	this.captionTarget.initialize();

	// Events
	this.captionTarget.getSurface().getModel().connect( this, {
		history: this.checkChanged.bind( this )
	} );
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaDialog.prototype.getReadyProcess = function ( data ) {
	return ve.ui.MWMediaDialog.super.prototype.getReadyProcess.call( this, data )
		.next( function () {
			if ( this.currentPanel === 'search' ) {
				// Focus the search input
				this.search.getQuery().focus().select();
			} else {
				// Focus the caption surface
				this.captionTarget.focus();
			}
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
			this.search.teardown();
			if ( this.imageModel ) {
				this.imageModel.disconnect( this );
				this.sizeWidget.disconnect( this );
				this.captionTarget.getSurface().getModel().disconnect( this );
			}
			this.captionTarget.destroy();
			this.captionTarget = null;
			this.captionNode = null;
			this.imageModel = null;
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWMediaDialog.prototype.getActionProcess = function ( action ) {
	var handler;

	switch ( action ) {
		case 'change':
			handler = function () {
				this.switchPanels( 'search' );
			};
			break;
		case 'back':
			handler = function () {
				this.switchPanels( 'edit' );
			};
			break;
		case 'choose':
			handler = function () {
				this.confirmSelectedImage();
				this.switchPanels( 'edit' );
			};
			break;
		case 'cancelchoose':
			handler = function () {
				this.switchPanels( 'search', true );
			};
			break;
		case 'apply':
		case 'insert':
			handler = function () {
				var surfaceModel = this.getFragment().getSurface();

				// Update from the form
				this.imageModel.setAltText( this.altTextInput.getValue() );
				this.imageModel.setCaptionDocument(
					this.captionTarget.getSurface().getModel().getDocument()
				);

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

				this.close( { action: action } );
			};
			break;
		default:
			return ve.ui.MWMediaDialog.super.prototype.getActionProcess.call( this, action );
	}

	return new OO.ui.Process( handler, this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWMediaDialog );
