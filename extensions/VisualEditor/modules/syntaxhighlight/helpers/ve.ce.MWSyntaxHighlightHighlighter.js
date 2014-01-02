/*!
 * VisualEditor user interface MWSyntaxHighlightDialog class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MWSyntaxHighlight highlighter
 *
 * @constructor
 * @param {string} lang The language it is working on
 */
ve.ce.MWSyntaxHighlightHighlighter = function VeCeMWSyntaxHighlightHighlighter( lang ) {
	// Highlighter rule cache
	this.ruleset = {};
	this.delimiter = /\n/;
	// Properties
	// 'languageName' : boolean	;set to false to disable support
	this.langSupport = {
		'text' : true,
		'javascript' : true
	};
	// Go to the following page for explanations on language rule files
	// https://www.mediawiki.org/wiki/Extension:SyntaxHighlight_GeSHi/VisualEditor
	this.rulePath = ve.init.platform.getModulesUrl() + '/syntaxhighlight/rules/';
	this.lang = lang;
	this.validators = new ve.ce.MWSyntaxHighlightValidator();
	this.roster = this.validators.getRoster();
};

/* Methods */

/**
 * Initialization
 *
 * @method
 */
ve.ce.MWSyntaxHighlightHighlighter.prototype.initialize = function () {
	this.loadRules( this.lang );
};

/**
 * Style each token, based on loaded rules
 *
 * @method
 * @param {Array} tokens Tokens
 * @param {string} dataString Model data string
 * @param {boolean} validating Whether to use validator's ruleset instead of highlighter's
 * @returns {Array} Tokens with stying
 */
ve.ce.MWSyntaxHighlightHighlighter.prototype.mark = function ( tokens, dataString, validating ) {
	var regex, match,
		capture, range,
		regexGroup, except, within, outside, decision,
		markRange,
		pickedRules = validating ? this.ruleset.validator : this.ruleset.highlighter,
		i, j, k;
	if ( !validating ){
		for ( i = 0; i < pickedRules.length; i++){
			regex = this.parseRegex( pickedRules[i].match );
			while ( (match = regex.exec( dataString )) !== null ){
				// Capturing group; all chars in the group need marking
				capture = match[1];
				// Range of capturing group, [a, b); relative to whole string
				range = [
					match.index + match[0].indexOf(capture),
					match.index + match[0].indexOf(capture) + capture.length];
				// Mark based on indices
				markRange = this.findToken(tokens, range);
				for ( j = markRange[0]; j <= markRange[1]; j++ ){
					tokens[j].mark.push( pickedRules[i].style );
				}
			}
		}
	} else {
		this.validators.setData( dataString );
		for ( i = 0; i < pickedRules.length; i++){
			regexGroup = [];
			except = [];
			within = [];
			outside = [];
			// Initialize ranges
			for ( j = 0; j < pickedRules[i].except.length; j++ ){
				except.push(this.parseRegex( pickedRules[i].except[j] ));
			}
			for ( j = 0; j < pickedRules[i].within.length; j++ ){
				within.push(this.parseRegex( pickedRules[i].within[j] ));
			}
			for ( j = 0; j < pickedRules[i].outside.length; j++ ){
				outside.push(this.parseRegex( pickedRules[i].outside[j] ));
			}
			this.validators.initRange(except, within, outside);
			// Parse rule regex
			for ( j = 0; j < pickedRules[i].match.length; j++ ){
				regexGroup.push(this.parseRegex( pickedRules[i].match[j] ));
			}
			// Make decision
			decision = this.roster[pickedRules[i].decisionMaker]( regexGroup, this.validators );
			// Mark
			if (decision.needMarks){
				for ( j = 0; j < decision.matches.length; j++ ){
					match = decision.matches[j];
					capture = match[1];
					// Range of capturing group, [a, b); relative to whole string
					range = [
						match.index,
						match.index + capture.length];
					// Mark based on indices
					markRange = this.findToken(tokens, range);
					for ( k = markRange[0]; k <= markRange[1]; k++ ){
						tokens[k].mark.push( pickedRules[i].style );
						tokens[k].tip.push( pickedRules[i].tip );
					}
				}
			}
		}
	}
	return tokens;
};

