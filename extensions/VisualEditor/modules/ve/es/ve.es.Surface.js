/**
 * Creates an ve.es.Surface object.
 * 
 * @class
 * @constructor
 * @param {jQuery} $container DOM Container to render surface into
 * @param {ve.dm.Surface} model Surface model to view
 */
ve.es.Surface = function( $container, model ) {
	// Inheritance
	ve.EventEmitter.call( this );

	// References for use in closures
	var	_this = this,
		$document = $( document ),
		$window = $( window );
	
	// Properties
	this.model = model;
	this.currentSelection = new ve.Range();
	this.documentView = new ve.es.DocumentNode( this.model.getDocument(), this );
	this.contextView = null;
	this.$ = $container
		.addClass( 'es-surfaceView' )
		.append( this.documentView.$ );
	this.$input = $( '<textarea class="es-surfaceView-textarea" autocapitalize="off" />' )
		.appendTo( 'body' );
	this.$cursor = $( '<div class="es-surfaceView-cursor"></div>' )
		.appendTo( 'body' );
	this.insertionAnnotations = [];
	this.updateSelectionTimeout = undefined;
	this.emitUpdateTimeout = undefined;
	this.emitCursorTimeout = undefined;

	// Interaction states
	
	/*
	 * There are three different selection modes available for mouse. Selection of:
	 *     1 - chars
	 *     2 - words
	 *     3 - nodes (e.g. paragraph, listitem)
	 *
	 * In case of 2 and 3 selectedRange stores the range of original selection caused by double
	 * or triple mousedowns.
	 */
	this.mouse = {
		selectingMode: null,
		selectedRange: null
	};
	this.cursor = {
		interval: null,
		initialLeft: null,
		initialBias: false
	};
	this.keyboard = {
		selecting: false,
		cursorAnchor: null,
		keydownTimeout: null,
		keys: { shift: false }
	};
	this.dimensions = {
		width: this.$.width(),
		height: $window.height(),
		scrollTop: $window.scrollTop(),
		// XXX: This is a dirty hack!
		toolbarHeight: $( '#es-toolbar' ).height()
	};

	// Events

	this.model.on( 'select', function( selection ) {
		// Keep a copy of the current selection on hand
		_this.currentSelection = selection.clone();
		// Respond to selection changes
		_this.updateSelection();
		if ( selection.getLength() ) {
			_this.$input.val( _this.documentView.model.getContentText( selection ) ).select();
			_this.clearInsertionAnnotations();
		} else {
			_this.$input.val('').select();
			_this.loadInsertionAnnotations();
		}
	} );
	this.model.getDocument().on( 'update', function() {
		_this.emitUpdate( 25 );
	} );
	this.on( 'update', function() {
		_this.updateSelection( 25 );
	} );
	this.$.mousedown( function(e) {
		return _this.onMouseDown( e );
	} );
	this.$input.bind( {
			'focus': function() {
				// Make sure we aren't double-binding
				$document.unbind( '.es-surfaceView' );
				// Bind mouse and key events to the document to ensure we don't miss anything
				$document.bind( {
					'mousemove.es-surfaceView': function(e) {
						return _this.onMouseMove( e );
					},
					'mouseup.es-surfaceView': function(e) {
						return _this.onMouseUp( e );
					},
					'keydown.es-surfaceView': function( e ) {
						return _this.onKeyDown( e );			
					},
					'keyup.es-surfaceView': function( e ) {
						return _this.onKeyUp( e );		
					},
					'copy.es-surfaceView': function( e ) {
						return _this.onCopy( e );		
					},
					'cut.es-surfaceView': function( e ) {
						return _this.onCut( e );		
					},
					'paste.es-surfaceView': function( e ) {
						return _this.onPaste( e );		
					}
				} );
			},
			'blur': function( e ) {
				// Release our event handlers when not focused
				$document.unbind( '.es-surfaceView' );
				_this.hideCursor();
			},
			'paste': function() {
				setTimeout( function() {
					_this.model.breakpoint();
					_this.insertFromInput();
					_this.model.breakpoint();
				}, 0 );
			}
		} );
	$window.bind( {
		'resize': function() {
			// Re-render when resizing horizontally
			// TODO: Instead of re-rendering on every single 'resize' event wait till user is done
			// with resizing - can be implemented with setTimeout
			_this.hideCursor();
			_this.dimensions.height = $window.height();
			// XXX: This is a dirty hack!
			_this.dimensions.toolbarHeight = $( '#es-toolbar' ).height();
			var width = _this.$.width();
			if ( _this.dimensions.width !== width ) {
				_this.dimensions.width = width;
				_this.documentView.renderContent();
				_this.emitUpdate( 25 );
			}
		},
		'scroll': function() {
			_this.dimensions.scrollTop = $window.scrollTop();
			if ( _this.contextView ) {
				if ( _this.currentSelection.getLength() && !_this.mouse.selectingMode ) {
					_this.contextView.set();
				} else {
					_this.contextView.clear();
				}
			}
		},
		'blur': function() {
			_this.keyboard.keys.shift = false;
		}
	} );

	// Configuration
	this.mac = navigator.userAgent.match(/mac/i) ? true : false; // (yes it's evil, for keys only!)
	this.ie8 = $.browser.msie && $.browser.version === "8.0";

	// Initialization
	this.$input.focus();
	this.documentView.renderContent();
};

