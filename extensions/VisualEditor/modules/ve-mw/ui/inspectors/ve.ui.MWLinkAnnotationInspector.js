/*!
 * VisualEditor UserInterface LinkAnnotationInspector class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Inspector for applying and editing labeled MediaWiki internal and external links.
 *
 * @class
 * @extends ve.ui.LinkAnnotationInspector
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWLinkAnnotationInspector = function VeUiMWLinkAnnotationInspector( config ) {
	// Parent constructor
	ve.ui.MWLinkAnnotationInspector.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWLinkAnnotationInspector, ve.ui.LinkAnnotationInspector );

/* Static properties */

ve.ui.MWLinkAnnotationInspector.static.name = 'link';

ve.ui.MWLinkAnnotationInspector.static.modelClasses = [
	ve.dm.MWExternalLinkAnnotation,
	ve.dm.MWInternalLinkAnnotation
];

ve.ui.MWLinkAnnotationInspector.static.actions = ve.ui.MWLinkAnnotationInspector.static.actions.concat( [
	{
		action: 'convert',
		label: null, // see #updateActions
		modes: [ 'edit', 'insert' ]
	}
] );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWLinkAnnotationInspector.prototype.initialize = function () {
	var overlay = this.manager.getOverlay();

	// Properties
	this.allowProtocolInInternal = false;
	this.internalAnnotationInput = new ve.ui.MWInternalLinkAnnotationWidget( {
		// Sub-classes may want to know where to position overlays
		$overlay: overlay ? overlay.$element : this.$frame
	} );
	this.externalAnnotationInput = new ve.ui.MWExternalLinkAnnotationWidget();

	this.linkTypeSelect = new OO.ui.TabSelectWidget( {
		classes: [ 've-ui-mwLinkAnnotationInspector-linkTypeSelect' ],
		items: [
			new OO.ui.TabOptionWidget( {
				data: 'internal',
				classes: [ 've-test-internal-link-tab' ],
				label: ve.msg( 'visualeditor-linkinspector-button-link-internal' )
			} ),
			new OO.ui.TabOptionWidget( {
				data: 'external',
				classes: [ 've-test-external-link-tab' ],
				label: ve.msg( 'visualeditor-linkinspector-button-link-external' )
			} )
		]
	} );

	// Events
	this.linkTypeSelect.connect( this, { select: 'onLinkTypeSelectSelect' } );
	this.internalAnnotationInput.connect( this, { change: 'onInternalLinkChange' } );
	this.externalAnnotationInput.connect( this, { change: 'onExternalLinkChange' } );

	// Parent method
	ve.ui.MWLinkAnnotationInspector.super.prototype.initialize.call( this );

	// Initialization
	this.form.$element.prepend( this.linkTypeSelect.$element );
};

/**
 * Check if the current input mode is for external links
 *
 * @return {boolean} Input mode is for external links
 */
ve.ui.MWLinkAnnotationInspector.prototype.isExternal = function () {
	var item = this.linkTypeSelect.getSelectedItem();
	return item && item.getData() === 'external';
};

/**
 * Handle change events on the internal link widget
 *
 * @param {ve.dm.MWInternalLinkAnnotation} annotation Annotation
 */
ve.ui.MWLinkAnnotationInspector.prototype.onInternalLinkChange = function ( annotation ) {
	var targetData,
		href = annotation ? annotation.getAttribute( 'title' ) : '',
		// Have to check that this.getFragment() is defined because parent class's teardown
		// invokes setAnnotation( null ) which calls this code after fragment is unset
		htmlDoc = this.getFragment() && this.getFragment().getDocument().getHtmlDocument();

	if ( htmlDoc && ve.init.platform.getExternalLinkUrlProtocolsRegExp().test( href ) ) {
		// Check if the 'external' link is in fact a page on the same wiki
		// e.g. http://en.wikipedia.org/wiki/Target -> Target
		targetData = ve.dm.MWInternalLinkAnnotation.static.getTargetDataFromHref(
			href,
			htmlDoc
		);
		if ( targetData.isInternal ) {
			this.internalAnnotationInput.text.setValue( targetData.title );
			return;
		}
	}

	if (
		!this.allowProtocolInInternal &&
		ve.init.platform.getExternalLinkUrlProtocolsRegExp().test( href )
	) {
		this.linkTypeSelect.selectItemByData( 'external' );
	}
	this.updateActions();
};

/**
 * Handle change events on the external link widget
 *
 * @param {ve.dm.MWExternalLinkAnnotation} annotation Annotation
 */
ve.ui.MWLinkAnnotationInspector.prototype.onExternalLinkChange = function () {
	this.updateActions();
};

/**
 * @inheritdoc
 */
ve.ui.MWLinkAnnotationInspector.prototype.updateActions = function () {
	var content, annotation, href, type,
		msg = null;

	ve.ui.MWLinkAnnotationInspector.super.prototype.updateActions.call( this );

	// show/hide convert action
	content = this.fragment ? this.fragment.getText() : '';
	annotation = this.annotationInput.getAnnotation();
	href = annotation && annotation.getHref();
	if ( href && ve.dm.MWMagicLinkNode.static.validateHref( content, href ) ) {
		type = ve.dm.MWMagicLinkType.static.fromContent( content ).type;
		msg = 'visualeditor-linkinspector-convert-link-' + type.toLowerCase();
	}

	// Once we toggle the visibility of the ActionWidget, we can't filter
	// it with `get` any more.  So we have to use `forEach`:
	this.actions.forEach( null, function ( action ) {
		if ( action.getAction() === 'convert' ) {
			if ( msg ) {
				action.setLabel( OO.ui.deferMsg( msg ) );
				action.toggle( true );
			} else {
				action.toggle( false );
			}
		}
	} );
};

