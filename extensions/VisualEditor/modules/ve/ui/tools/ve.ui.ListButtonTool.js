/**
 * Creates an ve.ui.ListButtonTool object.
 * 
 * @class
 * @constructor
 * @extends {ve.ui.ButtonTool}
 * @param {ve.ui.Toolbar} toolbar
 * @param {String} name
 */
 ve.ui.ListButtonTool = function( toolbar, name, title, data ) {
	// Inheritance
	ve.ui.ButtonTool.call( this, toolbar, name, title );

	// Properties
	this.data = data;
	this.nodes = [];
};

/* Methods */

ve.ui.ListButtonTool.prototype.list = function( nodes, style ) {
	var	surface = this.toolbar.surfaceView,
		selection = surface.currentSelection.clone(),
		stack = [],
		stacks = [],
		listItems = [],
		parent,
		styles,
		insertAt,
		removeLength,
		data,
		tx,
		i,
		j;

	for( i = 0; i < nodes.length; i++ ) {
		parent = nodes[i].getParent();
		if ( parent.getElementType() === 'listItem' ) {
			if ( stack.length > 0 ) {
				stacks.push( stack );
				stack = [];
			}
			listItems.push( parent );
		} else {
			if( stack.length > 0 ) {
				if ( parent === stack[stack.length - 1].getParent() ) {
					stack.push( nodes[i] );
				} else {
					stacks.push( stack );
					stack = [ nodes[i] ];
				}
			} else {
				stack.push( nodes[i] );
			}
		}
	}
	if( stack.length > 0 ) {
		stacks.push( stack );
	}

	if ( stacks.length > 0 ) {
		if ( selection.from === selection.to ) {
			selection.from += 2;
			selection.to += 2;
		} else {
			if ( nodes[0].getParent().getElementType() != 'listItem' ) {
				if ( selection.from < selection.to ) {
					selection.from += 2;
				} else {
					selection.to += 2;
				}
			}
			if ( selection.from < selection.to ) {
				selection.to += (stacks.length * 2) + (nodes.length - listItems.length - 1) * 2;
			} else {
				selection.from += (stacks.length * 2) + (nodes.length - listItems.length - 1) * 2;
			}
		}
	}

	for( i = 0; i < listItems.length; i++ ) {
		styles = listItems[i].getElementAttribute( 'styles' );
		if ( styles[styles.length - 1] !== style ) {
			styles.splice( styles.length - 1, 1, style );
			tx = surface.model.getDocument().prepareElementAttributeChange(
				surface.documentView.model.getOffsetFromNode( listItems[i], false ),
				'set',
				'styles',
				styles
			);
			surface.model.transact( tx );
		}
	}

	for( i = 0; i < stacks.length; i++ ) {
		removeLength = 0;
		insertAt = surface.documentView.model.getOffsetFromNode( stacks[i][0], false );

		data = [ { 'type': 'list' } ];
		for( j = 0; j < stacks[i].length; j++ ) {
			removeLength += stacks[i][j].getElementLength();

			data = data
				.concat( [ {
					'type': 'listItem',
					'attributes' : { 'styles': [ this.name ] }
				} ] )
				//.concat( stacks[i][j].getElementData() )
				.concat( [ { 'type': 'paragraph' } ] )
				.concat( stacks[i][j].getContentData() )
				.concat( [ { 'type': '/paragraph' } ] )
				.concat( [ { 'type': '/listItem' } ] );
		}
		data = data.concat( [ { 'type': '/list' } ] );

		tx = surface.model.getDocument().prepareInsertion( insertAt, data );
		surface.model.transact( tx );

		tx = surface.model.getDocument().prepareRemoval(
			new ve.Range( insertAt + data.length, insertAt + removeLength + data.length )
		);
		surface.model.transact( tx );

	}

	surface.model.select( selection, true );
	surface.emitCursor();
};

