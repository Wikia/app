/*!
 * VisualEditor DebugBar class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
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
	var dumpModelButtonGroup, hideDumpButton, closeButton;

	// Parent constructor
	OO.ui.Element.call( this, config );

	this.surface = surface;

	this.$commands = $( '<div>' ).addClass( 've-ui-debugBar-commands' );
	this.$dumpLinmodData = $( '<td>' ).addClass( 've-ui-debugBar-dump-linmod-data' );
	this.$dumpLinmodMetadata = $( '<td>' ).addClass( 've-ui-debugBar-dump-linmod-metadata' );
	this.$dumpView = $( '<td>' ).addClass( 've-ui-debugBar-dump-view' );
	this.$dumpModel = $( '<td>' ).addClass( 've-ui-debugBar-dump-model' );

	hideDumpButton = new OO.ui.ButtonWidget( {
		icon: 'collapse',
		label: 'Hide'
	} );

	closeButton = new OO.ui.ButtonWidget( {
		icon: 'close',
		label: 'Close'
	} );

	this.$dump =
		$( '<div class="ve-ui-debugBar-dump">' ).append(
			hideDumpButton.$element,
			$( '<table></table>' ).append(
				$( '<thead><th>Linear model data</th><th>Linear model metadata</th><th>View tree</th><th>Model tree</th></thead>' ),
				$( '<tbody>' ).append(
					$( '<tr>' ).append(
						this.$dumpLinmodData, this.$dumpLinmodMetadata, this.$dumpView, this.$dumpModel
					)
				)
			)
		).hide();

	this.$filibuster = $( '<div class="ve-ui-debugBar-filibuster"></div>' );

	// Widgets
	this.selectionLabel = new OO.ui.LabelWidget( { classes: [ 've-ui-debugBar-selectionLabel' ] } );

	this.logRangeButton = new OO.ui.ButtonWidget( { label: 'Log', disabled: true } );
	this.dumpModelButton = new OO.ui.ButtonWidget( { label: 'Dump model' } );
	this.dumpModelChangeToggle = new OO.ui.ToggleButtonWidget( { icon: 'check' } );
	this.inputDebuggingToggle = new OO.ui.ToggleButtonWidget( { label: 'Input debugging' } );
	this.filibusterToggle = new OO.ui.ToggleButtonWidget( { label: 'Filibuster' } );

	dumpModelButtonGroup = new OO.ui.ButtonGroupWidget( { items: [
		this.dumpModelButton,
		this.dumpModelChangeToggle
	] } );

	// Events
	this.logRangeButton.on( 'click', this.onLogRangeButtonClick.bind( this ) );
	this.dumpModelButton.on( 'click', this.onDumpModelButtonClick.bind( this ) );
	this.dumpModelChangeToggle.on( 'click', this.onDumpModelChangeToggleClick.bind( this ) );
	this.inputDebuggingToggle.on( 'click', this.onInputDebuggingToggleClick.bind( this ) );
	this.filibusterToggle.on( 'click', this.onFilibusterToggleClick.bind( this ) );
	hideDumpButton.on( 'click', this.$dump.hide.bind( this.$dump ) );
	closeButton.on( 'click', this.$element.remove.bind( this.$element ) );

	this.onDumpModelChangeToggleClick();
	this.getSurface().getModel().connect( this, { select: 'onSurfaceSelect' } );
	this.onSurfaceSelect( this.getSurface().getModel().getSelection() );

	this.$element.addClass( 've-ui-debugBar' );
	this.$element.append(
		this.$commands.append(
			this.selectionLabel.$element,
			this.logRangeButton.$element,
			$( this.constructor.static.dividerTemplate ),
			dumpModelButtonGroup.$element,
			this.inputDebuggingToggle.$element,
			this.filibusterToggle.$element,
			$( this.constructor.static.dividerTemplate ),
			closeButton.$element
		),
		this.$dump,
		this.$filibuster
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
 * @return {ve.ui.Surface|null} Surface
 */
ve.ui.DebugBar.prototype.getSurface = function () {
	return this.surface;
};

/**
 * Handle select events on the attached surface
 *
 * @param {ve.dm.Selection} selection
 */
ve.ui.DebugBar.prototype.onSurfaceSelect = function ( selection ) {
	this.selectionLabel.setLabel( selection.getDescription() );
	this.logRangeButton.setDisabled( !(
		( selection instanceof ve.dm.LinearSelection && !selection.isCollapsed() ) ||
		selection instanceof ve.dm.TableSelection
	) );
};

/**
 * Handle click events on the log range button
 *
 * @param {jQuery.Event} e Event
 */
ve.ui.DebugBar.prototype.onLogRangeButtonClick = function () {
	var i, ranges, selection = this.getSurface().getModel().getSelection();
	if ( selection instanceof ve.dm.LinearSelection || selection instanceof ve.dm.TableSelection ) {
		ranges = selection.getRanges();
		for ( i = 0; i < ranges.length; i++ ) {
			ve.dir( this.getSurface().view.documentView.model.data.slice( ranges[ i ].start, ranges[ i ].end ) );
		}
	}
};

/**
 * Handle click events on the dump model button
 *
 * @param {jQuery.Event} e Event
 */
ve.ui.DebugBar.prototype.onDumpModelButtonClick = function () {
	var surface = this.getSurface(),
		documentModel = surface.getModel().getDocument(),
		documentView = surface.getView().getDocument();

	// linear model dump
	this.$dumpLinmodData.html( this.generateListFromLinearData( documentModel.data ) );
	this.$dumpLinmodMetadata.html( this.generateListFromLinearData( documentModel.metadata ) );

	this.$dumpModel.html(
		this.generateListFromNode( documentModel.getDocumentNode() )
	);
	this.$dumpView.html(
		this.generateListFromNode( documentView.getDocumentNode() )
	);
	this.$dump.show();
};

