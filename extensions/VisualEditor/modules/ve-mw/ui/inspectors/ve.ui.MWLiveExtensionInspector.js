/*!
 * VisualEditor UserInterface MWLiveExtensionInspector class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Inspector for editing generic MediaWiki extensions with dynamic rendering.
 *
 * @class
 * @abstract
 * @extends ve.ui.MWExtensionInspector
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWLiveExtensionInspector = function VeUiMWLiveExtensionInspector() {
	// Parent constructor
	ve.ui.MWLiveExtensionInspector.super.apply( this, arguments );

	// Late bind onChangeHandler to a debounced updatePreview
	this.onChangeHandler = ve.debounce( this.updatePreview.bind( this ), 250 );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWLiveExtensionInspector, ve.ui.MWExtensionInspector );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWLiveExtensionInspector.prototype.getSetupProcess = function ( data ) {
	return ve.ui.MWLiveExtensionInspector.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			var element = this.getNewElement();
			// Initialization
			this.getFragment().getSurface().pushStaging();

			if ( !this.selectedNode ) {
				// Create a new node
				// collapseToEnd returns a new fragment
				this.fragment = this.getFragment().collapseToEnd().insertContent( [
					element,
					{ type: '/' + element.type }
				] );
				// Check if the node was inserted at a structural offset and wrapped in a paragraph
				if ( this.getFragment().getSelection().getRange().getLength() === 4 ) {
					this.fragment = this.getFragment().adjustLinearSelection( 1, -1 );
				}
				this.getFragment().select();
				this.selectedNode = this.getFragment().getSelectedNode();
			}
			this.input.on( 'change', this.onChangeHandler );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWLiveExtensionInspector.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.MWLiveExtensionInspector.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			this.input.off( 'change', this.onChangeHandler );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWLiveExtensionInspector.prototype.insertOrUpdateNode = function () {
	// No need to call parent method as changes have already been made
	// to the model in staging, just need to apply them.
	this.getFragment().getSurface().applyStaging();
};

/**
 * @inheritdoc
 */
ve.ui.MWLiveExtensionInspector.prototype.removeNode = function () {
	this.getFragment().getSurface().popStaging();
	ve.ui.MWLiveExtensionInspector.super.prototype.removeNode.call( this );
};

/**
 * Update the node rendering to reflect the current content in the inspector.
 */
ve.ui.MWLiveExtensionInspector.prototype.updatePreview = function () {
	var mwData = ve.copy( this.selectedNode.getAttribute( 'mw' ) );

	this.updateMwData( mwData );

	if ( this.visible ) {
		this.getFragment().changeAttributes( { mw: mwData } );
	}
};
