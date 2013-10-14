/*!
 * VisualEditor MediaWiki UserInterface raster icon styles.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MWSyntaxHighlight validator
 *
 * @constructor
 */
ve.ce.MWSyntaxHighlightValidator = function VeCeMWSyntaxHighlightValidator() {
	// Properties
	// 'methodname' : method reference
	this.roster = {
		'error' : this.err,
		'balanceAA' : this.balanceAA,
		'balanceAB' : this.balanceAB,
		'matchAB' : this.matchAB
	};
	// Data to perform validation on
	this.data = '';
	// Indices of included areas
	this.matchableArea = [];
};

/* Methods */

/**
 * Get the roster of helper methods
 *
 * @method
 * @returns {Object} Method name, method reference
 */
ve.ce.MWSyntaxHighlightValidator.prototype.getRoster = function(){
	return this.roster;
};

/**
 * Set the data for validation
 *
 * @method
 * @param {string} dataString
 */
ve.ce.MWSyntaxHighlightValidator.prototype.setData = function( dataString ){
	this.data = dataString;
};

/**
 * Get the overlap of two ranges
 *
 * @method
 * @param {Object} x Model index range
 * @param {Object} y Model index range
 * @returns {Object} Model index range
 */
ve.ce.MWSyntaxHighlightValidator.prototype.getOverlap = function( x, y ){
	if ( x.b <= y.a || y.b <= x.a ){
		return null;
	} else {
		var sorted = [x.a,x.b,y.a,y.b].sort(function(a,b){return a-b;});
		return {'a':sorted[1], 'b':sorted[2]};
	}
};

/**
 * Get the subtraction of two overlapped ranges
 *
 * @method
 * @param {Object} x Model index range
 * @param {Object} y Model index range
 * @returns {Array} Model index ranges
 */
ve.ce.MWSyntaxHighlightValidator.prototype.subtractRange = function( x, y ){
	var range1 = {'a':x.a, 'b':y.a},
		range2 = {'a':y.b, 'b':x.b},
		r = [];
	if (range1.a !== range1.b){ r.push(range1); }
	if (range2.a !== range2.b){ r.push(range2); }
	return r;
};

/**
 * Check whether a model index falls within matchable area(s)
 *
 * @method
 * @param {int} index Model index
 * @returns {boolean}
 */
ve.ce.MWSyntaxHighlightValidator.prototype.canMatch = function( index ){
	for ( var i = 0; i < this.matchableArea.length; i++ ){
		if (this.matchableArea[i].a <= index && this.matchableArea[i].b >= index){
			return true;
		}
	}
	return false;
};

/**
 * Initialize matchable areas
 *
 * @method
 * @param {Array} parsedExcept Regex to determine exceptions
 * @param {Array} parsedWithin Regex to determine included areas
 * @param {Array} parsedOutside Regex to determine excluded areas
 */
ve.ce.MWSyntaxHighlightValidator.prototype.initRange = function( parsedExcept, parsedWithin, parsedOutside ){
	var exceptions = [],
		inclusions = [],
		exclusions = [],
		match,
		i, j, o, n;
	for ( i = 0; i < parsedExcept.length; i++ ){
		while ( (match = parsedExcept[i].exec( this.data ) ) !== null ){
			match.index += match[0].indexOf(match[1]);
			exceptions.push({'a': match.index, 'b': match.index + match[1].length});
		}
	}
	for ( i = 0; i < parsedOutside.length; i++ ){
		while ( (match = parsedOutside[i].exec( this.data ) ) !== null ){
			match.index += match[0].indexOf(match[1]);
			exclusions.push({'a': match.index, 'b': match.index + match[1].length});
		}
	}
	if (parsedWithin.length === 0){
		inclusions.push({'a': 0, 'b': this.data.length});
	} else {
		for ( i = 0; i < parsedWithin.length; i++ ){
			while ( (match = parsedWithin[i].exec( this.data ) ) !== null ){
				match.index += match[0].indexOf(match[1]);
				inclusions.push({'a': match.index, 'b': match.index + match[1].length});
			}
		}
	}
	exceptions.sort(function(a, b){ return a.a - b.a; });
	inclusions.sort(function(a, b){ return a.a - b.a; });
	exclusions.sort(function(a, b){ return a.a - b.a; });
	for ( i = 0; i < inclusions.length; i++ ){
		for ( j = 0; j < exclusions.length; j++ ){
			o = this.getOverlap( inclusions[i] , exclusions[j] );
			if ( o !== null ){
				n = this.subtractRange( inclusions[i], o );
				if (n.length === 1){ inclusions.splice(i, 1, n[0]); }
				else if (n.length === 2){ inclusions.splice(i, 1, n[0], n[1]); }
				else if (n.length === 0){ inclusions.splice(i, 1); }
			}
		}
		for ( j = 0; j < exceptions.length; j++ ){
			o = this.getOverlap( inclusions[i] , exceptions[j] );
			if ( o !== null ){
				n = this.subtractRange( inclusions[i], o );
				if (n.length === 1){ inclusions.splice(i, 1, n[0]); }
				else if (n.length === 2){ inclusions.splice(i, 1, n[0], n[1]); }
				else if (n.length === 0){ inclusions.splice(i, 1); }
			}
		}
	}
	this.matchableArea = inclusions;
};