/* Methods */

ve.es.Surface.prototype.attachContextView = function( contextView ) {
	this.contextView = contextView;
};

ve.es.Surface.prototype.getContextView = function() {
	return this.contextView ;
};

ve.es.Surface.prototype.annotate = function( method, annotation ) {
	if ( method === 'toggle' ) {
		var annotations = this.getAnnotations();
		if ( ve.dm.DocumentNode.getIndexOfAnnotation( annotations.full, annotation ) !== -1 ) {
			method = 'clear';
		} else {
			method = 'set';
		}
	}
	if ( this.currentSelection.getLength() ) {
		var tx = this.model.getDocument().prepareContentAnnotation(
			this.currentSelection, method, annotation
		);
		this.model.transact( tx );
	} else {
		if ( method === 'set' ) {
			this.addInsertionAnnotation( annotation );
		} else if ( method === 'clear' ) {
			this.removeInsertionAnnotation( annotation );
		}
	}
};

ve.es.Surface.prototype.getAnnotations = function() {
	return this.currentSelection.getLength() ?
		this.model.getDocument().getAnnotationsFromRange( this.currentSelection ) :
		{
			'full': this.insertionAnnotations,
			'partial': [],
			'all': this.insertionAnnotations
		};
};

ve.es.Surface.prototype.emitCursor = function() {
	if ( this.emitCursorTimeout ) {
		clearTimeout( this.emitCursorTimeout );
	}
	var _this = this;
	this.emitCursorTimeout = setTimeout( function() {
		var	annotations = _this.getAnnotations(),
			nodes = [],
			model = _this.documentView.model;
		if ( _this.currentSelection.from === _this.currentSelection.to ) {
			nodes.push( model.getNodeFromOffset( _this.currentSelection.from ) );
		} else {
			var	startNode = model.getNodeFromOffset( _this.currentSelection.start ),
				endNode = model.getNodeFromOffset( _this.currentSelection.end );
			if ( startNode === endNode ) {
				nodes.push( startNode );
			} else {
				model.traverseLeafNodes( function( node ) {
					nodes.push( node );
					if( node === endNode ) {
						return false;
					}
				}, startNode );			
			}
		}
		_this.emit( 'cursor', annotations, nodes );
	}, 50 );
};

ve.es.Surface.prototype.getInsertionAnnotations = function() {
	return this.insertionAnnotations;
};

