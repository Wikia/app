/*!
 * VisualEditor DebugBar class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
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
	this.$dumpLinmodData = this.$( '<td>' ).addClass( 've-ui-debugBar-dump-linmod-data' );
	this.$dumpLinmodMetadata = this.$( '<td>' ).addClass( 've-ui-debugBar-dump-linmod-metadata' );
	this.$dumpView = this.$( '<td>' ).addClass( 've-ui-debugBar-dump-view' );
	this.$dumpModel = this.$( '<td>' ).addClass( 've-ui-debugBar-dump-model' );

	this.$dump =
		this.$( '<table class="ve-ui-debugBar-dump"></table>' ).append(
			this.$( '<thead><th>Linear model data</th><th>Linear model metadata</th><th>View tree</th><th>Model tree</th></thead>' ),
			this.$( '<tbody>' ).append(
				this.$( '<tr>' ).append(
					this.$dumpLinmodData, this.$dumpLinmodMetadata, this.$dumpView, this.$dumpModel
				)
			)
		);

	this.$filibuster = this.$( '<div class="ve-ui-debugBar-filibuster"></div>' );

	// Widgets
	this.selectionLabel = new OO.ui.LabelWidget( { classes: ['ve-ui-debugBar-selectionLabel'] } );

	this.logRangeButton = new OO.ui.ButtonWidget( { label: 'Log', disabled: true } );
	this.dumpModelButton = new OO.ui.ButtonWidget( { label: 'Dump model' } );
	this.dumpModelChangeToggle = new OO.ui.ToggleButtonWidget( { icon: 'check' } );
	this.inputDebuggingToggle = new OO.ui.ToggleButtonWidget( { label: 'Input debugging' } );
	this.filibusterToggle = new OO.ui.ToggleButtonWidget( { label: 'Filibuster' } );

	var dumpModelButtonGroup = new OO.ui.ButtonGroupWidget( { items: [
		this.dumpModelButton,
		this.dumpModelChangeToggle
	] } );

	// Events
	this.logRangeButton.on( 'click', this.onLogRangeButtonClick.bind( this ) );
	this.dumpModelButton.on( 'click', this.onDumpModelButtonClick.bind( this ) );
	this.dumpModelChangeToggle.on( 'click', this.onDumpModelChangeToggleClick.bind( this ) );
	this.inputDebuggingToggle.on( 'click', this.onInputDebuggingToggleClick.bind( this ) );
	this.filibusterToggle.on( 'click', this.onFilibusterToggleClick.bind( this ) );

	this.onDumpModelChangeToggleClick();
	this.getSurface().getModel().connect( this, { select: 'onSurfaceSelect' } );
	this.onSurfaceSelect( this.getSurface().getModel().getSelection() );

	this.$element.addClass( 've-ui-debugBar' );
	this.$element.append(
		this.$commands.append(
			this.selectionLabel.$element,
			this.logRangeButton.$element,
			this.$( this.constructor.static.dividerTemplate ),
			dumpModelButtonGroup.$element,
			this.inputDebuggingToggle.$element,
			this.filibusterToggle.$element
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
 * @returns {ve.ui.Surface|null} Surface
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
			ve.dir( this.getSurface().view.documentView.model.data.slice( ranges[i].start, ranges[i].end ) );
		}
	}
};

/**
 * Handle click events on the dump model button
 *
 * @param {jQuery.Event} e Event
 */
ve.ui.DebugBar.prototype.onDumpModelButtonClick = function () {
	var debugBar = this,
		surface = debugBar.getSurface(),
		documentModel = surface.getModel().getDocument(),
		documentView = surface.getView().getDocument();

	function dumpLinMod( linearData ) {
		var i, $li, $label, element, text, annotations, data,
			$ol = debugBar.$( '<ol start="0"></ol>' );

		data = linearData instanceof ve.dm.LinearData ? linearData.data : linearData;

		for ( i = 0; i < data.length; i++ ) {
			$li = debugBar.$( '<li>' );
			$label = debugBar.$( '<span>' );
			element = data[i];
			annotations = null;
			if ( linearData instanceof ve.dm.MetaLinearData ) {
				if ( element && element.length ) {
					$li.append( dumpLinMod( element ) );
				} else {
					$li.append( debugBar.$( '<span>undefined</span>' ).addClass( 've-ui-debugBar-dump-undefined' ) );
				}
			} else {
				if ( element.type ) {
					$label.addClass( 've-ui-debugBar-dump-element' );
					text = element.type;
					annotations = element.annotations;
				} else if ( Array.isArray( element ) ) {
					$label.addClass( 've-ui-debugBar-dump-achar' );
					text = element[0];
					annotations = element[1];
				} else {
					$label.addClass( 've-ui-debugBar-dump-char' );
					text = element;
				}
				$label.html( ( text.match( /\S/ ) ? text : '&nbsp;' ) + ' ' );
				if ( annotations ) {
					$label.append(
						/*jshint loopfunc:true */
						debugBar.$( '<span>' ).text(
							'[' + documentModel.store.values( annotations ).map( function ( ann ) {
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
	}

	// linear model dump
	debugBar.$dumpLinmodData.html( dumpLinMod( documentModel.data ) );
	debugBar.$dumpLinmodMetadata.html( dumpLinMod( documentModel.metadata ) );

	/**
	 * Generate an ordered list describing a node
	 *
	 * @param {ve.Node} node Node
	 * @returns {jQuery} Ordered list
	 */
	function generateListFromNode( node ) {
		var $li, i, $label,
			$ol = debugBar.$( '<ol start="0"></ol>' );

		for ( i = 0; i < node.children.length; i++ ) {
			$li = debugBar.$( '<li>' );
			$label = debugBar.$( '<span>' ).addClass( 've-ui-debugBar-dump-element' );
			if ( node.children[i].length !== undefined ) {
				$li.append(
					$label
						.text( node.children[i].type )
						.append(
							debugBar.$( '<span>' ).text( ' (' + node.children[i].length + ')' )
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

	debugBar.$dumpModel.html(
		generateListFromNode( documentModel.getDocumentNode() )
	);
	debugBar.$dumpView.html(
		generateListFromNode( documentView.getDocumentNode() )
	);
	debugBar.$dump.show();
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
	ve.inputDebug = this.inputDebuggingToggle.getValue();
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
				$li.children( 'span').replaceWith(
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
