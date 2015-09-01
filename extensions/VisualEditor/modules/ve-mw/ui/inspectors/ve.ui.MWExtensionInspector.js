/*!
 * VisualEditor UserInterface MWExtensionInspector class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Inspector for editing generic MediaWiki extensions.
 *
 * @class
 * @abstract
 * @extends ve.ui.NodeInspector
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWExtensionInspector = function VeUiMWExtensionInspector() {
	// Parent constructor
	ve.ui.MWExtensionInspector.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWExtensionInspector, ve.ui.NodeInspector );

/* Static properties */

ve.ui.MWExtensionInspector.static.placeholder = null;

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

	this.input = new ve.ui.WhitespacePreservingTextInputWidget( {
		limit: 1,
		multiline: true
	} );
	this.input.$element.addClass( 've-ui-mwExtensionInspector-input' );

	// Initialization
	this.form.$element.append( this.input.$element );
};

/**
 * Get the placeholder text for the content input area.
 *
 * @return {string} Placeholder text
 */
ve.ui.MWExtensionInspector.prototype.getInputPlaceholder = function () {
	return '';
};

/**
 * @inheritdoc
 */
ve.ui.MWExtensionInspector.prototype.getSetupProcess = function ( data ) {
	data = data || {};
	return ve.ui.MWExtensionInspector.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			var dir;

			// Initialization
			this.whitespace = [ '', '' ];

			if ( this.selectedNode ) {
				this.input.setValueAndWhitespace( this.selectedNode.getAttribute( 'mw' ).body.extsrc );
			} else {
				if ( !this.constructor.static.modelClasses[ 0 ].static.isContent ) {
					// New nodes should use linebreaks for blocks
					this.input.setWhitespace( [ '\n', '\n' ] );
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
			if ( this.constructor.static.allowedEmpty || this.input.getInnerValue() !== '' ) {
				this.insertOrUpdateNode();
			} else if ( this.selectedNode && !this.constructor.static.allowedEmpty ) {
				// Content has been emptied on a node which isn't allowed to
				// be empty, so delete it.
				this.removeNode();
			}
		}, this );
};

/**
 * Create an new data element for the model class associated with this inspector
 *
 * @return {Object} Element data
 */
ve.ui.MWExtensionInspector.prototype.getNewElement = function () {
	// Extension inspectors which create elements should either match
	// a single modelClass or override this method.
	var modelClass = this.constructor.static.modelClasses[ 0 ];
	return {
		type: modelClass.static.name,
		attributes: {
			mw: {
				name: modelClass.static.extensionName,
				attrs: {},
				body: {
					extsrc: ''
				}
			}
		}
	};
};

/**
 * Insert or update the node in the document model from the new values
 */
ve.ui.MWExtensionInspector.prototype.insertOrUpdateNode = function () {
	var mwData, element,
		surfaceModel = this.getFragment().getSurface();
	if ( this.selectedNode ) {
		mwData = ve.copy( this.selectedNode.getAttribute( 'mw' ) );
		this.updateMwData( mwData );
		surfaceModel.change(
			ve.dm.Transaction.newFromAttributeChanges(
				surfaceModel.getDocument(),
				this.selectedNode.getOuterRange().start,
				{ mw: mwData }
			)
		);
	} else {
		element = this.getNewElement();
		this.updateMwData( element.attributes.mw );
		// Collapse returns a new fragment, so update this.fragment
		this.fragment = this.getFragment().collapseToEnd();
		this.getFragment().insertContent( [
			element,
			{ type: '/' + element.type }
		] );
	}
};

/**
 * Remove the node form the document model
 */
ve.ui.MWExtensionInspector.prototype.removeNode = function () {
	this.getFragment().removeContent();
};

/**
 * Update mwData object with the new values from the inspector
 *
 * @param {Object} mwData MediaWiki data object
 */
ve.ui.MWExtensionInspector.prototype.updateMwData = function ( mwData ) {
	var tagName = mwData.name,
		value = this.input.getValue();

	// XML-like tags in wikitext are not actually XML and don't expect their contents to be escaped.
	// This means that it is not possible for a tag '<foo>…</foo>' to contain the string '</foo>'.
	// Prevent that by escaping the first angle bracket '<' to '&lt;'. (bug 57429)
	value = value.replace( new RegExp( '<(/' + tagName + '\\s*>)', 'gi' ), '&lt;$1' );

	mwData.body.extsrc = this.whitespace[ 0 ] + value + this.whitespace[ 1 ];
};