ve.es.Surface.prototype.addInsertionAnnotation = function( annotation ) {
	this.insertionAnnotations.push( annotation );
	this.emitCursor();
};

ve.es.Surface.prototype.loadInsertionAnnotations = function( annotation ) {
	this.insertionAnnotations =
		this.model.getDocument().getAnnotationsFromOffset( this.currentSelection.to - 1 );
	// Filter out annotations that aren't textStyles or links
	for ( var i = 0; i < this.insertionAnnotations.length; i++ ) {
		if ( !this.insertionAnnotations[i].type.match( /(textStyle\/|link\/)/ ) ) {
			this.insertionAnnotations.splice( i, 1 );
			i--;
		}
	}
	this.emitCursor();
};

ve.es.Surface.prototype.removeInsertionAnnotation = function( annotation ) {
	var index = ve.dm.DocumentNode.getIndexOfAnnotation( this.insertionAnnotations, annotation );
	if ( index !== -1 ) {
		this.insertionAnnotations.splice( index, 1 );
	}
	this.emitCursor();
};

ve.es.Surface.prototype.clearInsertionAnnotations = function() {
	this.insertionAnnotations = [];
	this.emitCursor();
};

ve.es.Surface.prototype.getModel = function() {
	return this.model;
};

ve.es.Surface.prototype.updateSelection = function( delay ) {
	var _this = this;
	function update() {
		if ( _this.currentSelection.getLength() ) {
			_this.clearInsertionAnnotations();
			_this.hideCursor();
			_this.documentView.drawSelection( _this.currentSelection );
		} else {
			_this.showCursor();
			_this.documentView.clearSelection( _this.currentSelection );
		}
		if ( _this.contextView ) {
			if ( _this.currentSelection.getLength() && !_this.mouse.selectingMode ) {
				_this.contextView.set();
			} else {
				_this.contextView.clear();
			}
		}
		_this.updateSelectionTimeout = undefined;
	}
	if ( delay ) {
		if ( this.updateSelectionTimeout !== undefined ) {
			return;
		}
		this.updateSelectionTimeout = setTimeout( update, delay );
	} else {
		update();
	}
};

ve.es.Surface.prototype.emitUpdate = function( delay ) {
	if ( delay ) {
		if ( this.emitUpdateTimeout !== undefined ) {
			return;
		}
		var _this = this;
		this.emitUpdateTimeout = setTimeout( function() {
			_this.emit( 'update' );	
			_this.emitUpdateTimeout = undefined;
		}, delay );
	} else {
		this.emit( 'update' );	
	}
};

ve.es.Surface.prototype.onMouseDown = function( e ) {
	// Only for left mouse button
	if ( e.which === 1 ) {
		var selection = this.currentSelection.clone(),
			offset = this.documentView.getOffsetFromEvent( e );
		// Single click
		if ( this.ie8 || e.originalEvent.detail === 1 ) {
			// @see {ve.es.Surface.prototype.onMouseMove}
			this.mouse.selectingMode = 1;

			if ( this.keyboard.keys.shift && offset !== selection.from ) {
				// Extend current or create new selection
				selection.to = offset;
			} else {
				selection.from = selection.to = offset;

				var	position = ve.Position.newFromEventPagePosition( e ),
					nodeView = this.documentView.getNodeFromOffset( offset, false );
				this.cursor.initialBias = position.left > nodeView.contentView.$.offset().left;
			}
		}
		// Double click
		else if ( e.originalEvent.detail === 2 ) {
			// @see {ve.es.Surface.prototype.onMouseMove}
			this.mouse.selectingMode = 2;
			
			var wordRange = this.model.getDocument().getWordBoundaries( offset );
			if( wordRange ) {
				selection = wordRange;
				this.mouse.selectedRange = selection.clone();
			}
		}
		// Triple click
		else if ( e.originalEvent.detail >= 3 ) {
			// @see {ve.es.Surface.prototype.onMouseMove}
			this.mouse.selectingMode = 3;

			var node = this.documentView.getNodeFromOffset( offset ),
				nodeOffset = this.documentView.getOffsetFromNode( node, false );

			selection.from = this.model.getDocument().getRelativeContentOffset( nodeOffset, 1 );
			selection.to = this.model.getDocument().getRelativeContentOffset(
				nodeOffset + node.getElementLength(), -1
			);
			this.mouse.selectedRange = selection.clone();
		}
	}
	
	var _this = this;
	
	function select() {
		if ( e.which === 1 ) {
			// Reset the initial left position
			_this.cursor.initialLeft = null;
			// Apply new selection
			_this.model.select( selection, true );
		}

		// If the inut isn't already focused, focus it and select it's contents
		if ( !_this.$input.is( ':focus' ) ) {
			_this.$input.focus().select();
		}
	}

	if ( this.ie8 ) {
		setTimeout( select, 0 );
	} else {
		select();
	}

	return false;
};

