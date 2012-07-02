/**
 * Node-tree display widget for XML and JSON-style data
 * Helper bits for ParserPlayground parser + editor experiments
 *
 * (c) 2011 Brion Vibber <brion @ wikimedia.org>
 */

(function(mw, $) {


function htmlEscape(str) {
	return mw.html.escape( str );
}

/**
 * Render an XML tree into this thingy.
 * @param {DOMNode} node
 * @param {jQuery} dest a list object!
 * @param {function} walkCallback (optional)
 */
function renderXmlTree(node, dest, walkCallback) {
	if (node.nodeType == Node.ELEMENT_NODE) {
		var base = '<span class="el">' + htmlEscape(node.nodeName) + '</span>',
			str = '&lt;' + base,
			closer;
		$.each(node.attributes, function(i, attr) {
			str += ' ' + htmlEscape(attr.nodeName) + '=<span class="attr">"' + htmlEscape(htmlEscape(attr.nodeValue)) + '"</span>';
		});
		if (node.childNodes.length == 0) {
			str += ' /&gt;';
			dest.append('<li>' + str + '</li>');
		} else {
			str += '&gt;';
			closer = '&lt;/' + base + '&gt;';
			var chunk = $('<li>' +
						  '<div class="mw-pp-node">' + str + '</div>' +
						  '<ul></ul>' +
						  '<div class="mw-pp-node">' + closer + '</div>' +
						  '</li>');
			var sublist = chunk.find('ul');
			dest.append(chunk);
			$.each(node.childNodes, function(i, child) {
				renderXmlTree(child, sublist);
			});
		}
	} else if (node.nodeType == Node.TEXT_NODE) {
		dest.append($('<li></li>').text(node.textContent));
	}
}

/**
 * Render a JSON tree into this thingy.
 * @param {mixed} node
 * @param {jQuery} dest a list object!
 * @param {function} walkCallback (optional)
 */
function renderJsonTree(node, dest, walkCallback) {
	var type = (typeof node);
	var chunk, item, sublist;
	if (type == 'object' && node === null) {
		dest.append('null');
	} else if (type == 'object' && node instanceof Array) {
		chunk = $('<div>' +
				  '<span class="mw-pp-node">[</span>' +
				  '<ul></ul>' +
				  '<span class="mw-pp-node">]</span>' +
				  '</div>');
		sublist = chunk.find('ul');
		$.each(node, function(i, val) {
			item = $('<li></li>');
			renderJsonTree(val, item, walkCallback);
			sublist.append(item);
		});
		dest.append(chunk);
	} else if (type == 'object') {
		chunk = $('<div class="parseNode">' +
				  '<span class="mw-pp-node">{</span>' +
				  '<ul></ul>' +
				  '<span class="mw-pp-node">}</span>' +
				  '</div>');
		chunk.data('parseNode', node); // assign the node for the tree inspector
		if (walkCallback) {
			// Let caller associate source & display nodes
			walkCallback( node, chunk[0] );
		}
		sublist = chunk.find('ul'); // hack
		$.each(node, function(key, val) {
			var item = $('<li><span class="el">' + htmlEscape('' + key) + '</span>:&nbsp;</li>');
			renderJsonTree(val, item, walkCallback);
			sublist.append(item);
		});
		dest.append(chunk);
	} else if (type == 'string') {
		dest.append(htmlEscape(JSON.stringify(node))); // easy way to escape :)
	} else {
		dest.append(htmlEscape('' + node));
	}
}

/**
 * Render a JSON or XML tree into this thingy.
 * @param {mixed} node
 * @param {jQuery} dest a list object!
 * @param {function} walkCallback (optional)
 */
var renderTree = function(node, dest, walkCallback) {
	var render;
	if (node instanceof Node) {
		render = renderXmlTree;
	} else {
		render = renderJsonTree;
	}
	render(node, dest, walkCallback);
}

$.fn.nodeTree = function( data, walkCallback ) {
	var target = $('<ul class="mw-nodetree"><li></li></ul>').appendTo( this );
	renderTree( data, target.find('li'), walkCallback );

	// Chain out!
	return this;
};

})(mediaWiki, jQuery);
