//Syntax highlighter with various advantages
//See [[User:Remember the dot/Syntax highlighter]] for more information

define('WikiTextSyntaxHighlighter', function() {
	var init = function (textarea) {
		"use strict";

		console.log('start syntax');

		//variables that are preserved between function calls
		var wpTextbox0;
		var wpTextbox1;
		var syntaxStyleTextNode;
		var lastText;
		var maxSpanNumber = -1; //the number of the last span available, used to tell if creating additional spans is necessary
		var highlightSyntaxIfNeededIntervalID;
		var attributeObserver;

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
		var breakerRegexBase = "\\[(?:\\[|(?:https?:|ftp:)?//|mailto:)|\\{(?:\\{\\{?|\\|)|<(?:[:A-Z_a-z\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02FF\u0370-\u037D\u037F-\u1FFF\u200C\u200D\u2070-\u218F\u2C00-\u2FEF\u3001-\uD7FF\uF900-\uFDCF\uFDF0-\uFFFD][:\\w\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02FF\u0370-\u037D\u037F-\u1FFF\u200C\u200D\u2070-\u218F\u2C00-\u2FEF\u3001-\uD7FF\uF900-\uFDCF\uFDF0-\uFFFD-\\.\u00B7\u0300-\u036F\u203F-\u203F-\u2040]*(?=/?>| |\n)|!--[^]*?-->\n*)|(?:https?://|ftp://|mailto:)[^\\s\"<>[\\]{-}]*[^\\s\",\\.:;<>[\\]{-}]\n*|^(?:=|[*#:;]+\n*|-{4,}\n*)|\\\\'\\\\'(?:\\\\')?|~{3,5}\n*|&(?:(?:n(?:bsp|dash)|m(?:dash|inus)|lt|e[mn]sp|thinsp|amp|quot|gt|shy|zwn?j|lrm|rlm|Alpha|Beta|Epsilon|Zeta|Eta|Iota|Kappa|[Mm]u|micro|Nu|[Oo]micron|[Rr]ho|Tau|Upsilon|Chi)|#x[0-9a-fA-F]+);\n*";

		function breakerRegexWithPrefix(prefix) {
			//the stop token has to be at the beginning of the regex so that it takes precedence over substrings of itself.
			return new RegExp("(" + prefix + ")\n*|" + breakerRegexBase, "gm");
		}

		var defaultBreakerRegex = new RegExp(breakerRegexBase, "gm");
		var wikilinkBreakerRegex = breakerRegexWithPrefix("]][a-zA-Z]*");
		var namedExternalLinkBreakerRegex = breakerRegexWithPrefix("]");
		var parameterBreakerRegex = breakerRegexWithPrefix("}}}");
		var templateBreakerRegex = breakerRegexWithPrefix("}}");
		var tableBreakerRegex = breakerRegexWithPrefix("\\|}");
		var headingBreakerRegex = breakerRegexWithPrefix("\n");
		var tagBreakerRegexCache = {};

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
			var assumedBold = false;
			var assumedItalic = false;

			//writes text into to-be-created span elements of wpTextbox0 using :before and :after pseudo-elements
			//both :before and :after are used because using two pseudo-elements per span is significantly faster than doubling the number of spans required
			function writeText(text, color) {
				//no need to use another span if using the same color
				if (color != lastColor) {
					//whitespace is omitted in the hope of increasing performance
					css += "'}#s" + spanNumber; //spans will be created with IDs s0 through sN
					if (before) {
						css += ":before{";
						before = false;
					}
					else {
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

			function highlightBlock(color, breakerRegex) {
				var match;

				for (breakerRegex.lastIndex = i; match = breakerRegex.exec(text); breakerRegex.lastIndex = i) {
					if (match[1]) {
						//end token found
						writeText(text.substring(i, breakerRegex.lastIndex), color);
						i = breakerRegex.lastIndex;
						return;
					}

					var endIndexOfLastColor = breakerRegex.lastIndex - match[0].length;
					if (i < endIndexOfLastColor) //avoid calling writeText with text == "" to improve performance
					{
						writeText(text.substring(i, endIndexOfLastColor), color);
					}

					i = breakerRegex.lastIndex;

					switch (match[0].charAt(0)) //cases in this switch should be arranged from most common to least common
					{
						case "[":
							if (match[0].charAt(1) == "[") {
								//wikilink
								writeText("[[", syntaxHighlighterConfig.wikilinkColor || color);
								highlightBlock(syntaxHighlighterConfig.wikilinkColor || color, wikilinkBreakerRegex);
							}
							else {
								//named external link
								writeText(match[0], syntaxHighlighterConfig.externalLinkColor || color);
								highlightBlock(syntaxHighlighterConfig.externalLinkColor || color, namedExternalLinkBreakerRegex);
							}
							break;
						case "{":
							if (match[0].charAt(1) == "{") {
								if (match[0].length == 3) {
									//parameter
									writeText("{{{", syntaxHighlighterConfig.parameterColor || color);
									highlightBlock(syntaxHighlighterConfig.parameterColor || color, parameterBreakerRegex);
								}
								else {
									//template
									writeText("{{", syntaxHighlighterConfig.templateColor || color);
									highlightBlock(syntaxHighlighterConfig.templateColor || color, templateBreakerRegex);
								}
							}
							else //|
							{
								//table
								writeText("{|", syntaxHighlighterConfig.tableColor || color);
								highlightBlock(syntaxHighlighterConfig.tableColor || color, tableBreakerRegex);
							}
							break;
						case "<":
							if (match[0].charAt(1) == "!") {
								//comment tag
								writeText(match[0], syntaxHighlighterConfig.commentColor || color);
								break;
							}
							else {
								//some other kind of tag, search for its end
								//the search is made easier because XML attributes may not contain the character ">"
								var tagEnd = text.indexOf(">", i) + 1;
								if (tagEnd == 0) {
									//not a tag, just a "<" with some text after it
									writeText("<", color);
									i = i - match[0].length + 1;
									break;
								}

								if (text.charAt(tagEnd - 2) == "/") {
									//empty tag
									writeText(text.substring(i - match[0].length, tagEnd), syntaxHighlighterConfig.tagColor || color);
									i = tagEnd;
								}
								else {
									var tagName = match[0].substring(1);

									//again, cases are ordered from most common to least common
									if (/^(?:nowiki|pre|math|syntaxhighlight|source|timeline|hiero)$/.test(tagName)) {
										//tag that can contain only plain text
										var stopAfter = "</" + tagName + ">";
										var endIndex = text.indexOf(stopAfter, i);
										if (endIndex == -1) {
											endIndex = text.length;
										}
										else {
											endIndex += stopAfter.length;
										}
										writeText(text.substring(i - match[0].length, endIndex), syntaxHighlighterConfig.tagColor || color);
										i = endIndex;
									}
									else {
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
						case "h":
						case "f":
						case "m":
							//bare external link
							writeText(match[0], syntaxHighlighterConfig.externalLinkColor || color);
							break;
						case "=":
							if (/[^=]=+$/.test(text.substring(i, text.indexOf("\n", i)))) //the line begins and ends with an equals sign and has something else in the middle
							{
								//heading
								writeText("=", syntaxHighlighterConfig.headingColor || color);
								highlightBlock(syntaxHighlighterConfig.headingColor || color, headingBreakerRegex);
							}
							else {
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
							if (match[0].length == 6) {
								//bold
								if (assumedBold) {
									//end tag
									assumedBold = false;
									return;
								}
								else {
									//start tag
									assumedBold = true;
									highlightBlock(syntaxHighlighterConfig.boldOrItalicColor || color, defaultBreakerRegex);
								}
							}
							else {
								//italic
								if (assumedItalic) {
									//end tag
									assumedItalic = false;
									return;
								}
								else {
									//start tag
									assumedItalic = true;
									highlightBlock(syntaxHighlighterConfig.boldOrItalicColor || color, defaultBreakerRegex);
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
					}
				}
			}


			//start!
			var startTime = Date.now();
			console.log('start work');
			highlightBlock("", defaultBreakerRegex);

			//output the leftovers (if any) to make sure whitespace etc. matches
			if (i < text.length) {
				writeText(text.substring(i), "");
			}

			//if highlighting took too long, disable it.
			var endTime = Date.now();
			/*if (typeof(bestTime) == "undefined")
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
			if (endTime - startTime > syntaxHighlighterConfig.timeout) {
				clearInterval(highlightSyntaxIfNeededIntervalID);
				wpTextbox1.removeEventListener("input", highlightSyntax);
				wpTextbox1.removeEventListener("scroll", syncScrollX);
				wpTextbox1.removeEventListener("scroll", syncScrollY);
				attributeObserver.disconnect();
				syntaxStyleTextNode.nodeValue = "";

				var errorMessage = {
					ca: "S'ha desactivat el remarcar de sintaxi en aquesta pàgina perquè ha trigat massa temps. El temps màxim permès per a remarcar és $1ms, i el vostre ordinador ha trigat $2ms. Proveu tancar algunes pestanyes i programes i fer clic en \"Mostra la previsualització\" o \"Mostra els canvis\". Si no funciona això, proveu un altre navegador web, i si això no funciona, proveu un ordinador més ràpid.",
					de: "Die Syntaxhervorhebung wurde auf dieser Seite deaktiviert, da diese zu lange gedauert hat. Die maximal erlaubte Zeit zur Hervorhebung beträgt $1ms und dein Computer benötigte $2ms. Versuche einige Tabs und Programme zu schließen und klicke \"Vorschau zeigen\" oder \"Änderungen zeigen\". Wenn das nicht funktioniert, probiere einen anderen Webbrowser und wenn immer noch nicht, probiere einen schnelleren Computer.",
					el: "Η έμφαση σύνταξης έχει απενεργοποιηθεί σε αυτήν τη σελίδα γιατί αργούσε πολύ. Ο μέγιστος επιτρεπτός χρόνος για την έμφαση σύνταξης είναι $1ms και ο υπολογιστής σας έκανε $2ms. Δοκιμάστε να κλείσετε μερικές καρτέλες και προγράμματα και να κάνετε κλικ στην «Εμφάνιση προεπισκόπησης» ή στην «Εμφάνιση αλλαγών». Αν αυτό δεν δουλέψει, δοκιμάστε έναν διαφορετικό περιηγητή και αν ούτε αυτό δουλέψει, δοκιμάστε έναν ταχύτερο υπολογιστή.",
					en: "Syntax highlighting on this page was disabled because it took too long. The maximum allowed highlighting time is $1ms, and your computer took $2ms. Try closing some tabs and programs and clicking \"Show preview\" or \"Show changes\". If that doesn't work, try a different web browser, and if that doesn't work, try a faster computer.",
					es: "Se desactivó el resaltar de sintaxis en esta página porque tardó demasiado. El tiempo máximum permitido para resaltar es $1ms, y tu ordenador tardó $2ms. Prueba cerrar algunas pestañas y programas y hacer clic en \"Mostrar previsualización\" o \"Mostrar cambios\". Si no funciona esto, prueba otro navegador web, y si eso no funciona, prueba un ordenador más rápido.",
					fa: "از آنجایی که زمان زیادی صرف آن می‌شد، برجسته‌سازی نحو در این صفحه غیرفعال شده است. بیشینهٔ زمان برجسته‌سازی برای ابزار $1ms تعریف شده در حالی که رایانهٔ شما $2ms زمان نیاز داشت. می‌توانید بستن برخی سربرگ‌ها و برنامه‌ها و سپس کلیک‌کردن دکمهٔ «پیش‌نمایش» یا «نمایش تغییرات» را بیازمایید. اگر جواب نداد مرورگر دیگری را امتحان کنید؛ و اگر باز هم جواب نداد، رایانهٔ سریع‌تری را بیازمایید.",
					fr: "La coloration syntaxique a été désactivée sur cette page en raison d'un temps de chargement trop important ($2ms). Le temps maximum autorisé est $1ms. Vous pouvez essayer de fermer certains onglets et programmes et cliquez sur \"Prévisualisation\" ou \"Voir mes modifications\". Si cela ne fonctionne pas, essayez un autre navigateur web, et si cela ne fonctionne toujours pas, essayez un ordinateur plus rapide.",
					io: "Sintaxo-hailaitar en ca pagino esis nekapabligata pro ke konsumis tro multa tempo. La maxima permisata hailaitala tempo es $1ms, e tua ordinatro konsumis $2ms. Probez klozar kelka tabi e programi e kliktar \"Previdar\" o \"Montrez chanji\". Se to ne funcionas, probez altra brauzero, e se to ne funcionas, probez plu rapida ordinatro.",
					pt: "O marcador de sintaxe foi desativado nesta pagina porque demorou demais. O tempo máximo permitido para marcar e $1ms, e seu computador demorou $2ms. Tenta sair de alguns programas e clique em \"Mostrar previsão\" ou \"Mostrar alterações\". Se isso não funciona, tenta usar uma outra navegador web, e se ainda não funciona, procura um computador mais rápido."
				};
				var wgUserLanguage = mw.config.get("wgUserLanguage");

				errorMessage = errorMessage[wgUserLanguage] || errorMessage[wgUserLanguage.substring(0, wgUserLanguage.indexOf("-"))] || errorMessage.en;

				wpTextbox1.style.backgroundColor = "";
				wpTextbox1.style.position = "";
				wpTextbox0.removeAttribute("dir");
				wpTextbox0.removeAttribute("lang");
				wpTextbox0.style = "color:red; font-size:small";

				wpTextbox0.textContent = errorMessage.replace("$1", syntaxHighlighterConfig.timeout).replace("$2", endTime - startTime);
				return;
			}

			//do we have enough span elements to match the generated CSS?
			//this step isn't included in the above benchmark because it takes a highly variable amount of time
			if (maxSpanNumber < spanNumber) {
				var fragment = document.createDocumentFragment();
				do
				{
					fragment.appendChild(document.createElement("span")).id = "s" + (++maxSpanNumber);
				}
				while (maxSpanNumber < spanNumber)
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

		//this function runs once every 500ms to detect changes to wpTextbox1's text that the input event does not catch
		//this happens when another script changes the text without knowing that the syntax highlighter needs to be informed
		function highlightSyntaxIfNeeded() {
			if (wpTextbox1.value != lastText) {
				highlightSyntax(wpTextbox1);
			}
			if (wpTextbox1.scrollLeft != wpTextbox0.scrollLeft) {
				syncScrollX();
			}
			if (wpTextbox1.scrollTop != wpTextbox0.scrollTop) {
				syncScrollY();
			}
			if (wpTextbox1.offsetHeight != wpTextbox0.offsetHeight) {
				wpTextbox0.style.height = wpTextbox1.offsetHeight + "px";
			}
		}

		function setup(textarea) {
			console.log('start setup');

			function configureColor(parameterName, hardcodedFallback) {
				if (syntaxHighlighterConfig[parameterName] == "normal") {
					syntaxHighlighterConfig[parameterName] = hardcodedFallback;
				}
				else if (typeof(syntaxHighlighterConfig[parameterName]) != "undefined") {
					return;
				}
				else if (typeof(syntaxHighlighterConfig.defaultColor) != "undefined") {
					syntaxHighlighterConfig[parameterName] = syntaxHighlighterConfig.defaultColor;
				}
				else {
					syntaxHighlighterConfig[parameterName] = hardcodedFallback;
				}
			}

			window.syntaxHighlighterConfig = window.syntaxHighlighterConfig || {};


			//use 3-digit colors instead of 6-digit colors for performance
			configureColor("boldOrItalicColor", "#EEE"); //gray
			configureColor("commentColor", "#EFE"); //green
			configureColor("entityColor", "#DFD"); //green
			configureColor("externalLinkColor", "#EFF"); //cyan
			configureColor("headingColor", "#EEE"); //gray
			configureColor("hrColor", "#EEE"); //gray
			configureColor("listOrIndentColor", "#EFE"); //green
			configureColor("parameterColor", "#FC6"); //orange
			configureColor("signatureColor", "#FC6"); //orange
			configureColor("tagColor", "#FEF"); //pink
			configureColor("tableColor", "#FFC"); //yellow
			configureColor("templateColor", "#FFC"); //yellow
			configureColor("wikilinkColor", "#EEF"); //blue

			syntaxHighlighterConfig.timeout = syntaxHighlighterConfig.timeout || 50;

			var textboxContainer = document.createElement("div");
			wpTextbox0 = document.createElement("div");
			wpTextbox1 = textarea;
			var syntaxStyleElement = document.createElement("style");
			syntaxStyleTextNode = syntaxStyleElement.appendChild(document.createTextNode(""));

			//the styling of the textbox and the background div must be kept very similar
			var wpTextbox1Style = window.getComputedStyle(wpTextbox1);
			var scrollTop = wpTextbox1.scrollTop;
			var focus = (document.activeElement == wpTextbox1);

			wpTextbox0.dir = wpTextbox1.dir;
			wpTextbox0.lang = wpTextbox1.lang; //lang determines which font "monospace" is
			wpTextbox0.style.backgroundColor = wpTextbox1Style.backgroundColor;
			wpTextbox0.style.border = "1px solid transparent";
			wpTextbox0.style.boxSizing = "border-box";
			wpTextbox0.style.color = "transparent"; //makes it look just a little bit smoother
			wpTextbox0.style.fontFamily = wpTextbox1Style.fontFamily;
			wpTextbox0.style.fontSize = wpTextbox1Style.fontSize;
			wpTextbox0.style.lineHeight = "normal";
			wpTextbox0.style.marginBottom = wpTextbox1Style.marginBottom;
			wpTextbox0.style.marginLeft = "0";
			wpTextbox0.style.marginRight = "0";
			wpTextbox0.style.marginTop = wpTextbox1Style.marginTop;
			wpTextbox0.style.overflowX = "auto";
			wpTextbox0.style.overflowY = "scroll";
			//horizontal resize would look horribly choppy, better to make the user resize the browser window instead
			wpTextbox0.style.resize = (wpTextbox1Style.resize == "vertical" || wpTextbox1Style.resize == "both" ? "vertical" : "none");
			wpTextbox0.style.tabSize = wpTextbox1Style.tabSize;
			wpTextbox0.style.whiteSpace = "pre-wrap";
			wpTextbox0.style.width = "100%";
			wpTextbox0.style.wordWrap = "normal"; //see below

			wpTextbox1.style.backgroundColor = "transparent";
			wpTextbox1.style.border = "1px inset gray";
			wpTextbox1.style.boxSizing = "border-box";
			wpTextbox1.style.fontSize = wpTextbox1Style.fontSize; //resolves alignment problems on mobile chrome
			wpTextbox1.style.lineHeight = "normal";
			wpTextbox1.style.left = "0";
			wpTextbox1.style.margin = "0";
			wpTextbox1.style.overflowX = "auto";
			wpTextbox1.style.overflowY = "scroll";
			wpTextbox1.style.padding = "0";
			wpTextbox1.style.position = "absolute";
			wpTextbox1.style.resize = wpTextbox0.style.resize;
			wpTextbox1.style.top = "0";
			wpTextbox1.style.width = "100%";
			wpTextbox1.style.wordWrap = "normal"; //overall more visually appealing

			//lock both heights to pixel values so that the browser zoom feature works better
			wpTextbox0.style.height = wpTextbox1.offsetHeight + "px";
			wpTextbox1.style.height = wpTextbox0.style.height;

			textboxContainer.style.clear = "both";
			textboxContainer.style.position = "relative";

			wpTextbox1.parentNode.insertBefore(textboxContainer, wpTextbox1);
			textboxContainer.appendChild(wpTextbox1);
			textboxContainer.appendChild(wpTextbox0);

			//changing the parent resets scrollTop to 0 and removes focus, so we have to bring that back
			wpTextbox0.scrollTop = scrollTop;
			wpTextbox1.scrollTop = scrollTop;
			if (focus) wpTextbox1.focus();

			//fix drop-downs in editing toolbar
			$('.tool-select *').css({zIndex: 5});

			document.head.appendChild(syntaxStyleElement);

			$(wpTextbox1).on( 'input', function() {
				highlightSyntax();
			});
			wpTextbox1.addEventListener("scroll", syncScrollX);
			wpTextbox1.addEventListener("scroll", syncScrollY);
			attributeObserver = new MutationObserver(syncTextDirection);
			attributeObserver.observe(wpTextbox1, {attributes: true});
			highlightSyntaxIfNeededIntervalID = setInterval(highlightSyntaxIfNeeded, 500);
			highlightSyntax();
		}

		function queueSetup(textarea) {
			setTimeout(function() {
				setup(textarea);
			}, 0);
		}


		//enable the highlighter only when editing wikitext pages
		//in the future a separate parser could be added for CSS and JS pages
		//blacklist Internet Explorer, it's just too broken
		var wgAction = mw.config.get("wgAction");
		console.log(wgAction, mw.config.get("wgPageContentModel"), $.client.profile().layout);
		if ((wgAction == "edit" || wgAction == "submit") && $.client.profile().layout != "trident") {
			/* The highlighter has to run after any other script (such as the
			 editing toolbar) that reparents wpTextbox1. We make sure that
			 everything else has run by waiting for the page to completely load
			 and then adding a call to the setup function to the end of the event
			 queue, so that the setup function runs after any other triggers set
			 on the load event. */
			if (document.readyState == "complete") {
				queueSetup(textarea);
			}
			else {
				$(window).load(queueSetup(textarea));
			}
		}
		return {
			setup: setup,
			highlightSyntax:highlightSyntax
		}
	};

	return {
		init: init
	};
});
