/*!
 * VisualEditor UserInterface CommentInspector class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Comment inspector.
 *
 * @class
 * @extends ve.ui.NodeInspector
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.CommentInspector = function VeUiCommentInspector( config ) {
	// Parent constructor
	ve.ui.NodeInspector.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.CommentInspector, ve.ui.NodeInspector );

/* Static properties */

ve.ui.CommentInspector.static.name = 'comment';

ve.ui.CommentInspector.static.icon = 'comment';

ve.ui.CommentInspector.static.title =
	OO.ui.deferMsg( 'visualeditor-commentinspector-title' );

ve.ui.CommentInspector.static.modelClasses = [ ve.dm.CommentNode ];

ve.ui.CommentInspector.static.size = 'large';

ve.ui.CommentInspector.static.actions = [
	{
		action: 'done',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-done' ),
		flags: [ 'progressive', 'primary' ],
		modes: 'edit'
	},
	{
		action: 'insert',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-insert' ),
		flags: [ 'constructive', 'primary' ],
		modes: 'insert'
	},
	{
		action: 'remove',
		label: OO.ui.deferMsg( 'visualeditor-inspector-remove-tooltip' ),
		flags: 'destructive',
		modes: 'edit'
	}
];

/**
 * Handle frame ready events.
 *
 * @method
 */
ve.ui.CommentInspector.prototype.initialize = function () {
	// Parent method
	ve.ui.CommentInspector.super.prototype.initialize.call( this );

	this.textWidget = new ve.ui.WhitespacePreservingTextInputWidget( {
		$: this.$,
		multiline: true,
		autosize: true
	} );
	this.previousTextWidgetHeight = 0;

	this.textWidget.connect( this, { change: 'onTextInputWidgetChange' } );

	this.$content.addClass( 've-ui-commentInspector-content' );
	this.form.$element.append( this.textWidget.$element );
};

/**
 * Called when the text input widget value has changed.
 */
ve.ui.CommentInspector.prototype.onTextInputWidgetChange = function () {
	var height = this.textWidget.$element.height();
	if ( height !== this.previousTextWidgetHeight ) {
		this.getManager().updateWindowSize( this );
		this.previousTextWidgetHeight = height;
	}
};

/**
 * @inheritdoc
 */
ve.ui.CommentInspector.prototype.getActionProcess = function ( action ) {
	if ( action === 'remove' || action === 'insert' ) {
		return new OO.ui.Process( function () {
			this.close( { action: action } );
		}, this );
	}
	return ve.ui.CommentInspector.super.prototype.getActionProcess.call( this, action );
};

/**
 * Handle the inspector being setup.
 *
 * @method
 * @param {Object} [data] Inspector opening data
 */
ve.ui.CommentInspector.prototype.getSetupProcess = function ( data ) {
	return ve.ui.CommentInspector.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.getFragment().getSurface().pushStaging();

			this.commentNode = this.getSelectedNode();
			if ( this.commentNode ) {
				this.textWidget.setValueAndWhitespace( this.commentNode.getAttribute( 'text' ) || '' );
				this.actions.setMode( 'edit' );
			} else {
				this.textWidget.setWhitespace( [ ' ', ' ' ] );
				this.actions.setMode( 'insert' );
				this.getFragment().insertContent( [
					{
						type: 'comment',
						attributes: { text: '' }
					},
					{ type: '/comment' }
				] );
				this.commentNode = this.getSelectedNode();
			}
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.CommentInspector.prototype.getReadyProcess = function ( data ) {
	return ve.ui.CommentInspector.super.prototype.getReadyProcess.call( this, data )
		.next( function () {
			this.getFragment().getSurface().enable();
			this.textWidget.focus();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.CommentInspector.prototype.getTeardownProcess = function ( data ) {
	data = data || {};
	return ve.ui.CommentInspector.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			var surfaceModel = this.getFragment().getSurface(),
				text = this.textWidget.getValue(),
				innerText = this.textWidget.getInnerValue();

			if ( data.action === 'remove' || innerText === '' ) {
				surfaceModel.popStaging();
				// If popStaging removed the node then this will be a no-op
				this.getFragment().removeContent();
			} else {
				// Edit comment node
				this.getFragment().changeAttributes( { text: text } );
				surfaceModel.applyStaging();
			}

			// Reset inspector
			this.textWidget.setValueAndWhitespace( '' );
		}, this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.CommentInspector );