ve.ui.ListButtonTool.prototype.unlist = function( nodes ) {
	var	listItems = [],
		listItem,
		i;

	for( i = 0; i < nodes.length; i++ ) {
		listItem = nodes[i].getParent();
		if ( listItems.length > 0 ) {
			if (listItem != listItems[listItems.length - 1]) {
				listItems.push( listItem );
			}
		} else {
			listItems.push( listItem );
		}
	}

	var	stacks = [],
		stack = {
			first: false,
			last: false,
			nodes: [],
			offset: 0,
			length: 0
		},
		surface = this.toolbar.surfaceView,
		selection = surface.currentSelection.clone(),
		from = 0,
		to = 0;

	for( i = 0; i < listItems.length; i++ ) {
		if( stack.nodes.length > 0 ) {
			if ( stack.nodes[stack.nodes.length - 1].getParent() != listItems[i].getParent() ) {
				stacks.push( stack );
				stack = {
					first: false,
					last: false,
					nodes: [],
					offset: 0,
					length: 0
				};
			}
		}
		if ( listItems[i].getParent().indexOf( listItems[i] ) === 0 ) {
			stack.first = true;
		}
		if ( listItems[i].getParent().indexOf( listItems[i] ) === listItems[i].getParent().children.length - 1 ) {
			stack.last = true;
		}
		if( stack.nodes.length === 0 ){
			stack.offset = surface.documentView.model.getOffsetFromNode(listItems[i], false);
		}
		stack.length += listItems[i].getElementLength();
		stack.nodes.push( listItems[i] );
	}
	if( stack.nodes.length > 0 ) {
		stacks.push(stack);
	}

	var	tx,
		j,
		extra,
		data;

	for( i = stacks.length - 1; i >= 0; i-- ) {
		stack = stacks[i];

		data = [];
		for( j = 0; j < stack.nodes.length; j++ ) {
			data = data.concat( stack.nodes[j].getContentData() );
		}

		if ( stack.first === true && stack.last === true ) {
			tx = surface.model.getDocument().prepareRemoval(
				new ve.Range( stack.offset - 1 /* list */, stack.offset + stack.length + 1 /* /list */ )
			);
			surface.model.transact( tx );
			tx = surface.model.getDocument().prepareInsertion( stack.offset - 1, data );
			surface.model.transact( tx );
			from = -2;
			to += -(stack.nodes.length * 2);
		} else  if ( stack.first === true && stack.last === false ) {
			tx = surface.model.getDocument().prepareRemoval(
				new ve.Range( stack.offset, stack.offset + stack.length )
			);
			surface.model.transact( tx );
			tx = surface.model.getDocument().prepareInsertion( stack.offset - 1, data );
			surface.model.transact( tx );
			from = -2;
			to += -(stack.nodes.length * 2);
		} else  if ( stack.first === false && stack.last === true ) {
			tx = surface.model.getDocument().prepareRemoval(
				new ve.Range( stack.offset, stack.offset + stack.length )
			);
			surface.model.transact( tx );
			tx = surface.model.getDocument().prepareInsertion( stack.offset + 1, data );
			surface.model.transact( tx );
			to += -(stack.nodes.length * 2);
			to += 2;
		} else  if ( stack.first === false && stack.last === false ) {
			var parent = stack.nodes[0].getParent();
			var parentOffset = surface.documentView.model.getOffsetFromNode( parent, false );
			var parentLength = parent.getElementLength();
			
			tx = surface.model.getDocument().prepareRemoval(
				new ve.Range( stack.offset, stack.offset + stack.length )
			);
			surface.model.transact( tx );

			var remainingRange = new ve.Range( stack.offset, parentOffset + parentLength - stack.length - 1 );
			var remainingData = surface.model.getDocument().getData( remainingRange );

			tx = surface.model.getDocument().prepareRemoval( remainingRange );
			surface.model.transact( tx );

			tx = surface.model.getDocument().prepareInsertion(
				stack.offset + 1,
				[ { 'type': 'list' } ].concat( remainingData ).concat( [ { 'type': '/list' } ] )
			);
			surface.model.transact( tx );

			tx = surface.model.getDocument().prepareInsertion( stack.offset + 1, data );
			surface.model.transact( tx );
			to += -(stack.nodes.length * 2);
			to += 2;
		}
	}
	if ( selection.from === selection.to ) {
		selection.from += from;
		selection.to += from;
	} else {
		if ( selection.to > selection.from ) {
			selection.from += from;
			selection.to += to;
		} else {
			selection.to += from;
			selection.from += to;
		}
	}
	surface.model.select( selection, true );
	surface.emitCursor();
};

ve.ui.ListButtonTool.prototype.onClick = function() {
	this.toolbar.surfaceView.model.breakpoint();
	if ( !this.$.hasClass( 'es-toolbarButtonTool-down' ) ) {
		this.list( this.nodes, this.name );
	} else {
		this.unlist( this.nodes );
	}
	this.toolbar.surfaceView.model.breakpoint();
};

ve.ui.ListButtonTool.prototype.updateState = function( annotations, nodes ) {
	function areListItemsOfStyle( nodes, style ) {
		var parent, styles;
		for( var i = 0; i < nodes.length; i++ ) {
			parent = nodes[i].getParent();
			if ( parent.getElementType() !== 'listItem' ) {
				return false;
			}
			styles = parent.getElementAttribute( 'styles' );
			if ( styles[ styles.length - 1] !== style ) {
				return false;
			}
		}
		return true;
	}

	this.nodes = nodes;
	if ( areListItemsOfStyle( this.nodes, this.name ) ) {
		this.$.addClass( 'es-toolbarButtonTool-down' );
	} else {
		this.$.removeClass( 'es-toolbarButtonTool-down' );
	}
};

/* Registration */

ve.ui.Tool.tools.number = {
	'constructor': ve.ui.ListButtonTool,
	'name': 'number',
	'title': 'Numbered list'
};

ve.ui.Tool.tools.bullet = {
	'constructor': ve.ui.ListButtonTool,
	'name': 'bullet',
	'title': 'Bulleted list'
};

/* Inheritance */

ve.extendClass( ve.ui.ListButtonTool, ve.ui.ButtonTool );
