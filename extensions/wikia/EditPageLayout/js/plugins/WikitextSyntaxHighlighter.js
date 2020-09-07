//Syntax highlighter with various advantages
//See [[User:Remember the dot/Syntax highlighter]] for more information

/* This file may be used under the terms of any of the following
   licenses, as well as any later version of the same licenses:

   GNU General Public License 2.0
   <https://www.gnu.org/licenses/old-licenses/gpl-2.0.html>

   Creative Commons Attribution-ShareAlike 3.0 Unported License
   <https://creativecommons.org/licenses/by-sa/3.0/>

   GNU Free Documentation License 1.2
   <https://www.gnu.org/licenses/old-licenses/fdl-1.2.html>
*/

define('WikiTextSyntaxHighlighter', ['wikia.window', 'wikia.document'], function (window, document) {
	"use strict";

	//variables that are preserved between function calls
	/**
	 * Fandom change
	 * - variable added
	 */
	var isInitialized = false;
	var wpTextbox0;
	var wpTextbox1;
	var syntaxStyleTextNode;
	var lastText;
	var maxSpanNumber = -1; //the number of the last span available, used to tell if creating additional spans is necessary
	var highlightSyntaxIfNeededIntervalID;
	var attributeObserver;
	var parentObserver;
	var syntaxHighlighterConfig;

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
	var wgUrlProtocols = mw.config.get("wgUrlProtocols");
	var entityRegexBase = "&(?:(?:n(?:bsp|dash)|m(?:dash|inus)|lt|e[mn]sp|thinsp|amp|quot|gt|shy|zwn?j|lrm|rlm|Alpha|Beta|Epsilon|Zeta|Eta|Iota|Kappa|[Mm]u|micro|Nu|[Oo]micron|[Rr]ho|Tau|Upsilon|Chi)|#x[0-9a-fA-F]+);\n*";
	var breakerRegexBase = "\\[(?:\\[|(?:" + wgUrlProtocols + "))|\\{(?:\\{\\{?|\\|)|<(?:[:A-Z_a-z\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02FF\u0370-\u037D\u037F-\u1FFF\u200C\u200D\u2070-\u218F\u2C00-\u2FEF\u3001-\uD7FF\uF900-\uFDCF\uFDF0-\uFFFD][:\\w\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02FF\u0370-\u037D\u037F-\u1FFF\u200C\u200D\u2070-\u218F\u2C00-\u2FEF\u3001-\uD7FF\uF900-\uFDCF\uFDF0-\uFFFD-\\.\u00B7\u0300-\u036F\u203F-\u203F-\u2040]*(?=/?>| |\n)|!--[^]*?-->\n*)|(?:" + wgUrlProtocols.replace("|\\/\\/", "") + ")[^\\s\"<>[\\]{-}]*[^\\s\",\\.:;<>[\\]{-}]\n*|^(?:=|[*#:;]+\n*|-{4,}\n*)|\\\\'\\\\'(?:\\\\')?|~{3,5}\n*|" + entityRegexBase;

	function breakerRegexWithPrefix(prefix) {
		//the stop token has to be at the beginning of the regex so that it takes precedence over substrings of itself.
		return new RegExp("(" + prefix + ")\n*|" + breakerRegexBase, "gm");
	}

	function nowikiTagBreakerRegex(tagName) {
		return new RegExp("(</" + tagName + ">)\n*|" + entityRegexBase, "gm");
	}

	var defaultBreakerRegex = new RegExp(breakerRegexBase, "gm");
	var wikilinkBreakerRegex = breakerRegexWithPrefix("]][a-zA-Z]*");
	var namedExternalLinkBreakerRegex = breakerRegexWithPrefix("]");
	var parameterBreakerRegex = breakerRegexWithPrefix("}}}");
	var templateBreakerRegex = breakerRegexWithPrefix("}}");
	var tableBreakerRegex = breakerRegexWithPrefix("\\|}");
	var headingBreakerRegex = breakerRegexWithPrefix("\n");
	var tagBreakerRegexCache = {};
	var nowikiTagBreakerRegexCache = {};

	function highlightSyntax() {
		lastText = wpTextbox1.value;
		/* Backslashes and apostrophes are CSS-escaped at the beginning and all
		   parsing regexes and functions are designed to match. On the other hand,
		   newlines are not escaped until written so that in the regexes ^ and $
		   work for both newlines and the beginning or end of the string. */
		var text = lastText.replace(/['\\]/g, "\\$&") + "\n"; //add a newline to fix scrolling and parsing issues
		var i = 0; //the location of the parser as it goes through var text

		var css = "";
		var spanNumber = 0;
		var lastColor;
		var before = true;

		//writes text into to-be-created span elements of wpTextbox0 using :before and :after pseudo-elements
		//both :before and :after are used because using two pseudo-elements per span is significantly faster than doubling the number of spans required
		function writeText(text, color) {
			//no need to use another span if using the same color
			if (color !== lastColor) {
				//whitespace is omitted in the hope of increasing performance
				css += "'}#s" + spanNumber; //spans will be created with IDs s0 through sN
				if (before) {
					css += ":before{";
					before = false;
				} else {
					css += ":after{";
					before = true;
					++spanNumber;
				}
				if (color) {
					//"background-color" is 6 characters longer than "background" but the browser processes it faster
					css += "background-color:" + color + ";";
				}
				css += "content:'";
				lastColor = color;
			}
			css += text;
		}

		/* About assumedBold and assumedItalic:

		   Highlighting bold or italic markup presents a special challenge
		   because the actual MediaWiki parser uses multiple passes to determine
		   which ticks represent start tags and which represent end tags.
		   Because that would be too slow for us here, we instead keep track of
		   what kinds of unclosed opening ticks have been encountered and use
		   that to make a good guess as to whether the next ticks encountered
		   are an opening tag or a closing tag.

		   The major downsides to this method are that '''apostrophe italic''
		   and ''italic apostrophe''' are not highlighted correctly, and bold
		   and italic are both highlighted in the same color.

		   To permit ''The best<ref>''Reference Title''</ref> book ever'',
		   assumedBold and assumedItalic are saved on the stack and reset to
		   undefined (essentially, false) when recursing into a new block. */

		function highlightBlock(color, breakerRegex, assumedBold, assumedItalic) {
			var match;

			for (breakerRegex.lastIndex = i; match = breakerRegex.exec(text); breakerRegex.lastIndex = i) {
				if (match[1]) {
					//end token found
					writeText(text.substring(i, breakerRegex.lastIndex), color);
					i = breakerRegex.lastIndex;
					return;
				}

				var endIndexOfLastColor = breakerRegex.lastIndex - match[0].length;
				if (i < endIndexOfLastColor) //avoid calling writeText with text === "" to improve performance
				{
					writeText(text.substring(i, endIndexOfLastColor), color);
				}

				i = breakerRegex.lastIndex;

				switch (match[0].charAt(0)) //cases in this switch should be arranged from most common to least common
				{
					case "[":
						if (match[0].charAt(1) === "[") {
							//wikilink
							writeText("[[", syntaxHighlighterConfig.wikilinkColor || color);
							highlightBlock(syntaxHighlighterConfig.wikilinkColor || color, wikilinkBreakerRegex);
						} else {
							//named external link
							writeText(match[0], syntaxHighlighterConfig.externalLinkColor || color);
							highlightBlock(syntaxHighlighterConfig.externalLinkColor || color, namedExternalLinkBreakerRegex);
						}
						break;
					case "{":
						if (match[0].charAt(1) === "{") {
							if (match[0].length === 3) {
								//parameter
								writeText("{{{", syntaxHighlighterConfig.parameterColor || color);
								highlightBlock(syntaxHighlighterConfig.parameterColor || color, parameterBreakerRegex);
							} else {
								//template
								writeText("{{", syntaxHighlighterConfig.templateColor || color);
								highlightBlock(syntaxHighlighterConfig.templateColor || color, templateBreakerRegex);
							}
						} else //|
						{
							//table
							writeText("{|", syntaxHighlighterConfig.tableColor || color);
							highlightBlock(syntaxHighlighterConfig.tableColor || color, tableBreakerRegex);
						}
						break;
					case "<":
						if (match[0].charAt(1) === "!") {
							//comment tag
							writeText(match[0], syntaxHighlighterConfig.commentColor || color);
							break;
						} else {
							//some other kind of tag, search for its end
							//the search is made easier because XML attributes may not contain the character ">"
							var tagEnd = text.indexOf(">", i) + 1;
							/**
							 * Fandom change
							 * - variable was moved here from nested `else` block
							 * - variable is used in `if` statement below
							 */
							var tagName = match[0].substring(1);

							if (tagEnd === 0) {
								//not a tag, just a "<" with some text after it
								writeText("<", color);
								i = i - match[0].length + 1;
								break;
							}

							if (text.charAt(tagEnd - 2) === "/" || tagName === "br") {
								//empty tag
								writeText(text.substring(i - match[0].length, tagEnd), syntaxHighlighterConfig.tagColor || color);
								i = tagEnd;
							} else {
								if (syntaxHighlighterConfig.sourceTags.indexOf(tagName) !== -1) {
									//tag that contains text in a different programming language
									var stopAfter = "</" + tagName + ">";
									var endIndex = text.indexOf(stopAfter, i);
									if (endIndex === -1) {
										endIndex = text.length;
									} else {
										endIndex += stopAfter.length;
									}
									writeText(text.substring(i - match[0].length, endIndex), syntaxHighlighterConfig.tagColor || color);
									i = endIndex;
								} else if (syntaxHighlighterConfig.nowikiTags.indexOf(tagName) !== -1) {
									//tag that can contain only HTML entities
									writeText(text.substring(i - match[0].length, tagEnd), syntaxHighlighterConfig.tagColor || color);
									i = tagEnd;
									highlightBlock(syntaxHighlighterConfig.tagColor || color, nowikiTagBreakerRegexCache[tagName]);
								} else {
									//ordinary tag
									writeText(text.substring(i - match[0].length, tagEnd), syntaxHighlighterConfig.tagColor || color);
									i = tagEnd;
									if (!tagBreakerRegexCache[tagName]) {
										tagBreakerRegexCache[tagName] = breakerRegexWithPrefix("</" + tagName + ">");
									}
									highlightBlock(syntaxHighlighterConfig.tagColor || color, tagBreakerRegexCache[tagName]);
								}
							}
						}
						break;
					case "=":
						if (/[^=]=+$/.test(text.substring(i, text.indexOf("\n", i)))) //the line begins and ends with an equals sign and has something else in the middle
						{
							//heading
							writeText("=", syntaxHighlighterConfig.headingColor || color);
							highlightBlock(syntaxHighlighterConfig.headingColor || color, headingBreakerRegex);
						} else {
							writeText("=", color); //move on, process this line as regular wikitext
						}
						break;
					case "*":
					case "#":
					case ":":
						//unordered list, ordered list, indent, small heading
						//just highlight the marker
						writeText(match[0], syntaxHighlighterConfig.listOrIndentColor || color);
						break;
					case ";":
						//small heading
						writeText(";", syntaxHighlighterConfig.headingColor || color);
						highlightBlock(syntaxHighlighterConfig.headingColor || color, headingBreakerRegex);
						break;
					case "-":
						//horizontal line
						writeText(match[0], syntaxHighlighterConfig.hrColor || color);
						break;
					case "\\":
						writeText(match[0], syntaxHighlighterConfig.boldOrItalicColor || color);
						if (match[0].length === 6) {
							//bold
							if (assumedBold) {
								//end tag
								if (assumedItalic) {
									//end of bold part of bold-italic block
									//block is now italic-only
									assumedBold = false;
								} else {
									//end of bold block
									return;
								}
							} else {
								//start tag
								if (assumedItalic) {
									//start of bold part of previously italic-only block
									//block is now bold-italic
									assumedBold = true;
								} else {
									//start of bold block
									highlightBlock(syntaxHighlighterConfig.boldOrItalicColor || color, defaultBreakerRegex, true, false);
								}
							}
						} else {
							//italic
							if (assumedItalic) {
								//end tag
								if (assumedBold) {
									//end of italic part of bold-italic block
									//block is now bold-only
									assumedItalic = false;
								} else {
									//end of italic block
									return;
								}
							} else {
								//start tag
								if (assumedBold) {
									//start of italic part of previously bold-only block
									//block is now bold-italic
									assumedItalic = true;
								} else {
									//start of italic block
									highlightBlock(syntaxHighlighterConfig.boldOrItalicColor || color, defaultBreakerRegex, false, true);
								}
							}
						}
						break;
					case "&":
						//entity
						writeText(match[0], syntaxHighlighterConfig.entityColor || color);
						break;
					case "~":
						//username, signature, timestamp
						writeText(match[0], syntaxHighlighterConfig.signatureColor || color);
						break;
					default:
						//bare external link
						writeText(match[0], syntaxHighlighterConfig.externalLinkColor || color);
				}
			}
		}

		//start!
		var startTime = Date.now();
		highlightBlock("", defaultBreakerRegex);

		//output the leftovers (if any) to make sure whitespace etc. matches
		if (i < text.length) {
			writeText(text.substring(i), "");
		}

		//if highlighting took too long, disable it.
		var endTime = Date.now();
		/*if (typeof(bestTime) === "undefined")
		{
			window.bestTime = endTime - startTime;
			document.title = bestTime;
			highlightSyntaxIfNeededIntervalID = setInterval(highlightSyntax, 250);
		}
		else
		{
			if (endTime - startTime < bestTime)
			{
				bestTime = endTime - startTime;
				document.title = bestTime;
			}
		}//*/

		/**
		 * Fandom change
		 * - content of `if` statement was extracted to a separate function
		 */
		if (endTime - startTime > syntaxHighlighterConfig.timeout) {
			resetHighlightSyntax(endTime - startTime);

			return;
		}

		//do we have enough span elements to match the generated CSS?
		//this step isn't included in the above benchmark because it takes a highly variable amount of time
		if (maxSpanNumber < spanNumber) {
			var fragment = document.createDocumentFragment();
			do {
				fragment.appendChild(document.createElement("span")).id = "s" + ++maxSpanNumber;
			}
			while (maxSpanNumber < spanNumber);
			wpTextbox0.appendChild(fragment);
		}

		/* finish CSS: move the extra '} from the beginning to the end and CSS-
		   escape newlines. CSS ignores the space after the hex code of the
		   escaped character */
		syntaxStyleTextNode.nodeValue = css.substring(2).replace(/\n/g, "\\A ") + "'}";
	}

	function syncScrollX() {
		wpTextbox0.scrollLeft = wpTextbox1.scrollLeft;
	}

	function syncScrollY() {
		wpTextbox0.scrollTop = wpTextbox1.scrollTop;
	}

	function syncTextDirection() {
		wpTextbox0.dir = wpTextbox1.dir;
	}

	function syncParent() {
		if (wpTextbox1.previousSibling !== wpTextbox0) {
			wpTextbox1.parentNode.insertBefore(wpTextbox0, wpTextbox1);
			parentObserver.disconnect();
			parentObserver.observe(wpTextbox1.parentNode, {childList: true});
		}
	}

	//this function runs once every 500ms to detect changes to wpTextbox1's text that the input event does not catch
	//this happens when another script changes the text without knowing that the syntax highlighter needs to be informed
	function highlightSyntaxIfNeeded() {
		if (wpTextbox1.value !== lastText) {
			highlightSyntax();
		}
		if (wpTextbox1.scrollLeft !== wpTextbox0.scrollLeft) {
			syncScrollX();
		}
		if (wpTextbox1.scrollTop !== wpTextbox0.scrollTop) {
			syncScrollY();
		}
		/**
		 * Fandom change
		 * - new condition in `if` statement
		 */
		if (
			( wpTextbox1.offsetHeight !== wpTextbox0.offsetHeight ) ||
			( wpTextbox1.getBoundingClientRect().top !== wpTextbox0.getBoundingClientRect().top )
		) {
			var height = wpTextbox1.offsetHeight + "px";
			wpTextbox0.style.height = height;
			wpTextbox1.style.marginTop = "-" + height;
		}
	}

	/**
	 * Fandom change
	 * - argument `texarea` added
	 * - removed support for syntaxHighlighterSiteConfig
	 */
	function setup(textarea) {
		function configureColor(parameterName, hardcodedFallback, defaultOk) {
			if (syntaxHighlighterConfig[parameterName] === "normal") {
				syntaxHighlighterConfig[parameterName] = hardcodedFallback;
			} else if (typeof (syntaxHighlighterConfig[parameterName]) !== "undefined") {
				return;
			} else if (typeof (syntaxHighlighterConfig.defaultColor) !== "undefined" && defaultOk) {
				syntaxHighlighterConfig[parameterName] = syntaxHighlighterConfig.defaultColor;
			} else {
				syntaxHighlighterConfig[parameterName] = hardcodedFallback;
			}
		}

		window.syntaxHighlighterConfig = window.syntaxHighlighterConfig || syntaxHighlighterConfig;

		//use 3-digit colors instead of 6-digit colors for performance
		configureColor("backgroundColor", "#FFF", false); //white
		configureColor("foregroundColor", "#000", false); //black
		configureColor("boldOrItalicColor", "#EEE", true);  //gray
		configureColor("commentColor", "#EFE", true);  //green
		configureColor("entityColor", "#DFD", true);  //green
		configureColor("externalLinkColor", "#EFF", true);  //cyan
		configureColor("headingColor", "#EEE", true);  //gray
		configureColor("hrColor", "#EEE", true);  //gray
		configureColor("listOrIndentColor", "#EFE", true);  //green
		configureColor("parameterColor", "#FC6", true);  //orange
		configureColor("signatureColor", "#FC6", true);  //orange
		configureColor("tagColor", "#FEF", true);  //pink
		configureColor("tableColor", "#FFC", true);  //yellow
		configureColor("templateColor", "#FFC", true);  //yellow
		configureColor("wikilinkColor", "#EEF", true);  //blue

		//tag lists are ordered from most common to least common
		syntaxHighlighterConfig.nowikiTags = syntaxHighlighterConfig.nowikiTags || ["nowiki", "pre"];
		syntaxHighlighterConfig.sourceTags = syntaxHighlighterConfig.sourceTags || ["math", "syntaxhighlight", "source", "timeline", "hiero"];
		syntaxHighlighterConfig.timeout = syntaxHighlighterConfig.timeout || 200;

		syntaxHighlighterConfig.nowikiTags.forEach(function (tagName) {
			nowikiTagBreakerRegexCache[tagName] = nowikiTagBreakerRegex(tagName);
		});

		wpTextbox0 = document.createElement("div");

		/**
		 * Fandom change
		 * - line was added
		 */
		wpTextbox1 = textarea;

		var syntaxStyleElement = document.createElement("style");
		syntaxStyleTextNode = syntaxStyleElement.appendChild(document.createTextNode(""));

		//the styling of the textbox and the background div must be kept very similar
		var wpTextbox1Style = window.getComputedStyle(wpTextbox1);

		//horizontal resize would look horribly choppy, better to make the user resize the browser window instead
		var resize = (wpTextbox1Style.resize === "vertical" || wpTextbox1Style.resize === "both" ? "vertical" : "none");

		wpTextbox0.dir = wpTextbox1.dir;
		wpTextbox0.id = "wpTextbox0";
		wpTextbox0.lang = wpTextbox1.lang; //lang determines which font "monospace" is

		/**
		 * Fandom change
		 * - source of color was changed
		 */
		wpTextbox0.style.backgroundColor = wpTextbox1Style.backgroundColor;
		wpTextbox0.style.borderBottomLeftRadius = wpTextbox1Style.borderBottomLeftRadius;
		wpTextbox0.style.borderBottomRightRadius = wpTextbox1Style.borderBottomRightRadius;
		wpTextbox0.style.borderBottomStyle = wpTextbox1Style.borderBottomStyle;
		wpTextbox0.style.borderBottomWidth = wpTextbox1Style.borderBottomWidth;
		wpTextbox0.style.borderColor = "transparent";
		wpTextbox0.style.borderLeftStyle = wpTextbox1Style.borderLeftStyle;
		wpTextbox0.style.borderLeftWidth = wpTextbox1Style.borderLeftWidth;
		wpTextbox0.style.borderRightStyle = wpTextbox1Style.borderRightStyle;
		wpTextbox0.style.borderRightWidth = wpTextbox1Style.borderRightWidth;
		wpTextbox0.style.borderTopLeftRadius = wpTextbox1Style.borderTopLeftRadius;
		wpTextbox0.style.borderTopRightRadius = wpTextbox1Style.borderTopRightRadius;
		wpTextbox0.style.borderTopStyle = wpTextbox1Style.borderTopStyle;
		wpTextbox0.style.borderTopWidth = wpTextbox1Style.borderTopWidth;
		wpTextbox0.style.boxSizing = "border-box";
		wpTextbox0.style.clear = wpTextbox1Style.clear;
		wpTextbox0.style.color = "transparent"; //makes it look just a little bit smoother
		wpTextbox0.style.fontFamily = wpTextbox1Style.fontFamily;
		wpTextbox0.style.fontSize = wpTextbox1Style.fontSize;
		wpTextbox0.style.lineHeight = "140%";
		wpTextbox0.style.marginBottom = "0";
		wpTextbox0.style.marginLeft = "0";
		wpTextbox0.style.marginRight = "0";
		wpTextbox0.style.marginTop = "0";
		wpTextbox0.style.overflowX = "auto";
		wpTextbox0.style.overflowY = "scroll";
		wpTextbox0.style.resize = resize;
		wpTextbox0.style.tabSize = wpTextbox1Style.tabSize;
		wpTextbox0.style.whiteSpace = "pre-wrap";
		wpTextbox0.style.width = "100%";
		wpTextbox0.style.wordWrap = "break-word"; //see below

		wpTextbox1.style.backgroundColor = "transparent";
		wpTextbox1.style.borderBottomLeftRadius = wpTextbox1Style.borderBottomLeftRadius;
		wpTextbox1.style.borderBottomRightRadius = wpTextbox1Style.borderBottomRightRadius;
		wpTextbox1.style.borderBottomStyle = wpTextbox1Style.borderBottomStyle;
		wpTextbox1.style.borderBottomWidth = wpTextbox1Style.borderBottomWidth;
		wpTextbox1.style.borderLeftStyle = wpTextbox1Style.borderLeftStyle;
		wpTextbox1.style.borderLeftWidth = wpTextbox1Style.borderLeftWidth;
		wpTextbox1.style.borderRightStyle = wpTextbox1Style.borderRightStyle;
		wpTextbox1.style.borderRightWidth = wpTextbox1Style.borderRightWidth;
		wpTextbox1.style.borderTopLeftRadius = wpTextbox1Style.borderTopLeftRadius;
		wpTextbox1.style.borderTopRightRadius = wpTextbox1Style.borderTopRightRadius;
		wpTextbox1.style.borderTopStyle = wpTextbox1Style.borderTopStyle;
		wpTextbox1.style.borderTopWidth = wpTextbox1Style.borderTopWidth;
		wpTextbox1.style.boxSizing = "border-box";
		wpTextbox1.style.clear = wpTextbox1Style.clear;

		/**
		 * Fandom change
		 * - source of color was changed
		 */
		wpTextbox1.style.color = wpTextbox1Style.color;
		wpTextbox1.style.fontFamily = wpTextbox1Style.fontFamily;
		wpTextbox1.style.fontSize = wpTextbox1Style.fontSize;
		wpTextbox1.style.lineHeight = "140%";
		wpTextbox1.style.marginBottom = wpTextbox1Style.marginBottom; //lock to pixel value because the top margin was also locked to a pixel value when it was moved to wpTextbox0
		wpTextbox1.style.marginLeft = "0";
		wpTextbox1.style.marginRight = "0";
		wpTextbox1.style.overflowX = "auto";
		wpTextbox1.style.overflowY = "scroll";
		wpTextbox1.style.padding = "0";
		wpTextbox1.style.resize = resize;
		wpTextbox1.style.tabSize = wpTextbox1Style.tabSize;
		wpTextbox1.style.whiteSpace = "pre-wrap";
		wpTextbox1.style.width = "100%";
		wpTextbox1.style.wordWrap = "break-word"; //overall more visually appealing

		//lock both heights to pixel values so that the browser zoom feature works better
		wpTextbox0.style.height = wpTextbox1.offsetHeight + 'px';
		wpTextbox1.style.height = wpTextbox0.style.height;

		//insert wpTextbox0 underneath wpTextbox1
		wpTextbox1.style.marginTop = -wpTextbox1.offsetHeight + "px";
		wpTextbox1.parentNode.insertBefore(wpTextbox0, wpTextbox1);

		document.head.appendChild(syntaxStyleElement);

		wpTextbox1.addEventListener("input", highlightSyntax);
		wpTextbox1.addEventListener("scroll", syncScrollX);
		wpTextbox1.addEventListener("scroll", syncScrollY);
		attributeObserver = new MutationObserver(syncTextDirection);
		attributeObserver.observe(wpTextbox1, {attributes: true});
		parentObserver = new MutationObserver(syncParent);
		parentObserver.observe(wpTextbox1.parentNode, {childList: true});
		highlightSyntaxIfNeededIntervalID = setInterval(highlightSyntaxIfNeeded, 500);
		highlightSyntax();
	}

	/**
	 * Fandom change
	 * - function was added for backward compat
	 */
	function queueSetup(textarea) {
		setTimeout(function () {
			setup(textarea);
		}, 0);
	}

	/**
	 * Fandom change
	 * - function was added for backward compat
	 * - arguments are added for backward compat
	 * - function is exported from this module
	 */
	function init(textarea, config) {
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

		if (document.readyState === "complete") {
			queueSetup(textarea);
		} else {
			$(window).load(queueSetup(textarea));
		}

		isInitialized = true;
	}

	/**
	 * Fandom change
	 * - function was added for backward compat
	 * - function is exported from this module
	 */
	function resetHighlightSyntax(diffTime) {
		if (!isInitialized) {
			return;
		}

		clearInterval(highlightSyntaxIfNeededIntervalID);
		wpTextbox1.removeEventListener("input", highlightSyntax);
		wpTextbox1.removeEventListener("scroll", syncScrollX);
		wpTextbox1.removeEventListener("scroll", syncScrollY);
		attributeObserver.disconnect();
		parentObserver.disconnect();
		syntaxStyleTextNode.nodeValue = "";

		if (diffTime) {
			console.info(
				'Syntax highlighting took too long. The maximum allowed ' +
				'highlighting time is ' + syntaxHighlighterConfig.timeout +
				', and your computer took ' + diffTime + '.'
			);
		}
	}

	return {
		init: init,
		reset: resetHighlightSyntax,
	};
});