/**
 * @inheritdoc
 */
ve.ui.MWLinkAnnotationInspector.prototype.createAnnotationInput = function () {
	return this.isExternal() ? this.externalAnnotationInput : this.internalAnnotationInput;
};

/**
 * @inheritdoc
 */
ve.ui.MWLinkAnnotationInspector.prototype.getSetupProcess = function ( data ) {
	return ve.ui.MWLinkAnnotationInspector.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.linkTypeSelect.selectItemByData(
				this.initialAnnotation instanceof ve.dm.MWExternalLinkAnnotation ? 'external' : 'internal'
			);
			this.annotationInput.setAnnotation( this.initialAnnotation );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWLinkAnnotationInspector.prototype.getReadyProcess = function ( data ) {
	return ve.ui.MWLinkAnnotationInspector.super.prototype.getReadyProcess.call( this, data )
		.next( function () {
			this.internalAnnotationInput.text.populateLookupMenu();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWLinkAnnotationInspector.prototype.getActionProcess = function ( action ) {
	if ( action === 'convert' ) {
		return new OO.ui.Process( function () {
			this.close( { action: 'done', convert: true } );
		}, this );
	}
	return ve.ui.MWLinkAnnotationInspector.super.prototype.getActionProcess.call( this, action );
};

/**
 * @inheritdoc
 */
ve.ui.MWLinkAnnotationInspector.prototype.getTeardownProcess = function ( data ) {
	var fragment;
	return ve.ui.MWLinkAnnotationInspector.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			// Save the original fragment for later.
			fragment = this.getFragment();
		}, this )
		.next( function () {
			var selection = fragment && fragment.getSelection();

			// Handle conversion to magic link.
			if ( data.convert && selection instanceof ve.dm.LinearSelection ) {
				fragment.insertContent( [
					{
						type: 'link/mwMagic',
						attributes: {
							content: fragment.getText()
						}
					},
					{
						type: '/link/mwMagic'
					}
				], true );
			}

			// Clear dialog state.
			this.allowProtocolInInternal = false;
			// Make sure both inputs are cleared
			this.internalAnnotationInput.setAnnotation( null );
			this.externalAnnotationInput.setAnnotation( null );
		}, this );
};

/**
 * Handle select events from the linkTypeSelect widget
 *
 * @param {OO.ui.MenuOptionWidget} item Selected item
 */
ve.ui.MWLinkAnnotationInspector.prototype.onLinkTypeSelectSelect = function () {
	var text = this.annotationInput.text.getValue(),
		end = text.length,
		isExternal = this.isExternal(),
		inputHasProtocol = ve.init.platform.getExternalLinkUrlProtocolsRegExp().test( text );

	this.annotationInput.$element.detach();

	this.annotationInput = this.createAnnotationInput();
	this.form.$element.append( this.annotationInput.$element );

	// If the user manually switches to internal links with an external link in the input, remember this
	if ( !isExternal && inputHasProtocol ) {
		this.allowProtocolInInternal = true;
	}

	this.annotationInput.text.setValue( text ).focus();
	// Firefox moves the cursor to the beginning
	this.annotationInput.text.$input[ 0 ].setSelectionRange( end, end );

	if ( !isExternal ) {
		this.annotationInput.text.populateLookupMenu();
	}
};

/**
 * Gets an annotation object from a fragment.
 *
 * The type of link is automatically detected based on some crude heuristics.
 *
 * @method
 * @param {ve.dm.SurfaceFragment} fragment Current selection
 * @return {ve.dm.MWInternalLinkAnnotation|ve.dm.MWExternalLinkAnnotation|null}
 */
ve.ui.MWLinkAnnotationInspector.prototype.getAnnotationFromFragment = function ( fragment ) {
	var target = fragment.getText(),
		title = mw.Title.newFromText( target );

	// Figure out if this is an internal or external link
	if ( ve.init.platform.getExternalLinkUrlProtocolsRegExp().test( target ) ) {
		// External link
		return new ve.dm.MWExternalLinkAnnotation( {
			type: 'link/mwExternal',
			attributes: {
				href: target
			}
		} );
	} else if ( title ) {
		// Internal link
		return ve.dm.MWInternalLinkAnnotation.static.newFromTitle( title );
	} else {
		// Doesn't look like an external link and mw.Title considered it an illegal value,
		// for an internal link.
		return null;
	}
};

/**
 * @inheritdoc
 */
ve.ui.MWLinkAnnotationInspector.prototype.getInsertionData = function () {
	// If this is a new external link, insert an autonumbered link instead of a link annotation (in
	// #getAnnotation we have the same condition to skip the annotating). Otherwise call parent method
	// to figure out the text to insert and annotate.
	if ( this.isExternal() ) {
		return [
			{
				type: 'link/mwNumberedExternal',
				attributes: {
					href: this.annotationInput.getHref()
				}
			},
			{ type: '/link/mwNumberedExternal' }
		];
	} else {
		return ve.ui.MWLinkAnnotationInspector.super.prototype.getInsertionData.call( this );
	}
};

/**
 * ve.ui.MWInternalLinkAnnotationWidget.prototype.getHref will try to return an href, obviously,
 * but we don't want this to go into the text and can just call its parent instead.
 */
ve.ui.MWLinkAnnotationInspector.prototype.getInsertionText = function () {
	return this.annotationInput.constructor.super.prototype.getHref.call( this.annotationInput );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWLinkAnnotationInspector );
