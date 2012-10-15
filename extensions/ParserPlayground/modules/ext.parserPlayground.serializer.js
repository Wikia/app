/**
 * @param {ParserContext} context
 */
function MWTreeSerializer(context) {
	// whee
	this.context = context || {};
}


/**
 * Collapse a parse tree back to source, if possible.
 * Ideally should exactly match the original source;
 * at minimum the resulting source should parse into
 * a tree that's identical to the current one.
 *
 * @param {object} tree
 * @param {function(text, error)} callback
 */
MWTreeSerializer.prototype.treeToSource = function(tree, callback) {
	var self = this;
	var subParseArray = function(listOfTrees) {
		var str = '';
		$.each(listOfTrees, function(i, subtree) {
			self.treeToSource(subtree, function(substr, err) {
				if (substr) {
					str += substr;
				}
			});
		});
		return str;
	};
	var src;
	if (typeof tree === "string") {
		callback(tree);
		return;
	}
	switch (tree.type) {
		case 'page':
			src = subParseArray(tree.content);
			break;
		case 'para':
			// A single-line paragraph.
			src = subParseArray(tree.content) + '\n';
			break;
		case 'br':
			src = '\n';
			break;
		case 'text':
			// In the real world, there might be escaping.
			src = tree.text;
			break;
		case 'link':
			src = '[[';
			src += tree.target;
			if (tree.text) {
				src += '|';
				src += tree.text;
			}
			src += ']]';
			break;
		case 'h':
			var stub = '';
			for (var i = 0; i < tree.level; i++) {
				stub += '=';
			}
			src = stub + tree.text + stub + '\n';
			break;
		case 'ext':
			src = '<' + tree.name;
			if (tree.params) {
				for (var i = 0; i < tree.params.length; i++) {
					var param = tree.params[i];
					src += ' ';
					src += param.name + '=';
					if ('quote' in param) {
						src += param.quote;
					}
					src += param.text;
					if ('quote' in param) {
						src += param.quote;
					}
				}
			}
			if ('ws' in tree) {
				src += tree.ws;
			}
			if ('content' in tree) {
				src += '>';
				src += subParseArray(tree.content);
				src += '</' + tree.name + '>';
			} else {
				src += '/>';
			}
			break;
		case 'template':
			src = '{{' + tree.target;
			if (tree.params) {
				for (var i = 0; i < tree.params.length; i++) {
					var param = tree.params[i];
					src += '|';
					if ('name' in param) {
						src += param.name + '=';
					}
					src += subParseArray(param.content);
				}
			}
			src += '}}';
			break;
		case 'b':
			src = "'''" + tree.text + "'''";
			break;
		case 'i':
			src = "''" + tree.text + "''";
			break;
		case 'extlink':
			src = '[' + tree.target + ' ' + tree.text + ']';
			break;
		case 'comment':
			// @fixme validate that text doesn't contain '-->'
			src = '<!--' + tree.text + '-->';
			break;
                case 'ul':
                case 'ol':
                case 'dl':
			src = subParseArray(tree.content);
			break;
		case 'li':
		case 'dt':
		case 'dd':
			src = tree.listStyle.join('');
			src += subParseArray(tree.content) + '\n';
			break;
		default:
			callback(null, 'Unrecognized parse tree node');
			return;
	}
	if (src) {
		callback(src);
	} else {
		callback(null); // hmmmm
	}
};

if (typeof module == "object") {
	module.exports.MWTreeSerializer = MWTreeSerializer;
}