/**
 * Get an ordered list representation of some linear data
 *
 * @param {ve.dm.LinearData} linearData Linear data
 * @return {jQuery} Ordered list
 */
ve.ui.DebugBar.prototype.generateListFromLinearData = function ( linearData ) {
	var i, $li, $label, element, text, annotations, data,
		$ol = $( '<ol start="0"></ol>' );

	data = linearData instanceof ve.dm.LinearData ? linearData.data : linearData;

	for ( i = 0; i < data.length; i++ ) {
		$li = $( '<li>' );
		$label = $( '<span>' );
		element = data[ i ];
		annotations = null;
		if ( linearData instanceof ve.dm.MetaLinearData ) {
			if ( element && element.length ) {
				$li.append( this.generateListFromLinearData( element ) );
			} else {
				$li.append( $( '<span>undefined</span>' ).addClass( 've-ui-debugBar-dump-undefined' ) );
			}
		} else {
			if ( element.type ) {
				$label.addClass( 've-ui-debugBar-dump-element' );
				text = element.type;
				annotations = element.annotations;
			} else if ( Array.isArray( element ) ) {
				$label.addClass( 've-ui-debugBar-dump-achar' );
				text = element[ 0 ];
				annotations = element[ 1 ];
			} else {
				$label.addClass( 've-ui-debugBar-dump-char' );
				text = element;
			}
			$label.html( ( text.match( /\S/ ) ? text : '&nbsp;' ) + ' ' );
			if ( annotations ) {
				$label.append(
					/*jshint loopfunc:true */
					$( '<span>' ).text(
						'[' + this.getSurface().getModel().getDocument().getStore().values( annotations ).map( function ( ann ) {
							return JSON.stringify( ann.getComparableObject() );
						} ).join( ', ' ) + ']'
					)
				);
			}

			$li.append( $label );
		}
		$ol.append( $li );
	}
	return $ol;
};

/**
 * Generate an ordered list describing a node
 *
 * @param {ve.Node} node Node
 * @return {jQuery} Ordered list
 */
ve.ui.DebugBar.prototype.generateListFromNode = function ( node ) {
	var $li, i, $label,
		$ol = $( '<ol start="0"></ol>' );

	for ( i = 0; i < node.children.length; i++ ) {
		$li = $( '<li>' );
		$label = $( '<span>' ).addClass( 've-ui-debugBar-dump-element' );
		if ( node.children[ i ].length !== undefined ) {
			$li.append(
				$label
					.text( node.children[ i ].type )
					.append(
						$( '<span>' ).text( ' (' + node.children[ i ].length + ')' )
					)
			);
		} else {
			$li.append( $label.text( node.children[ i ].type ) );
		}

		if ( node.children[ i ].children ) {
			$li.append( this.generateListFromNode( node.children[ i ] ) );
		}

		$ol.append( $li );
	}
	return $ol;
};

/**
 * Handle click events on the dump model toggle button
 *
 * @param {jQuery.Event} e Event
 */
ve.ui.DebugBar.prototype.onDumpModelChangeToggleClick = function () {
	if ( this.dumpModelChangeToggle.getValue() ) {
		this.onDumpModelButtonClick();
		this.getSurface().model.connect( this, { documentUpdate: 'onDumpModelButtonClick' } );
	} else {
		this.getSurface().model.disconnect( this, { documentUpdate: 'onDumpModelButtonClick' } );
	}
};

ve.ui.DebugBar.prototype.onInputDebuggingToggleClick = function () {
	var surfaceModel = this.getSurface().getModel(),
		selection = surfaceModel.getSelection();

	ve.inputDebug = this.inputDebuggingToggle.getValue();

	// Clear the cursor before rebuilding, it will be restored later
	surfaceModel.setNullSelection();
	setTimeout( function () {
		surfaceModel.getDocument().rebuildTree();
		surfaceModel.setSelection( selection );
	} );
};

/**
 * Handle click events on the filibuster toggle button
 *
 * @param {jQuery.Event} e Event
 */
ve.ui.DebugBar.prototype.onFilibusterToggleClick = function () {
	var debugBar = this;
	if ( this.filibusterToggle.getValue() ) {
		this.filibusterToggle.setLabel( 'Stop Filibuster' );
		this.$filibuster.off( 'click' );
		this.$filibuster.hide();
		this.$filibuster.empty();
		this.getSurface().startFilibuster();
	} else {
		this.getSurface().stopFilibuster();
		this.$filibuster.html( this.getSurface().filibuster.getObservationsHtml() );
		this.$filibuster.show();
		this.$filibuster.on( 'click', function ( e ) {
			var path,
				$li = $( e.target ).closest( '.ve-filibuster-frame' );

			if ( $li.hasClass( 've-filibuster-frame-expandable' ) ) {
				$li.removeClass( 've-filibuster-frame-expandable' );
				path = $li.data( 've-filibuster-frame' );
				if ( !path ) {
					return;
				}
				$li.children( 'span' ).replaceWith(
					$( debugBar.getSurface().filibuster.getObservationsHtml( path ) )
				);
				$li.toggleClass( 've-filibuster-frame-expanded' );
			} else if ( $li.children( 'ul' ).length ) {
				$li.toggleClass( 've-filibuster-frame-collapsed' );
				$li.toggleClass( 've-filibuster-frame-expanded' );
			}
		} );
		this.filibusterToggle.setLabel( 'Start Filibuster' );
	}
};

/**
 * Destroy the debug bar
 */
ve.ui.DebugBar.prototype.destroy = function () {
	this.getSurface().getModel().disconnect();
	this.$element.remove();
};