ve.es.Surface.prototype.onMouseMove = function( e ) {
	// Only with the left mouse button while in selecting mode
	if ( e.which === 1 && this.mouse.selectingMode ) {
		var selection = this.currentSelection.clone(),
			offset = this.documentView.getOffsetFromEvent( e );

		// Character selection
		if ( this.mouse.selectingMode === 1 ) {
			selection.to = offset;
		}
		// Word selection
		else if ( this.mouse.selectingMode === 2 ) {
			var wordRange = this.model.getDocument().getWordBoundaries( offset );
			if ( wordRange ) {
				if ( wordRange.to <= this.mouse.selectedRange.from ) {
					selection.from = wordRange.from;
					selection.to = this.mouse.selectedRange.to;
				} else {
					selection.from = this.mouse.selectedRange.from;
					selection.to = wordRange.to;
				}
			}
		}
		// Node selection
		else if ( this.mouse.selectingMode === 3 ) {
			// @see {ve.es.Surface.prototype.onMouseMove}
			this.mouse.selectingMode = 3;

			var nodeRange = this.documentView.getRangeFromNode(
				this.documentView.getNodeFromOffset( offset )
			);
			if ( nodeRange.to <= this.mouse.selectedRange.from ) {
				selection.from = this.model.getDocument().getRelativeContentOffset(
					nodeRange.from, 1
				);
				selection.to = this.mouse.selectedRange.to;
			} else {
				selection.from = this.mouse.selectedRange.from;
				selection.to = this.model.getDocument().getRelativeContentOffset(
					nodeRange.to, -1
				);
			}	
		}
		// Apply new selection
		this.model.select( selection, true );
	}
};

ve.es.Surface.prototype.onMouseUp = function( e ) {
	if ( e.which === 1 ) { // left mouse button 
		this.mouse.selectingMode = this.mouse.selectedRange = null;
		this.model.select( this.currentSelection, true );
		if ( this.contextView ) {
			// We have to manually call this because the selection will not have changed between the
			// most recent mousemove and this mouseup
			this.contextView.set();
		}
	}
};

ve.es.Surface.prototype.onCopy = function( e ) {
	// TODO: Keep a data copy around
	return true;
};

ve.es.Surface.prototype.onCut = function( e ) {
	var _this = this;
	setTimeout( function() {
		_this.handleDelete();
	}, 10 );
	return true;
};

ve.es.Surface.prototype.onPaste = function( e ) {
	// TODO: Check if the data copy is the same as what got pasted, and use that instead if so
	return true;
};