/**
 * Convert tokens to DOM tree
 *
 * @method
 * @param {Array} tokens Tokens
 * @returns {string} HTML of entire tree
 */
ve.ce.MWSyntaxHighlightHighlighter.prototype.display = function ( tokens ) {
	var lineContainer = '<div>',
		numberContainer = '<div>',
		line = {
			'text':'',
			'm':0,
			'n':0,
			'length':0
		},
		token = {
			'text':'',
			'class':'',
			'idx':0,
			'col':0,
			'title':'',
			'ph':false,
			'tb':false
		},
		lineCount = 1, lineLength = 0, column = 0, trueLength = 0,
		title = '',
		i;
	numberContainer += this.buildNumber( lineCount++ );	// first line
	line.m = trueLength;
	for ( i = 0; i < tokens.length; i++ ){
		token.text = tokens[i].text;
		// Styling
		token.class = tokens[i].mark.join(' ');
		// Error tips
		title = tokens[i].tip.join('\n');
		if ( title !== '' ){
			token.title = title;
			title = '';
		}
		// Attributes
		token.idx = tokens[i].index;
		token.col = column;
		if (tokens[i].hasOwnProperty('phantom')){
			token.ph = true;
		}
		if (tokens[i].hasOwnProperty('tab')){
			token.tb = true;
			token.text = '        ';
		}
		lineLength += token.text.length;
		column += token.text.length;
		trueLength += tokens[i].text.length;
		line.text += this.buildToken(token);
		// Reset
		token = {
			'text':'',
			'class':'',
			'idx':0,
			'col':0,
			'title':'',
			'ph':false,
			'tb':false
		};
		// Wrap a line, start a new line
		if ( this.delimiter.test( tokens[i].text ) ){
			line.length = lineLength;
			line.n = trueLength;
			lineContainer += this.buildLine(line);
			// Reset
			line = {
				'text':'',
				'm': trueLength,
				'n':0,
				'length':0
			};
			lineLength = 0;
			column = 0;
			numberContainer += this.buildNumber( lineCount++ );	// New line number
		}
	}
	// Last unwrapped line
	if ( line.text.length > 0 ){
		line.length = lineLength;
		line.n = trueLength;
		lineContainer += this.buildLine(line);
	}
	// Wrap container
	numberContainer += '</div>';
	lineContainer += '</div>';
	return {
		'tokenDisplay' : lineContainer,
		'lineNumber' : numberContainer
	};
};

/**
 * Convert tokens to DOM tree for ve.ce node preview
 *
 * @method
 * @param {Array} tokens Tokens
 * @returns {string} HTML of entire tree (simplified DOM structure)
 */
ve.ce.MWSyntaxHighlightHighlighter.prototype.displaySimple = function ( tokens ) {
	var lineContainer = '',
		token = {
			'text':'',
			'class':''
		},
		i;
	for ( i = 0; i < tokens.length; i++ ){
		token.text = tokens[i].text;
		// Styling
		token.class = tokens[i].mark.join(' ');
		// Attributes
		if (tokens[i].hasOwnProperty('tab')){
			token.text = '        ';
		}
		lineContainer += '<span class="'+token.class+'">'+token.text+'</span>';
		// Reset
		token = {
			'text':'',
			'class':''
		};
	}
	return lineContainer;
};

/**
 * Build line number HTML
 *
 * @method
 * @param {int} number Line number
 * @returns {string}
 */
ve.ce.MWSyntaxHighlightHighlighter.prototype.buildNumber = function ( number ){
	return '<pre class="ve-ui-simplesurface-line"><span>'+number+'</span></pre>';
};

