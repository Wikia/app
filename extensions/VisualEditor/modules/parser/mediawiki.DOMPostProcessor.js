/* Perform post-processing steps on an already-built HTML DOM. */

var events = require('events'),
	util = require('./ext.Util.js'),
	Util = new util.Util();

// Quick HACK: define Node constants
// https://developer.mozilla.org/en/nodeType
var Node = {
	TEXT_NODE: 3,
	COMMENT_NODE: 8
};

// Wrap all top-level inline elements in paragraphs. This should also be
// applied inside block-level elements, but in that case the first paragraph
// usually remains plain inline.
var process_inlines_in_p = function ( document ) {
	var body = document.body,
		newP = document.createElement('p'),
		cnodes = body.childNodes,
		inParagraph = false,
		deleted = 0;

	function isElementContentWhitespace ( e ) {
		return (e.data.match(/^[ \r\n\t]*$/) !== null);
	}

	for(var i = 0, length = cnodes.length; i < length; i++) {
		var child = cnodes[i - deleted],
			ctype = child.nodeType;
		//console.log(child + ctype);
		if ((ctype === 3 && (inParagraph || !isElementContentWhitespace( child ))) || 
			(ctype === Node.COMMENT_NODE && inParagraph ) ||
			(ctype !== Node.TEXT_NODE && 
				ctype !== Node.COMMENT_NODE &&
				!Util.isBlockTag(child.nodeName.toLowerCase()))
			) 
		{
			// wrap in paragraph
			newP.appendChild(child);
			inParagraph = true;
			deleted++;
		} else if (inParagraph) {
			body.insertBefore(newP, child);
			deleted--;
			newP = document.createElement('p');
			inParagraph = false;
		}
	}

	if (inParagraph) {
		body.appendChild(newP);
	}
};

function DOMPostProcessor () {
	this.processors = [process_inlines_in_p];
}

// Inherit from EventEmitter
DOMPostProcessor.prototype = new events.EventEmitter();
DOMPostProcessor.prototype.constructor = DOMPostProcessor;

DOMPostProcessor.prototype.doPostProcess = function ( document ) {
	for(var i = 0; i < this.processors.length; i++) {
		this.processors[i](document);
	}
	this.emit( 'document', document );
};


/**
 * Register for the 'document' event, normally emitted form the HTML5 tree
 * builder.
 */
DOMPostProcessor.prototype.listenForDocumentFrom = function ( emitter ) {
	emitter.addListener( 'document', this.doPostProcess.bind( this ) );
}

if (typeof module == "object") {
	module.exports.DOMPostProcessor = DOMPostProcessor;
}
