/**
 * Wikitext Syntax highlighter
 * http://www.mediawiki.org/wiki/User:Remember_the_dot/Syntax_highlighter
 * @author [[mw:User:Remember_the_dot]]
 */

define('WikiTextSyntaxHighlighter', ['wikia.window', 'wikia.document', 'wikia.log'], function (window, document, log) {
	'use strict';

	// Variables that are preserved between function calls
	var highlightSyntaxIfNeededIntervalID,
		initialized = false,
		lastText,
		/**
		 * @var maxSpanNumber The number of the last span available,
		 * used to tell if creating additional spans is necessary
		 */
		maxSpanNumber,
		syntaxHighlighterConfig,
		syntaxStyleTextNode,
		wpTextbox0,
		wpTextbox1,

		assumedBold,
		assumedItalic,
		before,
		css,
		lastColor,
		parserLocation,
		spanNumber,
		text,

		// Regex vars
		defaultBreakerRegex,
		headingBreakerRegex,
		namedExternalLinkBreakerRegex,
		parameterBreakerRegex,
		tableBreakerRegex,
		tagBreakerRegexCache,
		templateBreakerRegex,
		wikilinkBreakerRegex,
		breakerRegexBase;

	/* Define context-specific regexes, one for every common token that ends the
	current context.

	An attempt has been made to search for the most common syntaxes first,
	thus maximizing performance. Syntaxes that begin with the same character
	are searched for at the same time.

	Supported wiki syntaxes from most common to least common:
	[[internal link]] [http:// named external link]
	{{template}} {{{template parameter}}} {| table |}
	<tag> <!-- comment -->
	http:// bare external link
	=Heading= * unordered list # ordered list : indent ; small heading ---- horizontal line
	''italic'' '''bold'''
	three tildes username four tildes signature five tildes timestamp
	&entity;

	The tag-matching regex follows the XML standard closely so that users
	won't feel like they have to escape sequences that MediaWiki will never
	consider to be tags.

	Only entities for characters which need to be escaped or cannot be
	unambiguously represented in a monospace font are highlighted, such as
	Greek letters that strongly resemble Latin letters. Use of other entities
	is discouraged as a matter of style. For the same reasons, numeric
	entities should be in hexadecimal (giving character codes in decimal only
	adds confusion).

	Newlines are sucked up into ending tokens (including comments, bare
	external links, lists, horizontal lines, signatures, entities, etc.) to
	avoid creating spans with nothing but newlines in them.

	Flags: g for global search, m for make ^ match the beginning of each line
	and $ the end of each line
	*/
	breakerRegexBase = "\\[(?:\\[|(?:https?:|ftp:)?//|mailto:)|\\{(?:\\{\\{?|\\|)|<(?:[:A-Z_a-z\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02FF\u0370-\u037D\u037F-\u1FFF\u200C\u200D\u2070-\u218F\u2C00-\u2FEF\u3001-\uD7FF\uF900-\uFDCF\uFDF0-\uFFFD][:\\w\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02FF\u0370-\u037D\u037F-\u1FFF\u200C\u200D\u2070-\u218F\u2C00-\u2FEF\u3001-\uD7FF\uF900-\uFDCF\uFDF0-\uFFFD-\\.\u00B7\u0300-\u036F\u203F-\u203F-\u2040]*(?=/?>| |\n)|!--[^]*?-->\n*)|(?:https?://|ftp://|mailto:)[^\\s\"<>[\\]{-}]*[^\\s\",\\.:;<>[\\]{-}]\n*|^(?:=|[*#:;]+\n*|-{4,}\n*)|\\\\'\\\\'(?:\\\\')?|~{3,5}\n*|&(?:(?:n(?:bsp|dash)|m(?:dash|inus)|lt|e[mn]sp|thinsp|amp|quot|gt|shy|zwn?j|lrm|rlm|Alpha|Beta|Epsilon|Zeta|Eta|Iota|Kappa|[Mm]u|micro|Nu|[Oo]micron|[Rr]ho|Tau|Upsilon|Chi)|#x[0-9a-fA-F]+);\n*";

	function breakerRegexWithPrefix (prefix) {
		// The stop token has to be at the beginning of the regex so that it takes precedence
		// over substrings of itself.
		return new RegExp('(' + prefix + ')\n*|' + breakerRegexBase, 'gm');
	}

	// Writes text into to-be-created span elements of wpTextbox0 using :before and :after pseudo-elements
	// both :before and :after are used because using two pseudo-elements per span is significantly faster
	// than doubling the number of spans required
	function writeText (text, color) {
		// No need to use another span if using the same color
		if (color !== lastColor) {
			// Whitespace is omitted in the hope of increasing performance
			css += '\'}#s' + spanNumber; //spans will be created with IDs s0 through sN
			if (before) {
				css += ':before{';
				before = false;
			}
			else {
				css += ':after{';
				before = true;
				++spanNumber;
			}
			if (color) {
				// 'background-color' is 6 characters longer than 'background' but the browser processes it faster
				css += 'background-color:' + color + ';';
			}
			css += 'content:\'';
			lastColor = color;
		}
		css += text;
	}

	function highlightSyntax () {
		var startTime, endTime, diffTime,
			fragment;

		lastText = wpTextbox1.value;

		/* Backslashes and apostrophes are CSS-escaped at the beginning and all
		parsing regexes and functions are designed to match. On the other hand,
		newlines are not escaped until written so that in the regexes ^ and $
		work for both newlines and the beginning or end of the string. */
		text = lastText.replace(/['\\]/g, '\\$&') + '\n'; //add a newline to fix scrolling and parsing issues
		parserLocation = 0; //the location of the parser as it goes through var text

		before = true;
		css = '';
		lastColor = undefined;
		spanNumber = 0;

		/* Highlighting bold or italic markup presents a special challenge
		because the actual MediaWiki parser uses multiple passes to determine
		which ticks represent start tags and which represent end tags.
		Because that would be too slow for us here, we instead keep track of
		what kinds of unclosed opening ticks have been encountered and use
		that to make a good guess as to whether the next ticks encountered
		are an opening tag or a closing tag.

		The major downsides to this method are that '''apostrophe italic''
		and ''italic apostrophe''' are not highlighted correctly, and bold
		and italic are both highlighted in the same color. */
		assumedBold = false;
		assumedItalic = false;

		// Start!
		startTime = Date.now();
		highlightBlock('', defaultBreakerRegex);

		// Output the leftovers (if any) to make sure whitespace etc. matches
		if (parserLocation < text.length) {
			writeText(text.substring(parserLocation), '');
		}

		// If highlighting took too long, disable it.
		endTime = Date.now();
		diffTime = endTime - startTime;

		if (diffTime > syntaxHighlighterConfig.timeout) {
			resetHighlightSyntax(diffTime);
			return;
		}

		// Do we have enough span elements to match the generated CSS?
		// This step isn't included in the above benchmark because it takes a highly variable amount of time
		if (maxSpanNumber < spanNumber) {
			fragment = document.createDocumentFragment();
			do {
				fragment.appendChild(document.createElement('span')).id = 's' + (++maxSpanNumber);
			}
			while (maxSpanNumber < spanNumber);
			wpTextbox0.appendChild(fragment);
		}

		/* Finish CSS: move the extra '} from the beginning to the end and CSS-
		escape newlines. CSS ignores the space after the hex code of the
		escaped character */
		syntaxStyleTextNode.nodeValue = css.substring(2).replace(/\n/g, '\\A ') + '\'}';
	}

	function resetHighlightSyntax(diffTime) {
		if (initialized) {
			clearInterval(highlightSyntaxIfNeededIntervalID);

			wpTextbox1.removeEventListener('input', debounceHighlightSyntax);
			wpTextbox1.removeEventListener('scroll', syncScrollX);
			wpTextbox1.removeEventListener('scroll', syncScrollY);

			syntaxStyleTextNode.nodeValue = '';

			if (diffTime) {
				log('Syntax highlighting took too long. The maximum allowed ' +
					'highlighting time is ' + syntaxHighlighterConfig.timeout +
					', and your computer took ' + diffTime + '.');
			}
		}
	}

	function highlightBlock (color, breakerRegex) {
		var match, endIndexOfLastColor,
			tagEnd, tagName,
			stopAfter, endIndex;

		for (
			breakerRegex.lastIndex = parserLocation;
			match = breakerRegex.exec(text);
			breakerRegex.lastIndex = parserLocation
		) {
			if (match[1]) {
				// End token found
				writeText(text.substring(parserLocation, breakerRegex.lastIndex), color);
				parserLocation = breakerRegex.lastIndex;
				return;
			}

			endIndexOfLastColor = breakerRegex.lastIndex - match[0].length;
			// Avoid calling writeText with text == '' to improve performance
			if (parserLocation < endIndexOfLastColor) {
				writeText(text.substring(parserLocation, endIndexOfLastColor), color);
			}

			parserLocation = breakerRegex.lastIndex;

			// Cases in this switch should be arranged from most common to least common
			switch (match[0].charAt(0)) {
				case '[':
					if (match[0].charAt(1) === '[') {
						// wikilink
						writeText('[[', syntaxHighlighterConfig.wikilinkColor || color);
						highlightBlock(
							syntaxHighlighterConfig.wikilinkColor || color,
							wikilinkBreakerRegex
						);
					}
					else {
						// named external link
						writeText(match[0], syntaxHighlighterConfig.externalLinkColor || color);
						highlightBlock(
							syntaxHighlighterConfig.externalLinkColor || color,
							namedExternalLinkBreakerRegex
						);
					}
					break;
				case '{':
					if (match[0].charAt(1) === '{') {
						if (match[0].length === 3) {
							// parameter
							writeText('{{{', syntaxHighlighterConfig.parameterColor || color);
							highlightBlock(
								syntaxHighlighterConfig.parameterColor || color,
								parameterBreakerRegex
							);
						}
						else {
							// template
							writeText('{{', syntaxHighlighterConfig.templateColor || color);
							highlightBlock(
								syntaxHighlighterConfig.templateColor || color,
								templateBreakerRegex
							);
						}
					}
					else {// |
						// table
						writeText('{|', syntaxHighlighterConfig.tableColor || color);
						highlightBlock(
							syntaxHighlighterConfig.tableColor || color,
							tableBreakerRegex
						);
					}
					break;
				case '<':
					if (match[0].charAt(1) === '!') {
						// comment tag
						writeText(match[0], syntaxHighlighterConfig.commentColor || color);
						break;
					}
					else {
						// Some other kind of tag, search for its end
						// the search is made easier because XML attributes may not contain the character '>'
						tagEnd = text.indexOf('>', parserLocation) + 1;
						tagName = match[0].substring(1);
						if (tagEnd === 0) {
							// Not a tag, just a '<' with some text after it
							writeText('<', color);
							parserLocation = parserLocation - match[0].length + 1;
							break;
						}

						if (text.charAt(tagEnd - 2) === '/' || tagName === 'br') {
							// empty tag
							writeText(
								text.substring(parserLocation - match[0].length, tagEnd),
								syntaxHighlighterConfig.tagColor || color
							);
							parserLocation = tagEnd;
						}
						// Again, cases are ordered from most common to least common
						else if (/^(?:nowiki|pre|math|syntaxhighlight|source|timeline|hiero)$/.test(tagName)) {
							//tag that can contain only plain text
							stopAfter = '</' + tagName + '>';
							endIndex = text.indexOf(stopAfter, parserLocation);
							if (endIndex === -1) {
								endIndex = text.length;
							}
							else {
								endIndex += stopAfter.length;
							}
							writeText(
								text.substring(parserLocation - match[0].length, endIndex),
								syntaxHighlighterConfig.tagColor || color
							);
							parserLocation = endIndex;
						}
						else {
							// ordinary tag
							writeText(
								text.substring(parserLocation - match[0].length, tagEnd),
								syntaxHighlighterConfig.tagColor || color
							);
							parserLocation = tagEnd;
							if (!tagBreakerRegexCache[tagName]) {
								tagBreakerRegexCache[tagName] = breakerRegexWithPrefix('</' + tagName + '>');
							}
							highlightBlock(
								syntaxHighlighterConfig.tagColor || color,
								tagBreakerRegexCache[tagName]
							);
						}
					}
					break;
				case 'h':
				case 'f':
				case 'm':
					// bare external link
					writeText(match[0], syntaxHighlighterConfig.externalLinkColor || color);
					break;
				case '=':
					if (/[^=]=+$/.test(text.substring(parserLocation, text.indexOf('\n', parserLocation)))) {
						// The line begins and ends with an equals sign and has something else in the middle
						// Heading
						writeText('=', syntaxHighlighterConfig.headingColor || color);
						highlightBlock(syntaxHighlighterConfig.headingColor || color, headingBreakerRegex);
					}
					else {
						writeText('=', color); // move on, process this line as regular wikitext
					}
					break;
				case '*':
				case '#':
				case ':':
					// unordered list, ordered list, indent, small heading
					// just highlight the marker
					writeText(match[0], syntaxHighlighterConfig.listOrIndentColor || color);
					break;
				case ';':
					// small heading
					writeText(';', syntaxHighlighterConfig.headingColor || color);
					highlightBlock(syntaxHighlighterConfig.headingColor || color, headingBreakerRegex);
					break;
				case '-':
					// horizontal line
					writeText(match[0], syntaxHighlighterConfig.hrColor || color);
					break;
				case '\\':
					writeText(match[0], syntaxHighlighterConfig.boldOrItalicColor || color);
					if (match[0].length === 6) {
						// bold
						if (assumedBold) {
							// end tag
							assumedBold = false;
							return;
						}
						else {
							// start tag
							assumedBold = true;
							highlightBlock(
								syntaxHighlighterConfig.boldOrItalicColor || color,
								defaultBreakerRegex
							);
						}
					}
					else {
						// italic
						if (assumedItalic) {
							// end tag
							assumedItalic = false;
							return;
						}
						else {
							// start tag
							assumedItalic = true;
							highlightBlock(
								syntaxHighlighterConfig.boldOrItalicColor || color,
								defaultBreakerRegex
							);
						}
					}
					break;
				case '&':
					// entity
					writeText(match[0], syntaxHighlighterConfig.entityColor || color);
					break;
				case '~':
					// username, signature, timestamp
					writeText(match[0], syntaxHighlighterConfig.signatureColor || color);
			}
		}
	}

	function syncScrollX () {
		wpTextbox0.scrollLeft = wpTextbox1.scrollLeft;
	}

	function syncScrollY () {
		wpTextbox0.scrollTop = wpTextbox1.scrollTop;
	}

	/**
	 * This function runs once every 500ms to detect changes to wpTextbox1's text that the input event does not catch.
	 * This happens when another script changes the text without knowing that the syntax highlighter needs to be
	 * informed
	 */
	function highlightSyntaxIfNeeded () {
		if (wpTextbox1.value !== lastText) {
			highlightSyntax();
		}
		if (wpTextbox1.scrollLeft !== wpTextbox0.scrollLeft) {
			syncScrollX();
		}
		if (wpTextbox1.scrollTop !== wpTextbox0.scrollTop) {
			syncScrollY();
		}
		if (wpTextbox1.offsetHeight !== wpTextbox0.offsetHeight) {
			wpTextbox0.style.height = wpTextbox1.offsetHeight + 'px';
		}
	}

	function debounceHighlightSyntax() {
		$.debounce(50, highlightSyntax);
	}

	function setup (textarea) {
		var focus,
			scrollTop,
			syntaxStyleElement,
			textboxContainer,
			wpTextbox1Style;

		wpTextbox0 = document.createElement('div');
		wpTextbox0.id = 'wpTextbox0';

		wpTextbox1 = textarea;
		wpTextbox1.id = 'wpTextbox1';
		wpTextbox1.classList.add('highlighted');

		syntaxHighlighterConfig.timeout = syntaxHighlighterConfig.timeout || 50;

		textboxContainer = document.createElement('div');
		syntaxStyleElement = document.createElement('style');
		syntaxStyleTextNode = syntaxStyleElement.appendChild(document.createTextNode(''));

		// The styling of the textbox and the background div must be kept very similar
		wpTextbox1Style = window.getComputedStyle(wpTextbox1);

		scrollTop = wpTextbox1.scrollTop;
		focus = (document.activeElement === wpTextbox1);

		wpTextbox0.dir = wpTextbox1.dir;
		wpTextbox0.lang = wpTextbox1.lang; // Lang determines which font 'monospace' is

		wpTextbox0.style.backgroundColor = wpTextbox1Style.backgroundColor;

		wpTextbox0.style.fontFamily = wpTextbox1Style.fontFamily;
		wpTextbox0.style.fontSize = wpTextbox1Style.fontSize;
		// Horizontal resize would look horribly choppy, better to make the user resize the browser window instead
		wpTextbox0.style.resize = (wpTextbox1Style.resize === 'vertical' ||
		wpTextbox1Style.resize === 'both' ? 'vertical' : 'none');
		wpTextbox0.style.tabSize = wpTextbox1Style.tabSize;

		wpTextbox1.style.cssText += 'background-color: transparent !important';
		wpTextbox1.style.fontSize = wpTextbox1Style.fontSize; // Resolves alignment problems on mobile chrome
		wpTextbox1.style.resize = wpTextbox0.style.resize;

		// Lock both heights to pixel values so that the browser zoom feature works better
		wpTextbox0.style.height = wpTextbox1.offsetHeight + 'px';
		wpTextbox1.style.height = wpTextbox0.style.height;

		textboxContainer.style.clear = 'both';
		textboxContainer.style.position = 'relative';

		wpTextbox1.parentNode.insertBefore(textboxContainer, wpTextbox1);
		textboxContainer.appendChild(wpTextbox1);
		textboxContainer.appendChild(wpTextbox0);

		// Changing the parent resets scrollTop to 0 and removes focus, so we have to bring that back
		wpTextbox0.scrollTop = scrollTop;
		wpTextbox1.scrollTop = scrollTop;
		if (focus) {
			wpTextbox1.focus();
		}

		// Fix drop-downs in editing toolbar
		$('.tool-select *').css({zIndex: 5});

		document.head.appendChild(syntaxStyleElement);

		$(wpTextbox1).on('input', debounceHighlightSyntax);
		wpTextbox1.addEventListener('scroll', syncScrollX);
		wpTextbox1.addEventListener('scroll', syncScrollY);
		highlightSyntaxIfNeededIntervalID = setInterval(highlightSyntaxIfNeeded, 500);
		highlightSyntax();

		initialized = true;
	}

	function queueSetup (textarea) {
		setTimeout(function () {
			setup(textarea);
		}, 0);
	}

	function init (textarea, config) {
		maxSpanNumber = -1;

		defaultBreakerRegex = new RegExp(breakerRegexBase, 'gm');
		wikilinkBreakerRegex = breakerRegexWithPrefix(']][a-zA-Z]*');
		namedExternalLinkBreakerRegex = breakerRegexWithPrefix(']');
		parameterBreakerRegex = breakerRegexWithPrefix('}}}');
		templateBreakerRegex = breakerRegexWithPrefix('}}');
		tableBreakerRegex = breakerRegexWithPrefix('\\|}');
		headingBreakerRegex = breakerRegexWithPrefix('\n');
		tagBreakerRegexCache = {};

		syntaxHighlighterConfig = config;

		/* The highlighter has to run after any other script (such as the
		editing toolbar) that reparents wpTextbox1. We make sure that
		everything else has run by waiting for the page to completely load
		and then adding a call to the setup function to the end of the event
		queue, so that the setup function runs after any other triggers set
		on the load event. */
		if (document.readyState === 'complete') {
			queueSetup(textarea);
		}
		else {
			$(window).load(queueSetup(textarea));
		}
	}

	return {
		init: init,
		reset: resetHighlightSyntax
	};
});
