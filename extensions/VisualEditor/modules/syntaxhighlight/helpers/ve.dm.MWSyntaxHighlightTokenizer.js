/*!
 * VisualEditor MediaWiki UserInterface raster icon styles.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MWSyntaxHighlight tokenizer
 *
 * @constructor
 */
ve.dm.MWSyntaxHighlightTokenizer = function VeDmMWSyntaxHighlightTokenizer() {
	this.words = /([^\W0-9]+)/;	// Test for words
	this.num = /([0-9]+)/;	//Test for numbers
	this.tokenRegex = /(\W|[^\W0-9]+|[0-9]+)/g;
};

/* Methods */

/**
 * Tokenize data string
 *
 * @method
 * @param {string} data Model data string
 * @returns {Array} Tokens with indices and styling slots
 */
ve.dm.MWSyntaxHighlightTokenizer.prototype.tokenize = function ( data ) {
	var tokens = [],
		match;
	while ( (match = this.tokenRegex.exec( data )) !== null ){
		if (this.words.test(match) || this.num.test(match)){
			tokens.push({
				'text' : match[1],
				'index' : match.index,
				'mark' : [],
				'tip' : []
			});
		} else {
			if (match[1] !== '\t'){
				tokens.push({
					'text' : match[1],
					'index' : match.index,
					'mark' : [],
					'tip' : []
				});
			} else {
				tokens.push({
					'text' : match[1],
					'index' : match.index,
					'mark' : [],
					'tip' : [],
					'tab' : ''
				});
			}
		}
	}
	// Make a new char phantom
	tokens.push({
		'text' : ' ',
		'index' : data.length,
		'mark' : [],
		'tip' : [],
		'phantom' : ''
	});
	return tokens;
};