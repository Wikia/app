var apiCallers = {};
var apiCache = {};

function callApi(params, callback) {
	var api = wgScriptPath + '/api' + wgScriptExtension;
	var key = JSON.stringify(params);
	if (key in apiCallers && apiCallers[key]) {
		apiCallers[key].push(callback);
	} else if (key in apiCache) {
		callback(apiCache[key] && apiCache[key]);
	} else {
		apiCallers[key] = [callback];
		$.ajax({
			url: api,
			data: params,
			type: 'POST',
			dataType: 'json',
			success: function(data, xhr) {
				var callbacks = apiCallers[key];
				apiCallers[key] = null;
				apiCache[key] = data;
				$.each(callbacks, function(i, aCallback) {
					aCallback(data);
				});
			}
		});
	}
}

/**
 * Stub wrapper for using MediaWiki's parser via API
 */
function MediaWikiParser(context) {
	this.context = context;
}

/**
 * Run wiki text through the preprocessor to produce a preprocessor parse tree
 * (XML tree, not JSON).
 *
 * @param {string} text
 * @param {function(tree, error)} callback
 */
MediaWikiParser.prototype.parseToTree = function(text, callback) {
	callApi({
		action: 'expandtemplates', // not really what we want, but it'll do
		title: wgPageName,
		text: text,
		generatexml: '1',
		format: 'json'
	}, function(data, xhr) {
		if (typeof data.parsetree['*'] === 'string') {
			var parser = new DOMParser();
			var dom = parser.parseFromString(data.parsetree['*'], 'text/xml');
			callback(dom.documentElement);
		} else {
			alert('Failed to parse!');
		}
	});
};

/**
 * @param {object} tree
 * @param {function(tree, error)} callback
 */
MediaWikiParser.prototype.expandTree = function(tree, callback) {
	// no-op!
	callback(tree, null);
};

/**
 * Run a preprocessor XML parse tree through the final parser.
 * Since we can't actually ship the XML to MediaWiki, we'll reassemble it
 * and send the text. :P
 *
 * Currently we are not able to map preprocessor nodes to output DOM nodes,
 * so the inspector mode won't work.
 *
 * @param {Node} tree
 * @param {function(domnode, error)} callback
 * @param {HashMap} inspectorMap
 *
 * @fixme use context object for page title
 */
MediaWikiParser.prototype.treeToHtml = function(tree, callback, inspectorMap) {
	var self = this;
	self.treeToSource(tree, function(src, err) {
		if (err) {
			return callback(src, err);
		}
		callApi({
			action: 'parse',
			title: wgPageName,
			text: src,
			prop: 'text',
			pst: 1,
			format: 'json'
		}, function(data, xhr) {
			if (typeof data.parse.text['*'] === 'string') {
				var html = data.parse.text['*'];
				var parsed = $('<div>' + html + '</div>')[0];
				callback(parsed, null);
			} else {
				callback(null, 'Failed to parse!');
			}
		});
	});
};


/**
 * Collapse a parse tree back to source, if possible.
 * Ideally should exactly match the original source;
 * at minimum the resulting source should parse into
 * a tree that's identical to the current one.
 *
 * @param {Node} tree
 * @param {function(text, error)} callback
 */
MediaWikiParser.prototype.treeToSource = function(tree, callback) {
	// I forget if this actually works, but let's pretend for now!
	// looks like at least the heads of refs, and templates, need some more tweaking. but close :D
	//var text = $(tree).text();
	//callback(text, null);

	var collapse, collapseList, collapseChildren;
	collapseList = function(nodes, sep) {
		sep = sep || '';
		var list = $.map(nodes, function(node, i) {
			return collapse(node);
		});
		return list.join(sep);
	};
	collapseChildren = function(nodes, sep) {
		sep = sep || '';
		if (nodes instanceof Node) {
			nodes = [node];
		}
		var list = $.map(nodes, function(node, i) {
			return collapseList(node.childNodes);
		});
		return list.join(sep);
	};
	collapse = function(node) {
		// Based loosely on PPFrame_DOM::expand() in RECOVER_ORIG mode
		var name = node.nodeName || 'string';
		var out, list;
		if (typeof node === 'string') {
			out = node;
		} else if (node.nodeType === Node.TEXT_NODE) {
			out = node.textContent;
		} else if (name === 'root') {
			out = collapseList(node.childNodes);
		} else if (name === 'template') {
			out = '{{' + collapseChildren($(node).children('title,part'), '|') + '}}';
		} else if (name === 'tplarg') {
			out = '{{{' + collapseChildren($(node).children('title,part'), '|') + '}}}';
		} else if (name === 'name') { // temp hack
			out = collapseList(node.childNodes);
		} else if (name === 'value') { // temp hack
			out = collapseList(node.childNodes);
		} else if (name === 'comment') {
			// Recover the literal comment
			out = collapseList(node.childNodes);
		} else if (name === 'ignore') {
			out = collapseList(node.childNodes);
		} else if (name === 'ext') {
			var close = $(node).children('close');
			out = '<' +
				collapseChildren($(node).children('name,attr')) +
				(close.length ? '>' : '/>')+
				collapseChildren($(node).children('inner')) +
				collapseChildren(close);
		} else if (name === 'h') {
			out = $(node).text();
		} else {
			console.log('unrecognized node during expansion', node);
			out = '';
		}
		//console.log(name, node, '->', out);
		return out;
	};
	try {
		var err = null;
		var src = collapse(tree);
	} catch (e) {
		err = e;
	} finally {
		callback(src, err);
	}
};
