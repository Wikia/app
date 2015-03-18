/*!
 * VisualEditor UserInterface MWLinkNodeInspector class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Link inspector.
 *
 * @class
 * @extends ve.ui.Inspector
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWLinkNodeInspector = function VeUiMWLinkNodeInspector( config ) {
	// Parent constructor
	ve.ui.Inspector.call( this, config );

	// Properties
	this.linkNode = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.MWLinkNodeInspector, ve.ui.Inspector );

/* Static properties */

ve.ui.MWLinkNodeInspector.static.name = 'linkNode';

ve.ui.MWLinkNodeInspector.static.icon = 'link';

ve.ui.MWLinkNodeInspector.static.title = OO.ui.deferMsg( 'visualeditor-linknodeinspector-title' );

ve.ui.MWLinkNodeInspector.static.removable = false;

ve.ui.MWLinkNodeInspector.static.modelClasses = [ ve.dm.MWNumberedExternalLinkNode ];

/* Methods */

/**
 * Handle convert button click events.
 */
ve.ui.MWLinkNodeInspector.prototype.onConvertButtonClick = function () {
	this.close( { 'action': 'convert' } );
};

/**
 * @inheritdoc
 */
ve.ui.MWLinkNodeInspector.prototype.initialize = function () {
	// Parent method
	ve.ui.MWLinkNodeInspector.super.prototype.initialize.call( this );

	// Properties
	this.targetInput = new OO.ui.TextInputWidget( { '$': this.$ } );
	this.convertButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'frameless': true,
		'icon': 'add-item',
		'label': ve.msg( 'visualeditor-linknodeinspector-add-label' )
	} );

	// Events
	this.convertButton.connect( this, { 'click': 'onConvertButtonClick' } );

	// Initialization
	this.$form.append( this.targetInput.$element, this.convertButton.$element );
};

/**
 * @inheritdoc
 */
ve.ui.MWLinkNodeInspector.prototype.getSetupProcess = function ( data ) {
	return ve.ui.MWLinkNodeInspector.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			// Properties
			this.linkNode = this.getFragment().getSelectedNode();

			// Initialization
			this.targetInput.setValue( this.linkNode ? this.linkNode.getAttribute( 'href' ) : '' );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWLinkNodeInspector.prototype.getReadyProcess = function ( data ) {
	return ve.ui.MWLinkNodeInspector.super.prototype.getReadyProcess.call( this, data )
		.next( function () {
			this.targetInput.focus().select();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWLinkNodeInspector.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.MWLinkNodeInspector.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			var content, annotation, annotations,
				surfaceModel = this.getFragment().getSurface(),
				doc = surfaceModel.getDocument(),
				nodeRange = this.linkNode.getOuterRange(),
				value = this.targetInput.getValue(),
				convert = data.action === 'convert',
				remove = convert || data.action === 'remove' || !value;

			if ( remove ) {
				surfaceModel.change(
					ve.dm.Transaction.newFromRemoval( doc, nodeRange )
				);
			} else {
				// Default to http:// if the external link doesn't already begin with a supported
				// protocol - this prevents the link from being converted into literal text upon
				// save and also fixes a common mistake users may make
				if ( !ve.init.platform.getExternalLinkUrlProtocolsRegExp().test( value ) ) {
					value = 'http://' + value;
				}
				surfaceModel.change(
					ve.dm.Transaction.newFromAttributeChanges(
						doc, nodeRange.start, { 'href': value }
					)
				);
			}
			if ( convert ) {
				annotation = new ve.dm.MWExternalLinkAnnotation( {
					'type': 'link/mwExternal',
					'attributes': {
						'href': value
					}
				} );
				annotations = doc.data.getAnnotationsFromOffset(
					this.linkNode.getOffset()
				).clone();
				annotations.push( annotation );
				content = ve.splitClusters( value );
				ve.dm.Document.static.addAnnotationsToData( content, annotations );
				surfaceModel.change(
					ve.dm.Transaction.newFromInsertion( doc, nodeRange.start, content )
				);
			}
		}, this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWLinkNodeInspector );
