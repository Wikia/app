/**
 * Serializes a WikiDom plain object into an HTML string.
 * 
 * @class
 * @constructor
 * @param {Object} options List of options for serialization
 */
ve.dm.HtmlSerializer = function( options ) {
	this.options = $.extend( {
		// defaults
	}, options || {} );
};

/* Static Methods */

/**
 * Get a serialized version of data.
 * 
 * @static
 * @method
 * @param {Object} data Data to serialize
 * @param {Object} options Options to use, @see {ve.dm.WikitextSerializer} for details
 * @returns {String} Serialized version of data
 */
ve.dm.HtmlSerializer.stringify = function( data, options ) {
	return ( new ve.dm.HtmlSerializer( options ) ).document( data );
};

ve.dm.HtmlSerializer.getHtmlAttributes = function( attributes ) {
	var htmlAttributes = {},
		count = 0;
	for ( var key in attributes ) {
		if ( key.indexOf( 'html/' ) === 0 ) {
			htmlAttributes[key.substr( 5 )] = attributes[key];
			count++;
		}
	}
	return count ? htmlAttributes : null;
};

/* Methods */

ve.dm.HtmlSerializer.prototype.document = function( node, rawFirstParagraph ) {
	var lines = [];
	for ( var i = 0, length = node.children.length; i < length; i++ ) {
		var childNode = node.children[i];
		if ( childNode.type in this ) {
			// Special case for paragraphs which have particular wrapping needs
			if ( childNode.type === 'paragraph' ) {
				lines.push( this.paragraph( childNode, rawFirstParagraph && i === 0 ) );
			} else {
				lines.push( this[childNode.type].call( this, childNode ) );
			}
		}
	}
	return lines.join( '\n' );
};

ve.dm.HtmlSerializer.prototype.comment = function( node ) {
	return '<!--(' + node.text + ')-->';
};

ve.dm.HtmlSerializer.prototype.pre = function( node ) {
	return ve.Html.makeTag(
		'pre', {}, this.content( node.content, true )
	);
};

ve.dm.HtmlSerializer.prototype.horizontalRule = function( node ) {
	return ve.Html.makeTag( 'hr', {}, false );
};

ve.dm.HtmlSerializer.prototype.heading = function( node ) {
	return ve.Html.makeTag(
		'h' + node.attributes.level, {}, this.content( node.content )
	);
};

ve.dm.HtmlSerializer.prototype.paragraph = function( node, raw ) {
	if ( raw ) {
		return this.content( node.content );
	} else {
		return ve.Html.makeTag( 'p', {}, this.content( node.content ) );
	}
};

ve.dm.HtmlSerializer.prototype.list = function( node ) {
	var out = [],    // List of list nodes
		bstack = [], // Bullet stack, previous element's listStyles
		bnext  = [], // Next element's listStyles
		closeTags  = []; // Stack of close tags for currently active lists

	function commonPrefixLength( x, y ) {
		var minLength = Math.min(x.length, y.length);
		for(var i = 0; i < minLength; i++) {
			if (x[i] !== y[i]) {
				// Both description and term are
				// inside dls, so consider them equivalent here.
				var diffs =  [x[i], y[i]].sort();
				if (diffs[0] !== 'description' &&
						diffs[1] !== 'term' ) {
							break;
						}
			}
		}
		return i;
	}

	function popTags( n ) {
		for (var i = 0; i < n; i++ ) {
			out.push(closeTags.pop());
		}
	}

	function openLists( bs, bn, attribs ) {
		var prefix = commonPrefixLength (bs, bn);
		// pop close tags from stack
		popTags(closeTags.length - prefix);
		for(var i = prefix; i < bn.length; i++) {
			var c = bn[i];
			switch (c) {
				case 'bullet':
					out.push(ve.Html.makeOpeningTag('ul', attribs));
					closeTags.push(ve.Html.makeClosingTag('ul'));
					break;
				case 'number':
					out.push(ve.Html.makeOpeningTag('ol', attribs));
					closeTags.push(ve.Html.makeClosingTag('ol'));
					break;
				case 'term':
				case 'description':
					out.push(ve.Html.makeOpeningTag('dl', attribs));
					closeTags.push(ve.Html.makeClosingTag('dl'));
					break;
				default:
					throw("Unknown node prefix " + c);
			}
		}
	}

	for (var i = 0, length = node.children.length; i < length; i++) {
		var e = node.children[i];
		bnext = e.attributes.styles;
		delete e.attributes.styles;
		openLists( bstack, bnext, e.attributes );
		var tag;
		switch(bnext[bnext.length - 1]) {
			case 'term':
				tag = 'dt'; break;
			case 'description':
				tag = 'dd'; break;
			default:
				tag = 'li'; break;
		}
		out.push( ve.Html.makeTag(tag, e.attributes, this.document( e ) ) );
		bstack = bnext;
	}
	popTags(closeTags.length);
	return out.join("\n");
};