ve.es.Surface.prototype.onKeyDown = function( e ) {
	switch ( e.keyCode ) {
		// Tab
		case 9:
			if ( !e.metaKey && !e.ctrlKey && !e.altKey ) {
				this.$input.val( '\t' );
				this.handleInsert();
				e.preventDefault();
				return false;
			}
			return true;
		// Shift
		case 16:
			this.keyboard.keys.shift = true;
			this.keyboard.selecting = true;
			break;
		// Ctrl
		case 17:
			break;
		// Home
		case 36:
			this.moveCursor( 'left', 'line' );
			break;
		// End
		case 35:
			this.moveCursor( 'right', 'line' );
			break;
		// Left arrow
		case 37:
			if ( !this.mac ) {
				if ( e.ctrlKey ) {
					this.moveCursor( 'left', 'word' );
				} else {
					this.moveCursor( 'left', 'char' );
				}
			} else {
				if ( e.metaKey || e.ctrlKey ) {
					this.moveCursor( 'left', 'line' );
				} else  if ( e.altKey ) {
					this.moveCursor( 'left', 'word' );
				} else {
					this.moveCursor( 'left', 'char' );
				}
			}
			break;
		// Up arrow
		case 38:
			if ( !this.mac ) {
				if ( e.ctrlKey ) {
					this.moveCursor( 'up', 'unit' );
				} else {
					this.moveCursor( 'up', 'char' );
				}
			} else {
				if ( e.altKey ) {
					this.moveCursor( 'up', 'unit' );
				} else {
					this.moveCursor( 'up', 'char' );
				}
			}
			break;
		// Right arrow
		case 39:
			if ( !this.mac ) {
				if ( e.ctrlKey ) {
					this.moveCursor( 'right', 'word' );
				} else {
					this.moveCursor( 'right', 'char' );
				}
			} else {
				if ( e.metaKey || e.ctrlKey ) {
					this.moveCursor( 'right', 'line' );
				} else  if ( e.altKey ) {
					this.moveCursor( 'right', 'word' );
				} else {
					this.moveCursor( 'right', 'char' );
				}
			}
			break;
		// Down arrow
		case 40:
			if ( !this.mac ) {
				if ( e.ctrlKey ) {
					this.moveCursor( 'down', 'unit' );
				} else {
					this.moveCursor( 'down', 'char' );
				}
			} else {
				if ( e.altKey ) {
					this.moveCursor( 'down', 'unit' );
				} else {
					this.moveCursor( 'down', 'char' );
				}
			}
			break;
		// Backspace
		case 8:
			this.handleDelete( true );
			break;
		// Delete
		case 46:
			this.handleDelete();
			break;
		// Enter
		case 13:
			if ( this.keyboard.keys.shift ) {
				this.$input.val( '\n' );
				this.handleInsert();
				e.preventDefault();
				return false;
			}
			this.handleEnter();
			e.preventDefault();
			break;
		// Insert content (maybe)
		default:
			// Control/command + character combos
			if ( e.metaKey || e.ctrlKey ) {
				switch ( e.keyCode ) {
					// y (redo)
					case 89:
						this.model.redo();
						return false;
					// z (undo/redo)
					case 90:
						if ( this.keyboard.keys.shift ) {
							this.model.redo();
						} else {
							this.model.undo();
						}
						return false;
					// a (select all)
					case 65:
						this.model.select( new ve.Range(
							this.model.getDocument().getRelativeContentOffset( 0, 1 ),
							this.model.getDocument().getRelativeContentOffset(
								this.model.getDocument().getContentLength(), -1
							)
						), true );
						return false;
					// b (bold)
					case 66:
						this.annotate( 'toggle', {'type': 'textStyle/bold' } );
						return false;
					// i (italic)
					case 73:
						this.annotate( 'toggle', {'type': 'textStyle/italic' } );
						return false;
					// k (hyperlink)
					case 75:
						if ( this.currentSelection.getLength() ) {
							this.contextView.openInspector( 'link' );
						} else {
							var range = this.model.getDocument().getAnnotationBoundaries(
									this.currentSelection.from, { 'type': 'link/internal' }, true
								);
							if ( range ) {
								this.model.select( range );
								this.contextView.openInspector( 'link' );
							}
						}
						return false;
				}
			}
			// Regular text insertion
			this.handleInsert();
			break;
	}
	return true;
};

