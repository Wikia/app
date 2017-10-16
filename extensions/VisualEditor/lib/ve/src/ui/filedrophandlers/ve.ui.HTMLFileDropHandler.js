/*!
 * VisualEditor UserInterface HTML file drop handler class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * HTML file drop handler.
 *
 * @class
 * @extends ve.ui.FileDropHandler
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {File} file
 */
ve.ui.HTMLFileDropHandler = function VeUiHTMLFileDropHandler() {
	// Parent constructor
	ve.ui.HTMLFileDropHandler.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.ui.HTMLFileDropHandler, ve.ui.FileDropHandler );

/* Static properties */

ve.ui.HTMLFileDropHandler.static.name = 'html';

ve.ui.HTMLFileDropHandler.static.types = [ 'text/html', 'application/xhtml+xml' ];

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.HTMLFileDropHandler.prototype.process = function () {
	this.createProgress( this.insertableDataDeferred.promise() );
	this.reader.readAsText( this.file );
};

/**
 * @inheritdoc
 */
ve.ui.HTMLFileDropHandler.prototype.onFileProgress = function ( e ) {
	if ( e.lengthComputable ) {
		this.setProgress( 100 * e.loaded / e.total );
	} else {
		this.setProgress( false );
	}
};

/**
 * @inheritdoc
 */
ve.ui.HTMLFileDropHandler.prototype.onFileLoad = function () {
	this.insertableDataDeferred.resolve(
		this.surface.getModel().getDocument().newFromHtml( this.reader.result )
	);
	this.setProgress( 100 );
};

/**
 * @inheritdoc
 */
ve.ui.HTMLFileDropHandler.prototype.onFileLoadEnd = function () {
	// 'loadend' fires after 'load'/'abort'/'error'.
	// Reject the deferred if it hasn't already resolved.
	this.insertableDataDeferred.reject();
};

/**
 * @inheritdoc
 */
ve.ui.HTMLFileDropHandler.prototype.abort = function () {
	// Parent method
	ve.ui.HTMLFileDropHandler.super.prototype.abort.call( this );

	this.reader.abort();
};

/* Registration */

ve.ui.fileDropHandlerFactory.register( ve.ui.HTMLFileDropHandler );
