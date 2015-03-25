/*!
 * VisualEditor UserInterface MWLinkNodeInspector class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Inspector for editing unlabeled MediaWiki external links.
 *
 * @class
 * @extends ve.ui.NodeInspector
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWLinkNodeInspector = function VeUiMWLinkNodeInspector( config ) {
	// Parent constructor
	ve.ui.NodeInspector.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWLinkNodeInspector, ve.ui.NodeInspector );

/* Static properties */

ve.ui.MWLinkNodeInspector.static.name = 'linkNode';

ve.ui.MWLinkNodeInspector.static.icon = 'link';

ve.ui.MWLinkNodeInspector.static.title = OO.ui.deferMsg( 'visualeditor-linknodeinspector-title' );

ve.ui.MWLinkNodeInspector.static.removable = false;

ve.ui.MWLinkNodeInspector.static.modelClasses = [ ve.dm.MWNumberedExternalLinkNode ];

ve.ui.MWLinkNodeInspector.static.actions = ve.ui.MWLinkNodeInspector.super.static.actions.concat( [
	{
		action: 'open',
		label: OO.ui.deferMsg( 'visualeditor-linkinspector-open' )
	},
	{
		action: 'convert',
		label: OO.ui.deferMsg( 'visualeditor-linknodeinspector-add-label' )
	}
] );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWLinkNodeInspector.prototype.initialize = function () {
	// Parent method
	ve.ui.MWLinkNodeInspector.super.prototype.initialize.call( this );

	// Properties
	this.targetInput = new OO.ui.TextInputWidget( {
		$: this.$,
		validate: ve.init.platform.getExternalLinkUrlProtocolsRegExp()
	} );

	// Events
	this.targetInput.connect( this, { change: 'onTargetInputChange' } );

	// Initialization
	this.form.$element.append( this.targetInput.$element );
};

/**
 * Handle target input change events.
 *
 * Updates the open button's hyperlink location.
 *
 * @param {string} value New target input value
 */
ve.ui.MWLinkNodeInspector.prototype.onTargetInputChange = function () {
	var href = this.targetInput.getValue(),
		inspector = this;
	this.targetInput.isValid().done( function ( valid ) {
		inspector.actions.forEach( { actions: 'open' }, function ( action ) {
			action.setHref( href ).setTarget( '_blank' ).setDisabled( !valid );
			// HACK: Chrome renders a dark outline around the action when it's a link, but causing it to
			// re-render makes it magically go away; this is incredibly evil and needs further
			// investigation
			action.$element.hide().fadeIn( 0 );
		} );
	} );
};

/**
 * @inheritdoc
 */
ve.ui.MWLinkNodeInspector.prototype.getActionProcess = function ( action ) {
	if ( action === 'convert' ) {
		return new OO.ui.Process( function () {
			this.close( { action: action } );
		}, this );
	}
	return ve.ui.MWLinkNodeInspector.super.prototype.getActionProcess.call( this, action );
};

/**
 * @inheritdoc
 */
ve.ui.MWLinkNodeInspector.prototype.getSetupProcess = function ( data ) {
	return ve.ui.MWLinkNodeInspector.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			// Initialization
			this.targetInput.setValue(
				this.selectedNode ? this.selectedNode.getAttribute( 'href' ) : ''
			);
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
	data = data || {};
	return ve.ui.MWLinkNodeInspector.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			var content, annotation, annotations,
				surfaceModel = this.getFragment().getSurface(),
				doc = surfaceModel.getDocument(),
				nodeRange = this.selectedNode.getOuterRange(),
				value = this.targetInput.getValue(),
				convert = data.action === 'convert',
				remove = data.action === 'remove' || !value;

			// Default to http:// if the external link doesn't already begin with a supported
			// protocol - this prevents the link from being converted into literal text upon
			// save and also fixes a common mistake users may make
			if ( !ve.init.platform.getExternalLinkUrlProtocolsRegExp().test( value ) ) {
				value = 'http://' + value;
			}

			if ( remove ) {
				surfaceModel.change(
					ve.dm.Transaction.newFromRemoval( doc, nodeRange )
				);
			} else if ( convert ) {
				annotation = new ve.dm.MWExternalLinkAnnotation( {
					type: 'link/mwExternal',
					attributes: {
						href: value
					}
				} );
				annotations = doc.data.getAnnotationsFromOffset( nodeRange.start ).clone();
				annotations.push( annotation );
				content = value.split( '' );
				ve.dm.Document.static.addAnnotationsToData( content, annotations );
				surfaceModel.change(
					ve.dm.Transaction.newFromReplacement( doc, nodeRange, content )
				);
			} else {
				surfaceModel.change(
					ve.dm.Transaction.newFromAttributeChanges(
						doc, nodeRange.start, { href: value }
					)
				);
			}
		}, this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWLinkNodeInspector );
