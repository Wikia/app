/*!
 * VisualEditor DataModel Node class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */
/*global rangy */

/**
 * Text offset from start or end of string
 *
 * The offsets are measured in text node code unit boundaries. That is, there is an
 * implicit start and end position in each text node, so there are eight positions in
 * "he<b>ll</b>o".  This will not always agree exactly with a real browser's cursor
 * positions, because of grapheme clustering and positioning around tags, but is a
 * useful test shorthand.
 *
 * @class
 * @constructor
 * @param {string} direction (forward counts from string start, backward from end)
 * @param {number} offset Offset in text node code units
 */
ve.ce.TestOffset = function VeCeTestOffset( direction, offset ) {
	if ( direction !== 'forward' && direction !== 'backward' ) {
		throw new Error( 'Invalid direction "' + direction + '"' );
	}
	this.direction = direction;
	this.offset = offset;
	this.lastText = null;
	this.lastSel = null;
};

/**
 * Calculate the offset from each end of a particular HTML string
 *
 * @param {Node} node The DOM node with respect to which the offset is resolved
 * @returns {Object} Offset information
 * @returns {number} [return.consumed] The number of code units consumed (if n out of range)
 * @returns {Node} [return.node] The node containing the offset (if n in range)
 * @returns {number} [return.offset] The offset in code units / child elements (if n in range)
 * @returns {string} [return.slice] String representation of the offset position (if n in range)
 */
ve.ce.TestOffset.prototype.resolve = function ( node ) {
	var reversed = ( this.direction !== 'forward' );
	return ve.ce.TestOffset.static.findTextOffset( node, this.offset, reversed );
};

/* Static Methods */
ve.ce.TestOffset.static = {};

/**
 * Find text by offset in the given node.
 * Returns the same as #resolve.
 * @private
 * @static
 */
ve.ce.TestOffset.static.findTextOffset = function ( node, n, reversed ) {
	var i, len, found, slice, offset, childNode, childNodes, consumed = 0;
	if ( node.nodeType === node.TEXT_NODE ) {
		// test >= n because one more boundaries than code units
		if ( node.textContent.length >= n ) {
			offset = reversed ? node.textContent.length - n : n;
			slice = node.textContent.substring( 0, offset ) + '|' +
				node.textContent.substring( offset );
			return { 'node': node, 'offset': offset, 'slice': slice };
		} else {
			return { 'consumed': node.textContent.length + 1 };
		}
	}
	if ( node.nodeType !== node.ELEMENT_NODE ) {
		return { 'consumed': 0 };
	}
	// node is an ELEMENT_NODE below here
	// TODO consecutive text nodes will cause an extra phantom boundary.
	// In realistic usage, this can't always be avoided, because normalize() will
	// close an IME.
	childNodes = Array.prototype.slice.call( node.childNodes );

	if ( childNodes.length === 0 ) {
		if ( n === 0 ) {
			return { 'node': node, 'offset': 0, 'slice': '|' };
		}
		return { 'consumed': 0 };
	}

	if ( reversed ) {
		childNodes.reverse();
	}
	for ( i = 0, len = childNodes.length; i < len; i++ ) {
		childNode = node.childNodes[i];
		found = ve.ce.TestOffset.static.findTextOffset( childNode, n - consumed, reversed );
		if ( found.node ) {
			return found;
		}
		consumed += found.consumed;
		// Extra boundary after element, if not followed by a text node
		if ( childNode.nodeType === node.ELEMENT_NODE ) {
			if ( i + 1 === len || childNodes[i + 1].nodeType !== node.TEXT_NODE ) {
				consumed += 1;
				if ( consumed === n ) {
					// TODO: create a reasonable 'slice' string
					return { 'node': node, 'offset': i + 1, 'slice': 'XXX' };
				}
			}
		}
	}
	return { 'consumed': consumed };
};

/**
 * IME-like CE test class
 *
 * @class
 * @constructor
 * @param {ve.ui.Surface} uiSurface The UI Surface
 */
ve.ce.TestRunner = function VeCeTestRunner( uiSurface ) {
	var testRunner,
		callId = 0;
	this.uiSurface = uiSurface;
	this.view = uiSurface.view;
	this.model = uiSurface.model;
	this.doc = uiSurface.getElementDocument();
	this.postponedCalls = {};

	// Turn off SurfaceObserver setTimeouts
	uiSurface.view.surfaceObserver.frequency = null;

	// Take control of eventSequencer 'setTimeouts'
	testRunner = this;
	this.view.eventSequencer.postpone = function ( f ) {
		testRunner.postponedCalls[++callId] = f;
		return callId;
	};
	this.view.eventSequencer.cancelPostponed = function ( callId ) {
		delete testRunner.postponedCalls[callId];
	};
};

