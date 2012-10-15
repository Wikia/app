// THIS FILE HAS BEEN MODIFIED for use with the mediawiki wikiEditor
// It no longer requires etherpad.collab.ace.easysync2.Changeset
// THIS FILE WAS ORIGINALLY AN APPJET MODULE: etherpad.collab.ace.contentcollector

/**
 * Copyright 2009 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS-IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

var _MAX_LIST_LEVEL = 8;

function sanitizeUnicode(s) {
	return s.replace(/[\uffff\ufffe\ufeff\ufdd0-\ufdef\ud800-\udfff]/g, '?');
}

function makeContentCollector( browser, domInterface ) {
	browser = browser || {};

	var dom = domInterface || {
		isNodeText : function(n) {
			return (n.nodeType == 3);
		},
		nodeTagName : function(n) {
			return n.tagName;
		},
		nodeValue : function(n) {
			try {
				return n.nodeValue;
			} catch ( err ) {
				return '';
			}
		},
		nodeName : function(n) {
			return n.nodeName;
		},
		nodeNumChildren : function(n) {
			return n.childNodes.length;
		},
		nodeChild : function(n, i) {
			return n.childNodes.item(i);
		},
		nodeProp : function(n, p) {
			return n[p];
		},
		nodeAttr : function(n, a) {
			return n.getAttribute(a);
		},
		optNodeInnerHTML : function(n) {
			return n.innerHTML;
		}
	};

	var _blockElems = {
		"div" : 1,
		"p" : 1,
		"pre" : 1,
		"li" : 1
	};
	function isBlockElement(n) {
		return !!_blockElems[(dom.nodeTagName(n) || "").toLowerCase()];
	}
	function textify(str) {
		return sanitizeUnicode(str.replace(/[\n\r ]/g, ' ').replace(/\xa0/g,
				' ').replace(/\t/g, '        '));
	}
	function getAssoc(node, name) {
		return dom.nodeProp(node, "_magicdom_" + name);
	}

	var lines = (function() {
		var textArray = [];
		var self = {
			length : function() {
				return textArray.length;
			},
			atColumnZero : function() {
				return textArray[textArray.length - 1] === "";
			},
			startNew : function() {
				textArray.push("");
				self.flush(true);
			},
			textOfLine : function(i) {
				return textArray[i];
			},
			appendText : function(txt, attrString) {
				textArray[textArray.length - 1] += txt;
				// dmesg(txt+" / "+attrString);
		},
		textLines : function() {
			return textArray.slice();
		},
		// call flush only when you're done
			flush : function(withNewline) {

			}
		};
		self.startNew();
		return self;
	}());
	var cc = {};
	function _ensureColumnZero(state) {
		if (!lines.atColumnZero()) {
			_startNewLine(state);
		}
	}
	var selection, startPoint, endPoint;
	var selStart = [ -1, -1 ], selEnd = [ -1, -1 ];
	var blockElems = {
		"div" : 1,
		"p" : 1,
		"pre" : 1
	};
	function _isEmpty(node, state) {
		// consider clean blank lines pasted in IE to be empty
		if (dom.nodeNumChildren(node) == 0)
			return true;
		if (dom.nodeNumChildren(node) == 1 && getAssoc(node, "shouldBeEmpty")
				&& dom.optNodeInnerHTML(node) == "&nbsp;"
				&& !getAssoc(node, "unpasted")) {
			if (state) {
				var child = dom.nodeChild(node, 0);
				_reachPoint(child, 0, state);
				_reachPoint(child, 1, state);
			}
			return true;
		}
		return false;
	}
	function _pointHere(charsAfter, state) {
		var ln = lines.length() - 1;
		var chr = lines.textOfLine(ln).length;
		if (chr == 0 && state.listType && state.listType != 'none') {
			chr += 1; // listMarker
		}
		chr += charsAfter;
		return [ ln, chr ];
	}
	function _reachBlockPoint(nd, idx, state) {
		if (!dom.isNodeText(nd))
			_reachPoint(nd, idx, state);
	}
	function _reachPoint(nd, idx, state) {
		if (startPoint && nd == startPoint.node && startPoint.index == idx) {
			selStart = _pointHere(0, state);
		}
		if (endPoint && nd == endPoint.node && endPoint.index == idx) {
			selEnd = _pointHere(0, state);
		}
	}
	function _incrementFlag(state, flagName) {
		state.flags[flagName] = (state.flags[flagName] || 0) + 1;
	}
	function _decrementFlag(state, flagName) {
		state.flags[flagName]--;
	}
	function _enterList(state, listType) {
		var oldListType = state.listType;
		state.listLevel = (state.listLevel || 0) + 1;
		if (listType != 'none') {
			state.listNesting = (state.listNesting || 0) + 1;
		}
		state.listType = listType;
		return oldListType;
	}
	function _exitList(state, oldListType) {
		state.listLevel--;
		if (state.listType != 'none') {
			state.listNesting--;
		}
		state.listType = oldListType;
	}
	function _produceListMarker(state) {

	}
	function _startNewLine(state) {
		if (state) {
			var atBeginningOfLine = lines.textOfLine(lines.length() - 1).length == 0;
			if (atBeginningOfLine && state.listType && state.listType != 'none') {
				_produceListMarker(state);
			}
		}
		lines.startNew();
	}
	cc.notifySelection = function(sel) {
		if (sel) {
			selection = sel;
			startPoint = selection.startPoint;
			endPoint = selection.endPoint;
		}
	};
	cc.collectContent = function(node, state) {
		if (!state) {
			state = {
				flags : {/* name -> nesting counter */}
			};
		}
		var isBlock = isBlockElement(node);
		var isEmpty = _isEmpty(node, state);
		if (isBlock)
			_ensureColumnZero(state);
		var startLine = lines.length() - 1;
		_reachBlockPoint(node, 0, state);
		if (dom.isNodeText(node)) {
			var txt = dom.nodeValue(node);
			var rest = '';
			var x = 0; // offset into original text
			if (txt.length == 0) {
				if (startPoint && node == startPoint.node) {
					selStart = _pointHere(0, state);
				}
				if (endPoint && node == endPoint.node) {
					selEnd = _pointHere(0, state);
				}
			}
			while (txt.length > 0) {
				var consumed = 0;
				if (!browser.firefox || state.flags.preMode) {
					var firstLine = txt.split('\n', 1)[0];
					consumed = firstLine.length + 1;
					rest = txt.substring(consumed);
					txt = firstLine;
				} else { /* will only run this loop body once */
				}
				if (startPoint && node == startPoint.node
						&& startPoint.index - x <= txt.length) {
					selStart = _pointHere(startPoint.index - x, state);
				}
				if (endPoint && node == endPoint.node
						&& endPoint.index - x <= txt.length) {
					selEnd = _pointHere(endPoint.index - x, state);
				}
				var txt2 = txt;
				if ((!state.flags.preMode) && /^[\r\n]*$/.exec(txt)) {
					// prevents textnodes containing just "\n" from being
					// significant
					// in safari when pasting text, now that we convert them to
					// spaces instead of removing them, because in other cases
					// removing "\n" from pasted HTML will collapse words
					// together.
					txt2 = "";
				}
				var atBeginningOfLine = lines.textOfLine(lines.length() - 1).length == 0;
				if (atBeginningOfLine) {
					// newlines in the source mustn't become spaces at beginning
					// of line box
					txt2 = txt2.replace(/^\n*/, '');
				}
				if (atBeginningOfLine && state.listType
						&& state.listType != 'none') {
					_produceListMarker(state);
				}
				lines.appendText(textify(txt2));

				x += consumed;
				txt = rest;
				if (txt.length > 0) {
					_startNewLine(state);
				}
			}

		} else {
			var cls = dom.nodeProp(node, "className");
			var tname = (dom.nodeTagName(node) || "").toLowerCase();
			if (tname == "br") {
				_startNewLine(state);
			} else if (tname == "script" || tname == "style") {
				// ignore
			} else if (!isEmpty) {
				var styl = dom.nodeAttr(node, "style");

				var isPre = (tname == "pre");
				if ((!isPre) && browser.safari) {
					isPre = (styl && /\bwhite-space:\s*pre\b/i.exec(styl));
				}
				if (isPre)
					_incrementFlag(state, 'preMode');
				var oldListTypeOrNull = null;

				var nc = dom.nodeNumChildren(node);
				for ( var i = 0; i < nc; i++) {
					var c = dom.nodeChild(node, i);
					//very specific IE case where it inserts <span lang="en"> which we want to ginore.
					//to reproduce copy content from wordpad andpaste into the middle of a line in IE
					if ( browser.msie && cls.indexOf('wikiEditor') >= 0 && dom.nodeName(c) == 'SPAN' && dom.nodeAttr(c, 'lang') == "" ) {
						continue;
					}
					cc.collectContent(c, state);
				}

				if (isPre)
					_decrementFlag(state, 'preMode');

				if (oldListTypeOrNull) {
					_exitList(state, oldListTypeOrNull);
				}
			}
		}
		if (!browser.msie) {
			_reachBlockPoint(node, 1, state);
		}
		if (isBlock) {
			if (lines.length() - 1 == startLine) {
				_startNewLine(state);
			} else {
				_ensureColumnZero(state);
			}
		}

		if (browser.msie) {
			// in IE, a point immediately after a DIV appears on the next line
			//_reachBlockPoint(node, 1, state);
		}
	};
	// can pass a falsy value for end of doc
	cc.notifyNextNode = function(node) {
		// an "empty block" won't end a line; this addresses an issue in IE with
		// typing into a blank line at the end of the document. typed text
		// goes into the body, and the empty line div still looks clean.
		// it is incorporated as dirty by the rule that a dirty region has
		// to end a line.
		if ((!node) || (isBlockElement(node) && !_isEmpty(node))) {
			_ensureColumnZero(null);
		}
	};
	// each returns [line, char] or [-1,-1]
	var getSelectionStart = function() {
		return selStart;
	};
	var getSelectionEnd = function() {
		return selEnd;
	};

	// returns array of strings for lines found, last entry will be "" if
	// last line is complete (i.e. if a following span should be on a new line).
	// can be called at any point
	cc.getLines = function() {
		return lines.textLines();
	};

	// cc.applyHints = function(hints) {
	// if (hints.pastedLines) {
	//
	// }
	// }

	cc.finish = function() {
		lines.flush();
		var lineStrings = cc.getLines();

		if ( lineStrings.length > 0 && !lineStrings[lineStrings.length - 1] ) {
			lineStrings.length--;
		}

		var ss = getSelectionStart();
		var se = getSelectionEnd();

		function fixLongLines() {
			// design mode does not deal with with really long lines!
			var lineLimit = 2000; // chars
			var buffer = 10; // chars allowed over before wrapping
			var linesWrapped = 0;
			var numLinesAfter = 0;
			for ( var i = lineStrings.length - 1; i >= 0; i--) {
				var oldString = lineStrings[i];
				if (oldString.length > lineLimit + buffer) {
					var newStrings = [];
					while (oldString.length > lineLimit) {
						// var semiloc = oldString.lastIndexOf(';',
						// lineLimit-1);
						// var lengthToTake = (semiloc >= 0 ? (semiloc+1) :
						// lineLimit);
						lengthToTake = lineLimit;
						newStrings.push(oldString.substring(0, lengthToTake));
						oldString = oldString.substring(lengthToTake);

					}
					if (oldString.length > 0) {
						newStrings.push(oldString);
					}
					function fixLineNumber(lineChar) {
						if (lineChar[0] < 0)
							return;
						var n = lineChar[0];
						var c = lineChar[1];
						if (n > i) {
							n += (newStrings.length - 1);
						} else if (n == i) {
							var a = 0;
							while (c > newStrings[a].length) {
								c -= newStrings[a].length;
								a++;
							}
							n += a;
						}
						lineChar[0] = n;
						lineChar[1] = c;
					}
					fixLineNumber(ss);
					fixLineNumber(se);
					linesWrapped++;
					numLinesAfter += newStrings.length;

					newStrings.unshift(i, 1);
					lineStrings.splice.apply(lineStrings, newStrings);

				}
			}
			return {
				linesWrapped : linesWrapped,
				numLinesAfter : numLinesAfter
			};
		}
		var wrapData = fixLongLines();

		return {
			selStart : ss,
			selEnd : se,
			linesWrapped : wrapData.linesWrapped,
			numLinesAfter : wrapData.numLinesAfter,
			lines : lineStrings
		};
	};

	return cc;
}


