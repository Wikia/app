/*!
 * VisualEditor DebugBar class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global alert */

/**
 * Debug bar
 *
 * @class
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.init.DebugBar = function VeUiDebugBar() {

	this.$element = $( '<div>' ).addClass( 've-init-debugBar' );

	this.$commands = $( '<div>' ).addClass( 've-init-debugBar-commands' );
	this.$dumpLinmod = $( '<td>' ).addClass( 've-init-debugBar-dump-linmod' );
	this.$dumpView = $( '<td>' ).addClass( 've-init-debugBar-dump-view' );
	this.$dumpModel = $( '<td>' ).addClass( 've-init-debugBar-dump-model' );

	this.$dump =
		$( '<table class="ve-init-debugBar-dump"></table>' ).append(
			$( '<thead><th>Linear model</th><th>View tree</th><th>Model tree</th></thead>' ),
			$( '<tbody>' ).append(
				$( '<tr>' ).append(
					this.$dumpLinmod, this.$dumpView, this.$dumpModel
				)
			)
		);

	// Widgets
	this.startTextInput = new OO.ui.TextInputWidget( { 'readOnly': true } );
	this.endTextInput = new OO.ui.TextInputWidget( { 'readOnly': true } );

	this.logRangeButton = new OO.ui.ButtonWidget( { 'label': 'Log to console', 'disabled': true } );
	this.dumpModelButton = new OO.ui.ButtonWidget( { 'label': 'Dump model' } );
	this.dumpModelChangeToggle = new OO.ui.ToggleButtonWidget( { 'label': 'Dump model on change' } );
	this.validateButton = new OO.ui.ButtonWidget( { 'label': 'Validate view and model' } );

	var startLabel = new OO.ui.LabelWidget(
			{ 'label': 'Range', 'input': this.startTextInput }
		),
		endLabel = new OO.ui.LabelWidget(
			{ 'label': '-', 'input': this.endTextInput }
		);

	// Events
	this.logRangeButton.on( 'click', ve.bind( this.onLogRangeButtonClick, this ) );
	this.dumpModelButton.on( 'click', ve.bind( this.onDumpModelButtonClick, this ) );
	this.dumpModelChangeToggle.on( 'click', ve.bind( this.onDumpModelChangeToggleClick, this ) );
	this.validateButton.on( 'click', ve.bind( this.onValidateButtonClick, this ) );

	this.$element.append(
		this.$commands.append(
			startLabel.$element,
			this.startTextInput.$element,
			endLabel.$element,
			this.endTextInput.$element,
			this.logRangeButton.$element,
			$( this.constructor.static.dividerTemplate ),
			this.dumpModelButton.$element,
			this.dumpModelChangeToggle.$element,
			this.validateButton.$element
		),
		this.$dump
	);

	this.target = null;
};

ve.init.DebugBar.static = {};

/**
 * Divider HTML template
 *
 * @property {string}
 */
ve.init.DebugBar.static.dividerTemplate = '<span class="ve-init-debugBar-commands-divider">&nbsp;</span>';

/**
 * Attach debug bar to a surface
 *
 * @param {ve.ui.Surface} surface Surface
 */
ve.init.DebugBar.prototype.attachToSurface = function ( surface ) {
	this.surface = surface;
	this.dumpModelChangeToggle.emit( 'click' );
	this.surface.model.connect( this, { 'select':  this.onSurfaceSelect } );
	// Fire on load
	this.onSurfaceSelect( this.surface.getModel().getSelection() );
};

/**
 * Get surface the debug bar is attached to
 *
 * @returns {ve.ui.Surface|null} Surface
 */
ve.init.DebugBar.prototype.getSurface = function () {
	return this.surface;
};

/**
 * Handle select events on the attached surface
 *
 * @param {ve.Range} range
 */
ve.init.DebugBar.prototype.onSurfaceSelect = function ( range ) {
	if ( range ) {
		this.startTextInput.setValue( range.start );
		this.endTextInput.setValue( range.end );
	}
	this.startTextInput.setDisabled( !range );
	this.endTextInput.setDisabled( !range );
	this.logRangeButton.setDisabled( false );
};

/**
 * Handle click events on the log range button
 *
 * @param {jQuery.Event} e Event
 */