/* Helper methods on roster */

/**
 * Return error for matches
 *
 * @method
 * @param {Array} parsedRegexGroup RegExp objects
 * @param {Object} context Context
 * @returns {Object} If need error highlights; regex matches to be highlighted
 */
ve.ce.MWSyntaxHighlightValidator.prototype.err = function( parsedRegexGroup, context ){
	var matching = [],
		match,
		i;
	for ( i = 0; i < parsedRegexGroup.length; i++ ){
		while ( (match = parsedRegexGroup[i].exec( context.data ) ) !== null ){
			match.index = match.index + match[0].indexOf(match[1]);
			if (context.canMatch(match.index)){
				matching.push(match);
			}
		}
	}
	return {
		'needMarks' : true,
		'matches' : matching
	};
};

/**
 * Balance the existence of the same token; 1-1 relationship
 *
 * @method
 * @param {Array} parsedRegexGroup RegExp objects
 * @param {Object} context Context
 * @returns {Object} If need error highlights; regex matches to be highlighted
 */
ve.ce.MWSyntaxHighlightValidator.prototype.balanceAA = function( parsedRegexGroup, context ){
	var a = [],
		match,
		pushing = true,
		regexA = parsedRegexGroup[0];
	while ( (match = regexA.exec( context.data ) ) !== null ){
		match.index = match.index + match[0].indexOf(match[1]);
		if (context.canMatch(match.index)){
			if (pushing){
				a.push(match);
				pushing = false;
			} else {
				a.pop();
				pushing = true;
			}
		}
	}
	if (a.length === 0){
		return {
			'needMarks' : false,
			'matches' : []
		};
	} else {
		return {
			'needMarks' : true,
			'matches' : a
		};
	}
};

/**
 * Balance the existence of two different tokens; 1-1 relationship
 *
 * @method
 * @param {Array} parsedRegexGroup RegExp objects
 * @param {Object} context Context
 * @returns {Object} If need error highlights; regex matches to be highlighted
 */
ve.ce.MWSyntaxHighlightValidator.prototype.balanceAB = function( parsedRegexGroup, context ){
	var a = [],
		b = [],
		match,
		regexA = parsedRegexGroup[0],
		regexB = parsedRegexGroup[1],
		regex = new RegExp('('+regexA.source + '|' + regexB.source+')', 'g');
	while ( (match = regex.exec( context.data ) ) !== null ){
		match.index = match.index + match[0].indexOf(match[1]);
		if (context.canMatch(match.index)){
			if (regexA.test(match[1])){
				a.push(match);
			} else {
				if (a.length !== 0){
					a.pop();
				} else {
					b.push(match);
				}
			}
		}
	}
	if (a.length === 0 && b.length === 0){
		return {
			'needMarks' : false,
			'matches' : []
		};
	} else {
		return {
			'needMarks' : true,
			'matches' : a.concat(b)
		};
	}
};

/**
 * Check co-existence of two different tokens; n-1 relationship
 *
 * @method
 * @param {Array} parsedRegexGroup RegExp objects
 * @param {Object} context Context
 * @returns {Object} If need error highlights; regex matches to be highlighted
 */
ve.ce.MWSyntaxHighlightValidator.prototype.matchAB = function( parsedRegexGroup, context ){
	var match,
		regexA = parsedRegexGroup[0],
		regexB = parsedRegexGroup[1],
		a = [],
		matchOpen = true,
		regex = new RegExp('('+regexA.source + '|' + regexB.source+')', 'g');
	while ( (match = regex.exec( context.data ) ) !== null ){
		match.index = match.index + match[0].indexOf(match[1]);
		if (context.canMatch(match.index)){
			if (regexA.test(match[1])){
				matchOpen = true;
				a.push(match);
			} else {
				matchOpen = false;
				a = [];
			}
		}
	}
	if (!matchOpen){
		return {
			'needMarks' : false,
			'matches' : []
		};
	} else {
		return {
			'needMarks' : true,
			'matches' : a
		};
	}
};