ve.es.Surface.prototype.onKeyUp = function( e ) {
	if ( e.keyCode === 16 ) {
		this.keyboard.keys.shift = false;
		if ( this.keyboard.selecting ) {
			this.keyboard.selecting = false;
		}
	}
};

ve.es.Surface.prototype.handleInsert = function() {
	var _this = this;
	if ( _this.keyboard.keydownTimeout ) {
		clearTimeout( _this.keyboard.keydownTimeout );
	}
	_this.keyboard.keydownTimeout = setTimeout( function () {
		_this.insertFromInput();
	}, 10 );
};

ve.es.Surface.prototype.handleDelete = function( backspace, isPartial ) {
	var selection = this.currentSelection.clone(),
		sourceOffset,
		targetOffset,
		sourceSplitableNode,
		targetSplitableNode,
		tx;
	if ( selection.from === selection.to ) {
		if ( backspace ) {
			sourceOffset = selection.to;
			targetOffset = this.model.getDocument().getRelativeContentOffset(
				sourceOffset,
				-1
			);
		} else {
			sourceOffset = this.model.getDocument().getRelativeContentOffset(
				selection.to,
				1
			);
			targetOffset = selection.to;
		}

		var	sourceNode = this.documentView.getNodeFromOffset( sourceOffset, false ),
			targetNode = this.documentView.getNodeFromOffset( targetOffset, false );
	
		if ( sourceNode.model.getElementType() === targetNode.model.getElementType() ) {
			sourceSplitableNode = ve.es.Node.getSplitableNode( sourceNode );
			targetSplitableNode = ve.es.Node.getSplitableNode( targetNode );
		}
		
		selection.from = selection.to = targetOffset;
		this.model.select( selection );
		
		if ( sourceNode === targetNode ||
			( typeof sourceSplitableNode !== 'undefined' &&
			sourceSplitableNode.getParent()  === targetSplitableNode.getParent() ) ) {
			tx = this.model.getDocument().prepareRemoval(
				new ve.Range( targetOffset, sourceOffset )
			);
			this.model.transact( tx, isPartial );
		} else {
			tx = this.model.getDocument().prepareInsertion(
				targetOffset, sourceNode.model.getContentData()
			);
			this.model.transact( tx, isPartial );
			
			var nodeToDelete = sourceNode;
			ve.Node.traverseUpstream( nodeToDelete, function( node ) {
				if ( node.getParent().children.length === 1 ) {
					nodeToDelete = node.getParent();
					return true;
				} else {
					return false;
				}
			} );
			var range = new ve.Range();
			range.from = this.documentView.getOffsetFromNode( nodeToDelete, false );
			range.to = range.from + nodeToDelete.getElementLength();
			tx = this.model.getDocument().prepareRemoval( range );
			this.model.transact( tx, isPartial );
		}
	} else {
		// selection removal
		tx = this.model.getDocument().prepareRemoval( selection );
		this.model.transact( tx, isPartial );
		selection.from = selection.to = selection.start;
		this.model.select( selection );
	}
};

