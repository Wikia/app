/**
 * @param {ParserContext} context
 */
function MWTreeRenderer(env) {
	// whee
	this.env = env || {};
}

/**
 * @param {object} tree
 * @param {function(domnode, error)} callback
 * @param {HashMap} inspectorMap
 */
MWTreeRenderer.prototype.treeToHtml = function(tree, callback, inspectorMap) {
	var self = this;
	var subParseArray = function(listOfTrees, node) {
		$.each(listOfTrees, function(i, subtree) {
			self.treeToHtml(subtree, function(subnode, err) {
				if (subnode) {
					node.append(subnode);
				}
			}, inspectorMap);
		});
	};
	var extensionAttribute = function(node, name) {
		var lname = name.toLowerCase();
		var match = null;
		$.each(node.params, function(i, param) {
			if (param.name.toLowerCase() == lname) {
				match = param;
			}
		});
		return match ? match.text : null;
	}
	var node;
	if (typeof tree == "string") {
		// hack
		tree = {
			type: 'text',
			text: tree
		}
	}
	switch (tree.type) {
		case 'page':
			// A sequence of block-level elements...
			var page = $('<div class="parseNode"></div>');
			subParseArray(tree.content, page);
			/*
			if (self.context.refs) {
				// We're at the end; drop all the remaining refs!
				subParseArray([{
					type: 'ext',
					name: 'references'
				}], page);
			}
			*/
			node = page[0];
			break;
		case 'para':
			// A single-line paragraph.
			var para = $('<p class="parseNode"></p>');
			subParseArray(tree.content, para);
			node = para[0];
			break;
		case 'break':
			// Just a stub in the parse tree.
			break;
		case 'text':
			// hack hack
			node = document.createTextNode(tree.text);
			break;
		case 'link':
			var link = $('<a class="parseNode"></a>');
			link.text(tree.text || tree.target);
			link.attr('href', '/wiki/' + tree.target); // hack
			node = link[0];
			break;
		case 'extlink':
			var link = $('<a class="parseNode"></a>');
			link.text(tree.text || tree.target); // fixme? #d links, freelinks etc
			link.attr('href', tree.target); // hack: validate etc
			node = link[0];
			break;
		case 'h':
			var h = $('<h' + tree.level + ' class="parseNode"></h' + tree.level + '>').text(tree.text);
			node = h[0];
			break;
		case 'b':
			var h = $('<b class="parseNode"></b>').text(tree.text); // hack -- use content[]
			node = h[0];
			break;
		case 'i':
			var h = $('<i class="parseNode"></i>').text(tree.text); // hack -- use content[]
			node = h[0];
			break;
		case 'template':
			var t = $('<span class="parseNode template"></span>').text('{{' + tree.target);
			if ('params' in tree) {
				$.each(tree.params, function(i, param) {
					var str;
					if ('name' in param) {
						str = param.name + '=';
					} else {
						str = '';
					}
					var p = $('<span></span>').text('|' + str);
					if ('content' in param && param.content) {
						subParseArray(param.content, p);
					}
					t.append(p);
				});
			}
			t.append('}}');
			node = t[0];
			break;
		case 'placeholder':
			if ('content' in tree) {
				var $place = $('<span>'); // hmmmm
				subParseArray(tree.content, $place);
				node = $place[0];
			}
			break;
		case 'span':
		case 'ol':
		case 'ul':
		case 'dl':
		case 'dt':
		case 'dd':
		case 'li':
		case 'table':
		case 'tableRow':
		case 'tableCaption':
		case 'tableCell':
		case 'tableHeader':
			var $span = $('<' + tree.type + '>');
			if ('attrs' in tree) {
				$.map(tree.attrs, function(val, key) {
					$span.attr(key, val); // @fixme safety!
				});
			}
			if ('content' in tree) {
				subParseArray(tree.content, $span);
			}
			node = $span[0];
			break;
		case 'hashlink':
			var $a = $('<a>');
			$a.attr('href', '#' + tree.target);
			subParseArray(tree.content, $a);
			node = $a[0];
			break;
		case 'ext':
			var hook = this.env.getTagHook(tree.name);
			if (!hook) {
				console.log('kabooom! no ext ' + tree.name)
			}
			var transformed = hook.execute(tree);
			var $ext = $('<span>'); // hmmmm
			subParseArray([transformed], $ext);
			node = $ext[0];
			break;
		case 'comment':
			var h = $('<span class="parseNode comment"></span>').text('<!--' + tree.text + '-->');
			node = h[0];
			break;
		default:
			callback(null, 'Unrecognized parse tree node');
			return;
	}
	if (node) {
		if (node.nodeType == 1) {
			$(node).data('parseNode', tree); // assign the node for the tree inspector
			if (inspectorMap) {
				inspectorMap.put(tree, node); // store for reverse lookup
			}
		}
		callback(node);
	} else {
		callback(null); // hmmmm
	}
};


if (typeof module == "object") {
	module.exports.MWTreeRenderer = MWTreeRenderer;
}
