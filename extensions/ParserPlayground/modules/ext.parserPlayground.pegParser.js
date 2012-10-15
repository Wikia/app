/**
 * Parser for wikitext to provisional temp structure, using PEG.js and
 * a separate PEG grammar file (pegParser.pegjs.txt)
 *
 * Use along with the MWTreeRenderer and MWTreeSerializer classes for
 * HTML output and source round-tripping.
 *
 * If installed as a user script or to customize, set parserPlaygroundPegPage
 * to point at the MW page name containing the parser peg definition; default
 * is 'MediaWiki:Gadget-ParserPlayground-PegParser.pegjs'.
 */
function PegParser(env) {
	this.env = env || {};
}

PegParser.src = false;

PegParser.prototype.parseToTree = function(text, callback) {
	this.initSource(function() {
		var out, err;
		try {
			var parser = PEG.buildParser(PegParser.src);
			out = parser.parse(text);
		} catch (e) {
			err = e;
		} finally {
			callback(out, err);
		}
	});
}

/**
 * @param {object} tree
 * @param {function(tree, error)} callback
 */
PegParser.prototype.expandTree = function(tree, callback) {
	var self = this;
	var subParseArray = function(listOfTrees) {
		var content = [];
		$.each(listOfTrees, function(i, subtree) {
			self.expandTree(subtree, function(substr, err) {
				content.push(tree);
			});
		});
		return content;
	};
	var src;
	if (typeof tree === "string") {
		callback(tree);
		return;
	}
	if (tree.type == 'template') {
		// expand a template node!
		
		// Resolve a possibly relative link
		var templateName = this.env.resolveTitle( tree.target, 'Template' );
		this.env.fetchTemplate( tree.target, tree.params || {}, function( templateSrc, error ) {
			// @fixme should pre-parse/cache these too?
			self.parseToTree( templateSrc, function( templateTree, error ) {
				if ( error ) {
					callback({
						type: 'placeholder',
						orig: tree,
						content: [
							{
								// @fixme broken link?
								type: 'link',
								target: templateName
							}
						]
					});
				} else {
					callback({
						type: 'placeholder',
						orig: tree,
						content: self.env.expandTemplateArgs( templateTree, tree.params )
					});
				}
			})
		} );
		// Wait for async...
		return;
	}
	var out = $.extend( tree ); // @fixme prefer a deep copy?
	if (tree.content) {
		out.content = subParseArray(tree.content);
	}
	callback(out);
};

PegParser.prototype.initSource = function(callback) {
	if (PegParser.src) {
		callback();
	} else {
		if ( typeof parserPlaygroundPegPage !== 'undefined' ) {
			$.ajax({
				url: wgScriptPath + '/api' + wgScriptExtension,
				data: {
					format: 'json',
					action: 'query',
					prop: 'revisions',
					rvprop: 'content',
					titles: parserPlaygroundPegPage
				},
				success: function(data, xhr) {
					$.each(data.query.pages, function(i, page) {
						if (page.revisions && page.revisions.length) {
							PegParser.src = page.revisions[0]['*'];
						}
					});
					callback()
				},
				dataType: 'json',
				cache: false
			}, 'json');
		} else {
			$.ajax({
				url: mw.config.get('wgParserPlaygroundAssetsPath', mw.config.get('wgExtensionAssetsPath')) + '/ParserPlayground/modules/pegParser.pegjs.txt',
				success: function(data) {
					PegParser.src = data;
					callback();
				},
				dataType: 'text',
				cache: false
			});
		}
	}
};

if (typeof module == "object") {
	module.exports.PegParser = PegParser;
}