/**
 * Build token HTML
 *
 * @method
 * @param {Object} tokenObject Token
 * @returns {string}
 */
ve.ce.MWSyntaxHighlightHighlighter.prototype.buildToken = function ( tokenObject ){
	var ph = '', tb = '', title = '';
	if (tokenObject.ph){ ph = 'ph = " " ';}
	if (tokenObject.tb){ tb = 'tb = " " ';}
	if (tokenObject.title !== ''){ title = 'title = "'+tokenObject.title+'" ';}
	return (
		'<span class="'+
			tokenObject.class+
		'" idx='+
			tokenObject.idx+
		' col='+
			tokenObject.col+
		' '+
			title+ph+tb+
		'>'+
			tokenObject.text+
		'</span>'
	);
};

/**
 * Build line HTML
 *
 * @method
 * @param {Object} lineObject Line
 * @returns {string}
 */
ve.ce.MWSyntaxHighlightHighlighter.prototype.buildLine = function ( lineObject ){
	return '<pre class="ve-ui-simplesurface-line" m='+lineObject.m+' n='+lineObject.n+' length='+lineObject.length+'>'+lineObject.text+'</pre>';
};

/**
 * Parse pre-defined JSON file
 *
 * @method
 * @param {string} lang The language (as filename)
 */
ve.ce.MWSyntaxHighlightHighlighter.prototype.loadRules = function ( lang ) {
	var dataClosure = null;
	jQuery.ajax({
		'async': false,
		'global': false,
		'url': this.rulePath + lang + '.json',
		'dataType': 'json',
		'success': function (data) {
			dataClosure = data;}
	});
	this.ruleset = dataClosure;
};

/**
 * Parse string to RegExp object
 *
 * @method
 * @param {string} regexString
 * @returns {Object} RegExp object
 */
ve.ce.MWSyntaxHighlightHighlighter.prototype.parseRegex = function ( regexString ) {
	var regex = regexString.match(/^\/(.*)\/[igm]*$/)[1],
		modifier = regexString.match(/^\/.*\/([igm]*$)/)[1];
	return new RegExp( regex, modifier );
};

/**
 * Get the list of supported languages
 *
 * @method
 * @returns {Object} Object describing all supported languages
 */
ve.ce.MWSyntaxHighlightHighlighter.prototype.getSupportedLanguages = function () {
	return this.langSupport;
};

/**
 * Check whether the language is supported
 *
 * @method
 * @returns {boolean}
 */
ve.ce.MWSyntaxHighlightHighlighter.prototype.isSupportedLanguage = function () {
	return this.langSupport.hasOwnProperty( this.lang );
};

/**
 * Check whether the support for the language is enabled
 *
 * @method
 * @returns {boolean}
 */
ve.ce.MWSyntaxHighlightHighlighter.prototype.isEnabledLanguage = function () {
	return this.langSupport[ this.lang ];
};

/**
 * Find all tokens that overlap with the given range
 *
 * @method
 * @param {Array} tokens Tokens
 * @param {Array} range Array describing model range
 * @returns {Array} Range of token indices
 */
ve.ce.MWSyntaxHighlightHighlighter.prototype.findToken = function ( tokens, range ) {
	var items = [],
		i;
	for ( i = 0; i < tokens.length; i++ ){
		if (
			( tokens[i].index <= range[0] && tokens[i].index + tokens[i].text.length > range[0] ) ||
			( tokens[i].index > range[0] && tokens[i].index + tokens[i].text.length < range[1] ) ||
			( tokens[i].index < range[1] && tokens[i].index + tokens[i].text.length >= range[1] )
		){
			items.push(tokens[i]);
		}
	}
	if (items.length === 1){
		i = tokens.indexOf( items[0] );
		return [i, i];
	} else {
		return [tokens.indexOf( items[0] ), tokens.indexOf( items[items.length - 1] )];
	}
};