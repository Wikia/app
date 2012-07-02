es.SurfaceView = function( $container, model ) {
	// Inheritance
	es.EventEmitter.call( this );

	// References for use in closures
	var	_this = this;
		
	// Properties
	this.model = model;
	this.documentView = new es.DocumentView( this.model.getDocument(), this );
	this.paste = {};
	this.$ = $container
		.addClass( 'es-surfaceView' )
		.append( this.documentView.$ );

	// Don't render table editing controls
	document.execCommand("enableInlineTableEditing", false, false);
	// Don't render controls to resize objects
	document.execCommand("enableObjectResizing", false, false);

	this.$.keydown( function(e) {
		return _this.onKeyDown( e );
	} );

	this.model.getDocument().on( 'update', function() {
		_this.emit( 'update' );
	} );

	this.documentView.renderContent();

	this.$.bind('cut copy', function(event) {
		var range = rangy.getSelection().getRangeAt(0);
		var key = range.toString().replace(/ /g,"");

		console.log(es.copyArray(_this.documentView.model.getData(_this.getSelection())));
		_this.paste[key] = es.copyArray(_this.documentView.model.getData(_this.getSelection()));
		
		if (event.type == 'cut') {
			event.preventDefault();
			console.log('need to tell the model to cut');
			var range = _this.getSelection();
			if ( range.start != range.end ) {
				var tx = _this.model.getDocument().prepareRemoval( range );
				_this.model.transact( tx );
			}
		}
	});
	this.$.bind('paste', function(event) {
		event.preventDefault();
		console.log(event);
		//console.log(event.originalEvent.clipboardData.getData('Text'));
		var key = event.originalEvent.clipboardData.getData('text/plain').replace(/( |\r\n|\n|\r)/gm,"");

		if (_this.paste[key]) {
			console.log(_this.paste[key]);
			var tx = _this.documentView.model.prepareInsertion( _this.getSelection().to, _this.paste[key]);
			_this.documentView.model.commit(tx);
		} else {
			console.log('copied from external source');
		}
	});
};


es.SurfaceView.prototype.onKeyDown = function( e ) {
	if ( e.which === 13 ) {
		e.preventDefault();
		var range = this.getSelection();
		if ( range.start === range.end ) {
			var tx = this.model.getDocument().prepareInsertion( range.start, [ { 'type': '/paragraph' }, { 'type': 'paragraph' } ]);
			this.model.transact( tx );
			this.showCursorAt( range.start + 2 );
		}
	} else if ( e.which === 8 ) {
		console.log("A");
		e.preventDefault();
		var range = this.getSelection();
		if ( range.start != range.end ) {
			var tx = this.model.getDocument().prepareRemoval( range );
			this.model.transact( tx );
		}
	}
};

es.SurfaceView.prototype.showCursorAt = function( offset ) {
	var $node = this.documentView.getNodeFromOffset( offset ).$;
	var current = [$node.contents(), 0];
	var stack = [current];
	var node;
	var localOffset;
	
	var index = 1 + this.documentView.getOffsetFromNode( $node.data('view') );
	
	if(offset === index) {
		//localOffset = 0;
		//node = current[0].eq(0)[0];
	}
	
	while ( stack.length > 0 ) {
		if ( current[1] >= current[0].length ) {
			stack.pop();
			current = stack[ stack.length - 1 ];
			continue;
		}
		var item = current[0][current[1]];
		var $item = current[0].eq( current[1] );
		
		if ( item.nodeType === 3 ) {
			var length = item.textContent.length;
			if ( offset >= index && offset <= index + length ) {
				node = item;
				localOffset = offset - index;
			} else {
				index += length;
			}
		} else if ( item.nodeType === 1 ) {
			if ( $( item ).attr('contentEditable') === "false" ) {
				index += 1;
			} else {
				stack.push( [$item.contents(), 0] );
				current[1]++;
				current = stack[stack.length-1];
				continue;
			}
		}
		current[1]++;
	}
	var range = document.createRange();
	range.collapsed = true;
	range.setStart(node, localOffset);

	var sel = window.getSelection();
	sel.removeAllRanges();
	sel.addRange(range);
	
	
};

es.SurfaceView.prototype.getOffset = function( localNode, localOffset ) {
	var $node = $( localNode );
	while( !$node.hasClass( 'ce-leafNode' ) ) {
		$node = $node.parent();
	}
	
	var current = [$node.contents(), 0];
	var stack = [current];
	
	var offset = 0;
	
	while ( stack.length > 0 ) {
		if ( current[1] >= current[0].length ) {
			stack.pop();
			current = stack[ stack.length - 1 ];
			continue;
		}
		var item = current[0][current[1]];
		var $item = current[0].eq( current[1] );
		
		if ( item.nodeType === 3 ) {
			if ( item === localNode ) {
				offset += localOffset;
				break;
			} else {
				offset += item.textContent.length;
			}
		} else if ( item.nodeType === 1 ) {
			if ( $( item ).attr('contentEditable') === "false" ) {
				offset += 1;
			} else {
				stack.push( [$item.contents(), 0] );
				current[1]++;
				current = stack[stack.length-1];
				continue;
			}
		}
		current[1]++;
	}

	return this.documentView.getOffsetFromNode( $node.data('view') ) + 1 + offset;
}

es.SurfaceView.prototype.getSelection = function() {
	var selection = rangy.getSelection();
	
	if ( selection.anchorNode === selection.focusNode && selection.anchorOffset === selection.focusOffset ) {
		// only one offset
		var offset = this.getOffset( selection.anchorNode, selection.anchorOffset );
		return new es.Range( offset, offset );
	} else {
		// two offsets
		var offset1 = this.getOffset( selection.anchorNode, selection.anchorOffset );
		var offset2 = this.getOffset( selection.focusNode, selection.focusOffset );
		return new es.Range( offset1, offset2 );
	}
};

/* Inheritance */

es.extendClass( es.SurfaceView, es.EventEmitter );