/* Methods */

/**
 * Get the paragraph node in which testing occurs
 *
 * TODO: The code assumes that the document consists of exactly one paragraph
 * @returns {Node} The paragraph node
 */

ve.ce.TestRunner.prototype.getP = function () {
	var p = this.view.$element.find( '.ve-ce-documentNode > p' )[0];
	if ( p === undefined ) {
		if ( this.view.$element.find( '.ve-ce-documentNode' )[0] === undefined ) {
			throw new Error( 'no CE div' );
		}
		throw new Error( 'CE div but no p' );
	}
	return p;
};

/**
 * Run any pending postponed calls
 *
 * Exceptions thrown may leave this.postponedCalls in an inconsistent state
 */
ve.ce.TestRunner.prototype.endLoop = function () {
	var callId, postponedCalls,
		check = true;

	// postponed calls may add more postponed calls
	while ( check ) {
		postponedCalls = this.postponedCalls;
		this.postponedCalls = {};
		check = false;
		for ( callId in postponedCalls ) {
			check = true;
			postponedCalls[callId]();
		}
	}
};

/**
 * Send an event to the ce.Surface eventSequencer
 *
 * @param {string} eventName DOM event name (such as 'keydown')
 * @param {Object} ev Fake event object with any necessary properties
 */
ve.ce.TestRunner.prototype.sendEvent = function ( eventName, ev ) {
	this.view.eventSequencer.onEvent( eventName, ev );
};

/**
 * Change the text
 *
 * TODO: it should be possible to add markup
 * @param {string} text The new text
 */
ve.ce.TestRunner.prototype.changeText = function ( text ) {
	var extra,
		range = null,
		sel = rangy.getSelection( this.doc ),
		ranges = sel.getAllRanges();

	if ( ranges.length > 0 ) {
		range = ranges[0];
	}
	// TODO: Enable multi-paragraph testing. For now, assuming one paragraph.
	if ( range && range.startNode && text.startsWith( this.startNode.textContent ) ) {
		// We're just appending
		extra = range.startNode.textContent.substring( range.startNode.textContent.length );
		// This is fine IF startNode is a TextNode
		range.startNode.textContent += extra;
	} else {
		// Wipe out the node
		this.getP().textContent = text;
	}
	this.lastText = text;
};

/**
 * Select text by offset in concatenated text nodes
 *
 * @param {ve.ce.TestOffset|number} start The start offset
 * @param {ve.ce.TestOffset|number} end The end offset
 * @returns {Object} Selected range
 * @returns {Node} return.startNode The node at the start of the selection
 * @returns {number} return.startOffset The start offset within the node
 * @returns {Node} return.endNode The node at the endof the selection
 * @returns {number} return.endOffset The endoffset within the node
 */
ve.ce.TestRunner.prototype.changeSel = function ( start, end ) {
	var foundStart, foundEnd, rangyRange, sel;
	if ( typeof start === 'number' ) {
		start = new ve.ce.TestOffset( 'forward', start );
	}
	if ( typeof end === 'number' ) {
		end = new ve.ce.TestOffset( 'forward', end );
	}

	foundStart = start.resolve( this.getP() );
	foundEnd = start.resolve( this.getP() );
	if ( !foundStart.node ) {
		throw new Error( 'Bad start offset: ' + start.offset );
	}
	if ( !foundEnd.node ) {
		throw new Error( 'Bad end offset: ', end.offset );
	}

	rangyRange = rangy.createRange( this.doc );
	rangyRange.setStart( foundStart.node, foundStart.offset );
	rangyRange.setEnd( foundEnd.node, foundEnd.offset );
	sel = rangy.getSelection( this.doc );
	sel.removeAllRanges();
	this.getP().focus();
	sel.addRange( rangyRange, false );
	this.lastSel = [start, end];

	return {
		'startNode': foundStart.node,
		'endNode': foundEnd.node,
		'startOffset': foundStart.offset,
		'endOffset': foundEnd.offset
	};
};

/**
 * Call assert.equal to test the IME test has updated the DM correctly
 * @param {Object} assert The QUnit assertion object
 * @param {string} testName The name of the test scenario
 * @param {number} sequence The sequence number in the test scenario
 */
ve.ce.TestRunner.prototype.testEqual = function ( assert, testName, sequence ) {
	var comment = testName + ' seq=' + sequence + ': "' + this.lastText + '"';
	// TODO: should we also test this.getP().textContent ?
	assert.equal( this.model.getDocument().getText(), this.lastText, comment );
};