ve.init.DebugBar.prototype.onLogRangeButtonClick = function () {
	var start = this.startTextInput.getValue(),
		end = this.endTextInput.getValue();
	// TODO: Validate input
	ve.dir( this.getSurface().view.documentView.model.data.slice( start, end ) );
};

/**
 * Handle click events on the dump model button
 *
 * @param {jQuery.Event} e Event
 */
ve.init.DebugBar.prototype.onDumpModelButtonClick = function () {
	/*jshint loopfunc:true */
	// linear model dump
	var i, $li, $label, element, text, annotations,
		surface = this.getSurface(),
		documentModel = surface.getModel().getDocument(),
		documentView = surface.getView().getDocument(),
		$ol = $( '<ol start="0"></ol>' );

	for ( i = 0; i < documentModel.data.getLength(); i++ ) {
		$li = $( '<li>' );
		$label = $( '<span>' );
		element = documentModel.data.getData( i );
		if ( element.type ) {
			$label.addClass( 've-init-debugBar-dump-element' );
			text = element.type;
			annotations = element.annotations;
		} else if ( ve.isArray( element ) ){
			$label.addClass( 've-init-debugBar-dump-achar' );
			text = element[0];
			annotations = element[1];
		} else {
			$label.addClass( 've-init-debugBar-dump-char' );
			text = element;
			annotations = undefined;
		}
		$label.html( ( text.match( /\S/ ) ? text : '&nbsp;' ) + ' ' );
		if ( annotations ) {
			$label.append(
				$( '<span>' ).text(
					'[' + documentModel.store.values( annotations ).map( function ( ann ) {
						return JSON.stringify( ann.getComparableObject() );
					} ).join( ', ' ) + ']'
				)
			);
		}

		$li.append( $label );
		$ol.append( $li );
	}
	this.$dumpLinmod.html( $ol );

	/**
	 * Generate an ordered list describing a node
	 *
	 * @param {ve.Node} node Node
	 * @returns {jQuery} Ordered list
	 */
	function generateListFromNode( node ) {
		var $li, i,
			$ol = $( '<ol start="0"></ol>' );

		for ( i = 0; i < node.children.length; i++ ) {
			$li = $( '<li>' );
			$label = $( '<span>' ).addClass( 've-init-debugBar-dump-element' );
			if ( node.children[i].length !== undefined ) {
				$li.append(
					$label
						.text( node.children[i].type )
						.append(
							$( '<span>' ).text( ' (' + node.children[i].length + ')' )
						)
				);
			} else {
				$li.append( $label.text( node.children[i].type ) );
			}

			if ( node.children[i].children ) {
				$li.append( generateListFromNode( node.children[i] ) );
			}

			$ol.append( $li );
		}
		return $ol;
	}

	this.$dumpModel.html(
		generateListFromNode( documentModel.getDocumentNode() )
	);
	this.$dumpView.html(
		generateListFromNode( documentView.getDocumentNode() )
	);
	this.$dump.show();
};

/**
 * Handle click events on the dump model toggle button
 *
 * @param {jQuery.Event} e Event
 */
ve.init.DebugBar.prototype.onDumpModelChangeToggleClick = function () {
	if ( this.dumpModelChangeToggle.getValue() ) {
		this.dumpModelButton.emit( 'click' );
		this.getSurface().model.connect( this, { 'documentUpdate': this.onDumpModelButtonClick } );
	} else {
		this.getSurface().model.disconnect( this, { 'documentUpdate': this.onDumpModelButtonClick } );
	}
};

/**
 * Handle click events on the validate button
 *
 * @param {jQuery.Event} e Event
 */
ve.init.DebugBar.prototype.onValidateButtonClick = function () {
	var failed = false, surface = this.getSurface();

	$( '.ve-ce-branchNode' ).each( function ( index, element ) {
		var nodeRange, textModel, textDom,
			$element = $( element ),
			view = $element.data( 'view' );
		if ( view.canContainContent() ) {
			nodeRange = view.model.getRange();
			textModel = surface.view.model.getDocument().getText( nodeRange );
			textDom = ve.ce.getDomText( view.$element[0] );
			if ( textModel !== textDom ) {
				failed = true;
				ve.log( 'Inconsistent data', {
					'textModel': textModel,
					'textDom': textDom,
					'element': element
				} );
			}
		}
	} );
	if ( failed ) {
		alert( 'Not valid - check JS console for details' );
	} else {
		alert( 'Valid' );
	}
};