ve.es.Surface.prototype.handleEnter = function() {
	var selection = this.currentSelection.clone(),
		tx;
	if ( selection.from !== selection.to ) {
		this.handleDelete( false, true );
	}
	var	node = this.documentView.getNodeFromOffset( selection.to, false ),
		nodeOffset = this.documentView.getOffsetFromNode( node, false );

	if (
		nodeOffset + node.getContentLength() + 1 === selection.to &&
		node ===  ve.es.Node.getSplitableNode( node )
	) {
		tx = this.documentView.model.prepareInsertion(
			nodeOffset + node.getElementLength(),
			[ { 'type': 'paragraph' }, { 'type': '/paragraph' } ]
		);
		this.model.transact( tx );
		selection.from = selection.to = nodeOffset + node.getElementLength() + 1;	
	} else {
		var	stack = [],
			splitable = false;

		ve.Node.traverseUpstream( node, function( node ) {
			var elementType = node.model.getElementType();
			if (
				splitable === true &&
				ve.es.DocumentNode.splitRules[ elementType ].children === true
			) {
				return false;
			}
			stack.splice(
				stack.length / 2,
				0,
				{ 'type': '/' + elementType },
				{
					'type': elementType,
					'attributes': ve.copyObject( node.model.element.attributes )
				}
			);
			splitable = ve.es.DocumentNode.splitRules[ elementType ].self;
			return true;
		} );
		tx = this.documentView.model.prepareInsertion( selection.to, stack );
		this.model.transact( tx );
		selection.from = selection.to =
			this.model.getDocument().getRelativeContentOffset( selection.to, 1 );
	}
	this.model.select( selection );
};

ve.es.Surface.prototype.insertFromInput = function() {
	var selection = this.currentSelection.clone(),
		val = this.$input.val();
	if ( val.length > 0 ) {
		// Check if there was any effective input
		var input = this.$input[0],
			// Internet Explorer
			range = document.selection && document.selection.createRange();
		if (
			// DOM 3.0
			( 'selectionStart' in input && input.selectionEnd - input.selectionStart ) ||
			// Internet Explorer
			( range && range.text.length )
		) {
			// The input is still selected, so the key must not have inserted anything
			return;
		}

		// Clear the value for more input
		this.$input.val( '' );

		// Prepare and process a transaction
		var tx;
		if ( selection.from != selection.to ) {
			tx = this.model.getDocument().prepareRemoval( selection );
			this.model.transact( tx, true );
			selection.from = selection.to =
				Math.min( selection.from, selection.to );
		}
		var data = val.split('');
		ve.dm.DocumentNode.addAnnotationsToData( data, this.getInsertionAnnotations() );
		tx = this.model.getDocument().prepareInsertion( selection.from, data );
		this.model.transact( tx );

		// Move the selection
		selection.from += val.length;
		selection.to += val.length;
		this.model.select( selection );
	}
};

/**
 * @param {String} direction up | down | left | right
 * @param {String} unit char | word | line | node | page
 */
