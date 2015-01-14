/*!
 * VisualEditor DebugBar class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Debug bar
 *
 * @class
 * @extends OO.ui.Element
 *
 * @constructor
 * @param {ve.ui.Surface} surface Surface to debug
 * @param {Object} [config] Configuration options
 */
ve.ui.DebugBar = function VeUiDebugBar( surface, config ) {
	// Parent constructor
	OO.ui.Element.call( this, config );

	this.surface = surface;

	this.$commands = this.$( '<div>' ).addClass( 've-ui-debugBar-commands' );
	this.$dumpLinmod = this.$( '<td>' ).addClass( 've-ui-debugBar-dump-linmod' );
	this.$dumpView = this.$( '<td>' ).addClass( 've-ui-debugBar-dump-view' );
	this.$dumpModel = this.$( '<td>' ).addClass( 've-ui-debugBar-dump-model' );

	this.$dump =
		this.$( '<table class="ve-ui-debugBar-dump"></table>' ).append(
			this.$( '<thead><th>Linear model</th><th>View tree</th><th>Model tree</th></thead>' ),
			this.$( '<tbody>' ).append(
				this.$( '<tr>' ).append(
					this.$dumpLinmod, this.$dumpView, this.$dumpModel
				)
			)
		);

	// Widgets
	this.startTextInput = new OO.ui.TextInputWidget( { 'readOnly': true } );
	this.endTextInput = new OO.ui.TextInputWidget( { 'readOnly': true } );

	this.logRangeButton = new OO.ui.ButtonWidget( { 'label': 'Log range', 'disabled': true } );
	this.dumpModelButton = new OO.ui.ButtonWidget( { 'label': 'Dump model' } );
	this.dumpModelChangeToggle = new OO.ui.ToggleButtonWidget( { 'label': 'Dump on change' } );

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

	this.onDumpModelChangeToggleClick();
	this.getSurface().getModel().connect( this, { 'select': this.onSurfaceSelect } );
	this.onSurfaceSelect( this.getSurface().getModel().getSelection() );

	this.$element.addClass( 've-ui-debugBar' );
	this.$element.append(
		this.$commands.append(
			startLabel.$element,
			this.startTextInput.$element,
			endLabel.$element,
			this.endTextInput.$element,
			this.logRangeButton.$element,
			this.$( this.constructor.static.dividerTemplate ),
			this.dumpModelButton.$element,
			this.dumpModelChangeToggle.$element
		),
		this.$dump
	);

	this.target = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.DebugBar, OO.ui.Element );

/**
 * Divider HTML template
 *
 * @property {string}
 */
ve.ui.DebugBar.static.dividerTemplate = '<span class="ve-ui-debugBar-commands-divider">&nbsp;</span>';

/**
 * Get surface the debug bar is attached to
 *
 * @returns {ve.ui.Surface|null} Surface
 */
ve.ui.DebugBar.prototype.getSurface = function () {
	return this.surface;
};

/**
 * Handle select events on the attached surface
 *
 * @param {ve.Range} range
 */
ve.ui.DebugBar.prototype.onSurfaceSelect = function ( range ) {
	if ( range ) {
		this.startTextInput.setValue( range.start );
		this.endTextInput.setValue( range.end );
	}
	this.startTextInput.setDisabled( !range );
	this.endTextInput.setDisabled( !range );
	this.logRangeButton.setDisabled( !range || range.isCollapsed() );
};

/**
 * Handle click events on the log range button
 *
 * @param {jQuery.Event} e Event
 */
ve.ui.DebugBar.prototype.onLogRangeButtonClick = function () {
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
ve.ui.DebugBar.prototype.onDumpModelButtonClick = function () {
	/*jshint loopfunc:true */
	// linear model dump
	var i, $li, $label, element, text, annotations,
		surface = this.getSurface(),
		documentModel = surface.getModel().getDocument(),
		documentView = surface.getView().getDocument(),
		$ol = this.$( '<ol start="0"></ol>' );

	for ( i = 0; i < documentModel.data.getLength(); i++ ) {
		$li = this.$( '<li>' );
		$label = this.$( '<span>' );
		element = documentModel.data.getData( i );
		if ( element.type ) {
			$label.addClass( 've-ui-debugBar-dump-element' );
			text = element.type;
			annotations = element.annotations;
		} else if ( ve.isArray( element ) ) {
			$label.addClass( 've-ui-debugBar-dump-achar' );
			text = element[0];
			annotations = element[1];
		} else {
			$label.addClass( 've-ui-debugBar-dump-char' );
			text = element;
			annotations = undefined;
		}
		$label.html( ( text.match( /\S/ ) ? text : '&nbsp;' ) + ' ' );
		if ( annotations ) {
			$label.append(
				this.$( '<span>' ).text(
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
			$ol = this.$( '<ol start="0"></ol>' );

		for ( i = 0; i < node.children.length; i++ ) {
			$li = this.$( '<li>' );
			$label = this.$( '<span>' ).addClass( 've-ui-debugBar-dump-element' );
			if ( node.children[i].length !== undefined ) {
				$li.append(
					$label
						.text( node.children[i].type )
						.append(
							this.$( '<span>' ).text( ' (' + node.children[i].length + ')' )
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
ve.ui.DebugBar.prototype.onDumpModelChangeToggleClick = function () {
	if ( this.dumpModelChangeToggle.getValue() ) {
		this.onDumpModelButtonClick();
		this.getSurface().model.connect( this, { 'documentUpdate': this.onDumpModelButtonClick } );
	} else {
		this.getSurface().model.disconnect( this, { 'documentUpdate': this.onDumpModelButtonClick } );
	}
};
