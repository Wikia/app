/*!
 * VisualEditor UserInterface MWExtensionInspector class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki extension inspector.
 *
 * @class
 * @abstract
 * @extends ve.ui.Inspector
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWExtensionInspector = function VeUiMWExtensionInspector( config ) {
	// Parent constructor
	ve.ui.Inspector.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWExtensionInspector, ve.ui.Inspector );

/* Static properties */

ve.ui.MWExtensionInspector.static.placeholder = null;

ve.ui.MWExtensionInspector.static.nodeModel = null;

ve.ui.MWExtensionInspector.static.removable = false;

/**
 * Extension is allowed to have empty contents
 *
 * @static
 * @property {boolean}
 * @inheritable
 */
ve.ui.MWExtensionInspector.static.allowedEmpty = false;

/**
 * Inspector's directionality, 'ltr' or 'rtl'
 *
 * Leave as null to use the directionality of the current fragment.
 *
 * @static
 * @property {string|null}
 * @inheritable
 */
ve.ui.MWExtensionInspector.static.dir = null;

/* Methods */

/**
 * Handle frame ready events.
 *
 * @method
 */
ve.ui.MWExtensionInspector.prototype.initialize = function () {
	// Parent method
	ve.ui.MWExtensionInspector.super.prototype.initialize.call( this );

	this.input = new OO.ui.TextInputWidget( {
		'$': this.$,
		'multiline': true
	} );
	this.input.$element.addClass( 've-ui-mwExtensionInspector-input' );

	this.isBlock = !this.constructor.static.nodeModel.static.isContent;

	// Initialization
	this.$form.append( this.input.$element );
};

/**
 * Get the placeholder text for the content input area.
 *
 * @returns {string} Placeholder text
 */
ve.ui.MWExtensionInspector.prototype.getInputPlaceholder = function () {
	return '';
};

/**
 * @inheritdoc
 */
ve.ui.MWExtensionInspector.prototype.getSetupProcess = function ( data ) {
	return ve.ui.MWExtensionInspector.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			var value, dir;

			// Initialization
			this.node = this.getFragment().getSelectedNode();
			this.whitespace = [ '', '' ];

			// Make sure we're inspecting the right type of node
			if ( !( this.node instanceof this.constructor.static.nodeModel ) ) {
				this.node = null;
			}
			if ( this.node ) {
				value = this.node.getAttribute( 'mw' ).body.extsrc;
				if ( this.isBlock ) {
					// Trim leading/trailing linebreaks but remember them
					if ( value.slice( 0, 1 ) === '\n' ) {
						this.whitespace[0] = '\n';
						value = value.slice( 1 );
					}
					if ( value.slice( -1 ) === '\n' ) {
						this.whitespace[1] = '\n';
						value = value.slice( 0, -1 );
					}
				}
				this.input.setValue( value );
			} else {
				if ( this.isBlock ) {
					// New nodes should use linebreaks for blocks
					this.whitespace = [ '\n', '\n' ];
				}
				this.input.setValue( '' );
			}

			this.input.$input.attr( 'placeholder', this.getInputPlaceholder() );

			dir = this.constructor.static.dir || data.dir;
			this.input.setRTL( dir === 'rtl' );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWExtensionInspector.prototype.getReadyProcess = function ( data ) {
	return ve.ui.MWExtensionInspector.super.prototype.getReadyProcess.call( this, data )
		.next( function () {
			// Focus the input
			this.input.focus();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWExtensionInspector.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.MWExtensionInspector.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			var mwData,
				surfaceModel = this.getFragment().getSurface();

			if ( this.constructor.static.allowedEmpty || this.input.getValue() !== '' ) {
				if ( this.node ) {
					mwData = ve.copy( this.node.getAttribute( 'mw' ) );
					this.updateMwData( mwData );
					surfaceModel.change(
						ve.dm.Transaction.newFromAttributeChanges(
							surfaceModel.getDocument(),
							this.node.getOuterRange().start,
							{ 'mw': mwData }
						)
					);
				} else {
					mwData = {
						'name': this.constructor.static.nodeModel.static.extensionName,
						'attrs': {},
						'body': {}
					};
					this.updateMwData( mwData );
					// Collapse returns a new fragment, so update this.fragment
					this.fragment = this.getFragment().collapseRangeToEnd();
					this.getFragment().insertContent( [
						{
							'type': this.constructor.static.nodeModel.static.name,
							'attributes': {
								'mw': mwData
							}
						},
						{ 'type': '/' + this.constructor.static.nodeModel.static.name }
					] );
				}
			} else if ( this.node && !this.constructor.static.allowedEmpty ) {
				// Content has been emptied on a node which isn't allowed to
				// be empty, so delete it.
				this.getFragment().removeContent();
			}
		}, this );
};

/**
 * Update mwData object with the new values from the inspector
 *
 * @param {Object} mwData MediaWiki data object
 */
ve.ui.MWExtensionInspector.prototype.updateMwData = function ( mwData ) {
	mwData.body.extsrc = this.whitespace[0] + this.input.getValue() + this.whitespace[1];
};