ve.es.Surface.prototype.moveCursor = function( direction, unit ) {
	if ( direction !== 'up' && direction !== 'down' ) {
		this.cursor.initialLeft = null;
	}
	var selection = this.currentSelection.clone(),
		to,
		offset;
	switch ( direction ) {
		case 'left':
		case 'right':
			switch ( unit ) {
				case 'char':
				case 'word':
					if ( this.keyboard.keys.shift || selection.from === selection.to ) {
						offset = selection.to;
					} else {
						offset = direction === 'left' ? selection.start : selection.end;
					}
					to = this.model.getDocument().getRelativeContentOffset(
							offset,
							direction === 'left' ? -1 : 1
					);
					if ( unit === 'word' ) {
						var wordRange = this.model.getDocument().getWordBoundaries(
							direction === 'left' ? to : offset
						);
						if ( wordRange ) {
							to = direction === 'left' ? wordRange.start : wordRange.end;
						}
					}
					break;
				case 'line':
					offset = this.cursor.initialBias ?
						this.model.getDocument().getRelativeContentOffset(
							selection.to,
							-1) :
								selection.to;
					var range = this.documentView.getRenderedLineRangeFromOffset( offset );
					to = direction === 'left' ? range.start : range.end;
					break;
				default:
					throw new Error( 'unrecognized cursor movement unit' );
					break;
			}
			break;
		case 'up':
		case 'down':
			switch ( unit ) {
				case 'unit':
					var toNode = null;
					this.model.getDocument().traverseLeafNodes(
						function( node ) {
							var doNextChild = toNode === null;
							toNode = node;
							return doNextChild;
						},
						this.documentView.getNodeFromOffset( selection.to, false ).getModel(),
						direction === 'up' ? true : false
					);
					to = this.model.getDocument().getOffsetFromNode( toNode, false ) + 1;
					break;
				case 'char':
					/*
					 * Looks for the in-document character position that would match up with the
					 * same horizontal position - jumping a few pixels up/down at a time until we
					 * reach the next/previous line
					 */
					var position = this.documentView.getRenderedPositionFromOffset(
						selection.to,
						this.cursor.initialBias
					);
					
					if ( this.cursor.initialLeft === null ) {
						this.cursor.initialLeft = position.left;
					}
					var	fakePosition = new ve.Position( this.cursor.initialLeft, position.top ),
						i = 0,
						step = direction === 'up' ? -5 : 5,
						top = this.$.position().top;

					this.cursor.initialBias = position.left > this.documentView.getNodeFromOffset(
						selection.to, false
					).contentView.$.offset().left;

					do {
						i++;
						fakePosition.top += i * step;
						if ( fakePosition.top < top ) {
							break;
						} else if (
							fakePosition.top > top + this.dimensions.height +
								this.dimensions.scrollTop
						) {
							break;
						}
						fakePosition = this.documentView.getRenderedPositionFromOffset(
							this.documentView.getOffsetFromRenderedPosition( fakePosition ),
							this.cursor.initialBias
						);
						fakePosition.left = this.cursor.initialLeft;
					} while ( position.top === fakePosition.top );
					to = this.documentView.getOffsetFromRenderedPosition( fakePosition );
					break;
				default:
					throw new Error( 'unrecognized cursor movement unit' );
			}
			break;	
		default:
			throw new Error( 'unrecognized cursor direction' );
	}

	if( direction != 'up' && direction != 'down' ) {
		this.cursor.initialBias = direction === 'right' && unit === 'line' ? true : false;
	}

	if ( this.keyboard.keys.shift && selection.from !== to) {
		selection.to = to;
	} else {
		selection.from = selection.to = to;
	}
	this.model.select( selection, true );
};

/**
 * Shows the cursor in a new position.
 * 
 * @method
 * @param offset {Integer} Position to show the cursor at
 */
ve.es.Surface.prototype.showCursor = function() {	
	var $window = $( window ),
		position = this.documentView.getRenderedPositionFromOffset(
			this.currentSelection.to, this.cursor.initialBias
		);
	
	this.$cursor.css( {
		'left': position.left,
		'top': position.top,
		'height': position.bottom - position.top
	} ).show();
	this.$input.css({
		'top': position.top,
		'height': position.bottom - position.top
	});

	// Auto scroll to cursor
	var inputTop = this.$input.offset().top,
		inputBottom = inputTop + position.bottom - position.top;	
	if ( inputTop - this.dimensions.toolbarHeight < this.dimensions.scrollTop ) {
		$window.scrollTop( inputTop - this.dimensions.toolbarHeight );
	} else if ( inputBottom > ( this.dimensions.scrollTop + this.dimensions.height ) ) {
		$window.scrollTop( inputBottom - this.dimensions.height );
	}

	// cursor blinking
	if ( this.cursor.interval ) {
		clearInterval( this.cursor.interval );
	}

	var _this = this;
	this.cursor.interval = setInterval( function( surface ) {
		_this.$cursor.css( 'display', function( index, value ) {
			return value === 'block' ? 'none' : 'block';
		} );
	}, 500 );
};

/**
 * Hides the cursor.
 * 
 * @method
 */
ve.es.Surface.prototype.hideCursor = function() {
	if( this.cursor.interval ) {
		clearInterval( this.cursor.interval );
	}
	this.$cursor.hide();
};

/* Inheritance */

ve.extendClass( ve.es.Surface, ve.EventEmitter );