ve.dm.HtmlSerializer.prototype.table = function( node ) {
	var lines = [],
		attributes = ve.dm.HtmlSerializer.getHtmlAttributes( node.attributes );
	lines.push( ve.Html.makeOpeningTag( 'table', attributes ) );
	for ( var i = 0, length = node.children.length; i < length; i++ ) {
		var child = node.children[i];
		lines.push( this[child.type]( child ) );
	}
	lines.push( ve.Html.makeClosingTag( 'table' ) );
	return lines.join( '\n' );
};

ve.dm.HtmlSerializer.prototype.tableRow = function( node ) {
	var lines = [],
		attributes = ve.dm.HtmlSerializer.getHtmlAttributes( node.attributes );
	lines.push( ve.Html.makeOpeningTag( 'tr', attributes ) );
	for ( var i = 0, length = node.children.length; i < length; i++ ) {
		lines.push( this.tableCell( node.children[i] ) );
	}
	lines.push( ve.Html.makeClosingTag( 'tr' ) );
	return lines.join( '\n' );
};

ve.dm.HtmlSerializer.prototype.tableCell = function( node ) {
	var symbolTable = {
			'tableHeading': 'th',
			'tableCell': 'td'
		},
		attributes = ve.dm.HtmlSerializer.getHtmlAttributes( node.attributes );
	return ve.Html.makeTag( symbolTable[node.type], attributes, this.document( node, true ) );
};

ve.dm.HtmlSerializer.prototype.tableCaption = function( node ) {
	attributes = ve.dm.HtmlSerializer.getHtmlAttributes( node.attributes );
	return ve.Html.makeTag( 'caption', attributes, this.content( node.content ) );
};

ve.dm.HtmlSerializer.prototype.transclusion = function( node ) {
	var title = [];
	if ( node.namespace !== 'Main' ) {
		title.push( node.namespace );
	}
	title.push( node.title );
	title = title.join( ':' );
	return ve.Html.makeTag( 'a', { 'href': '/wiki/' + title }, title );
};

ve.dm.HtmlSerializer.prototype.parameter = function( node ) {
	return '{{{' + node.name + '}}}';
};

ve.dm.HtmlSerializer.prototype.content = function( node ) {
	if ( 'annotations' in node && node.annotations.length ) {
		var annotationSerializer = new ve.dm.AnnotationSerializer(),
			tagTable = {
				'textStyle/bold': 'b',
				'textStyle/italic': 'i',
				'textStyle/strong': 'strong',
				'textStyle/emphasize': 'em',
				'textStyle/big': 'big',
				'textStyle/small': 'small',
				'textStyle/superScript': 'sup',
				'textStyle/subScript': 'sub'
			};
		for ( var i = 0, length = node.annotations.length; i < length; i++ ) {
			var annotation = node.annotations[i];
			if ( annotation.type in tagTable ) {
				annotationSerializer.addTags( annotation.range, tagTable[annotation.type] );
			} else {
				switch ( annotation.type ) {
					case 'link/external':
						annotationSerializer.addTags(
							annotation.range, 'a', { 'href': annotation.data.url }
						);
						break;
					case 'link/internal':
						annotationSerializer.addTags(
							annotation.range, 'a', { 'href': '/wiki/' + annotation.data.title }
						);
						break;
					case 'object/template':
					case 'object/hook':
						annotationSerializer.add( annotation.range, annotation.data.html, '' );
						break;
				}
			}
		}
		return annotationSerializer.render( node.text );
	} else {
		return node.text;
	}
};
