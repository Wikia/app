/**
 * List of all CSS properties known to mankind
 *
 * @see https://developer.mozilla.org/en/CSS_Reference
 */
var CSSProperties = {
	'animation': 1,
	'animation-delay': 1,
	'animation-direction': 1,
	'animation-duration': 1,
	'animation-iteration-count': 1,
	'animation-name': 1,
	'animation-play-state': 1,
	'animation-timing-function': 1,
	'background': 1,
	'background-attachment': 1,
	'background-clip': 1,
	'background-color': 1,
	'background-image': 1,
	'background-origin': 1,
	'background-position': 1,
	'background-repeat': 1,
	'background-size': 1,
	'border': 1,
	'border-top': 1,
	'border-right': 1,
	'border-bottom': 1,
	'border-left': 1,
	'border-color': 1,
	'border-top-color': 1,
	'border-right-color': 1,
	'border-bottom-color': 1,
	'border-left-color': 1,
	'border-style': 1,
	'border-top-style': 1,
	'border-right-style': 1,
	'border-bottom-style': 1,
	'border-left-style': 1,
	'border-width': 1,
	'border-top-width': 1,
	'border-right-width': 1,
	'border-bottom-width': 1,
	'border-left-width': 1,
	'border-collapse': 1,
	'border-radius': 1,
	'border-top-left-radius': 1,
	'border-top-right-radius': 1,
	'border-bottom-right-radius': 1,
	'border-bottom-left-radius': 1,
	'border-spacing': 1,
	'bottom': 1,
	'box-shadow': 1,
	'caption-side': 1,
	'clear': 1,
	'clip': 1,
	'clip-path': 1,
	'color': 1,
	'content': 1,
	'counter-increment': 1,
	'counter-reset': 1,
	'cursor': 1,
	'direction': 1,
	'display': 1,
	'empty-cells': 1,
	'filter': 1,
	'float': 1,
	'font': 1,
	'font-style': 1,
	'font-variant': 1,
	'font-weight': 1,
	'font-size': 1,
	'line-height': 1,
	'font-family': 1,
	'font-size-adjust': 1,
	'font-stretch': 1,
	'height': 1,
	'image-rendering': 1,
	'ime-mode': 1,
	'left': 1,
	'letter-spacing': 1,
	'line-height': 1,
	'list-style': 1,
	'list-style-image': 1,
	'list-style-position': 1,
	'list-style-type': 1,
	'margin': 1,
	'margin-bottom': 1,
	'margin-left': 1,
	'margin-right': 1,
	'margin-top': 1,
	'marker-offset': 1,
	'marks': 1,
	'mask': 1,
	'max-height': 1,
	'max-width': 1,
	'min-height': 1,
	'min-width': 1,
	'opacity': 1,
	'orient': 1,
	'orphans': 1,
	'outline': 1,
	'outline-color': 1,
	'outline-style': 1,
	'outline-width': 1,
	'outline-offset': 1,
	'overflow': 1,
	'overflow-x': 1,
	'overflow-y': 1,
	'padding': 1,
	'padding-bottom': 1,
	'padding-left': 1,
	'padding-right': 1,
	'padding-top': 1,
	'page-break-after': 1,
	'page-break-before': 1,
	'page-break-inside': 1,
	'pointer-events': 1,
	'position': 1,
	'quotes': 1,
	'resize': 1,
	'right': 1,
	'table-layout': 1,
	'text-align': 1,
	'text-decoration': 1,
	'text-indent': 1,
	'text-overflow': 1,
	'text-rendering': 1,
	'text-shadow': 1,
	'text-transform': 1,
	'top': 1,
	'unicode-bidi': 1,
	'vertical-align': 1,
	'visibility': 1,
	'white-space': 1,
	'widows': 1,
	'width': 1,
	'word-spacing': 1,
	'word-wrap': 1,
	'z-index': 1
};

// IE specific properties
CSSProperties.zoom = 1;

/**
 * Custom lint rules.
 *
 * To be added via CSSLint.addRule()
 */
exports.rules = {
	errors: {
	    id: 'errors',
	    init: function(parser, reporter) {
	    	// NOP
	    }
	},

	sass: {
		id: 'sass',
		name: 'SASS specific checks',
		desc: 'This rule looks for SASS specific syntax.',
		browsers: 'All',

		init: function(parser, reporter) {
			var rule = this,
				lastError = {},
				lastCommentLine = 0,
				cdnStylePathCommentRegExp = /;\s*\/\* \$wgCdnStylePath \*\/\s*$/;

			parser.addListener('error', function(event) {
				var ignoreError = false,
					err = event.error;

				// grab SASS style comments (// foo)
				if (err.message.indexOf("Unexpected token '/' at line") === 0) {
					ignoreError = true;

					if (lastError.line == err.line && (lastError.col + 1) == err.col) {
						lastCommentLine = err.line;
					}
				}
				// @import is heavily used in SASS
				else if (err.message == '@import not allowed here.') {
					ignoreError = true;
				}
				// Expected LBRACE at line 13, character 1.
				// ignore this error if it comes straight after a line with a comment
				else if (err.message.indexOf('Expected LBRACE at line') === 0) {
					if (err.col == 1 && (lastCommentLine + 1) == err.line) {
						ignoreError = true;
					}
				}
				// ignore errors in SASS one-line comments
				else if (err.line == lastCommentLine) {
					ignoreError = true;
				}

				// pass an error
				if (!ignoreError) {
					reporter.error(event.message, event.line, event.col, rule);
				}

				// store recent error
				lastError = err;
			});

			// check existance of /* $wgCdnStylePath */ special comment
			parser.addListener('property', function(event) {
				var prop = event.property.text,
					lineNo = event.property.line,
					context = reporter.lines[lineNo-1];

				if (prop === 'background' || prop === 'background-image') {
					if (!cdnStylePathCommentRegExp.test(context)) {
						reporter.error('Background image defined, but /* $wgCdnStylePath */ comment is missing', event.property.line, event.property.col, rule);
					}
				}
			});
		}
	},

	ie6: {
		id: 'ie6',
		name: 'Find IE6 specific fixes',
		desc: 'Catch * html #foo selectors',
		browsers: 'IE6',

		init: function(parser, reporter) {
			var rule = this,
				regexp = /^\*\s*html/; // match "* html #foo"

			parser.addListener('startrule', function(event) {
				var selectors = event.selectors;

				for (var s=0, len = selectors.length; s<len; s++) {
					if (regexp.test(selectors[s].text)) {
						reporter.error('IE6 specific fix found.', selectors[s].line, selectors[s].col, rule);
					}
				}
			});
		}
	},

	checkProperties: {
		id: 'checkProperties',
		name: 'Check CSS properties',
		desc: 'Check CSS properties for typos',
		browsers: 'All',

		init: function(parser, reporter) {
			var rule = this,
				properties = CSSProperties,
				prefixes = /^\*|-(webkit|moz|ms|o)-/,
				ie6Prefix = /^_/;

			parser.addListener('property', function(event) {
				var prop = event.property.text;

				// check against list of know properties (then try to remove browser specific prefix)
				if (!properties[prop] && !properties[prop.replace(prefixes, '')]) {
					// property like "_height: 100px" found
					if (ie6Prefix.test(prop)) {
						reporter.error('IE6 specific fix found.', event.line, event.col, rule);
					}
					else {
						reporter.error("Unknown property '" + prop + "' found.", event.line, event.col, rule);
					}
				}
	        });
		}
	}
};
