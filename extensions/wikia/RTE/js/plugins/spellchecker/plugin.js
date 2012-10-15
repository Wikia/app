CKEDITOR.plugins.add('rte-spellchecker',
{
	// show suggestions as the first items in context menu
	beforeInit : function(editor) {
		editor.config.menu_groups = 'spellchecker,spellcheckermore,' + editor.config.menu_groups;
	},

	// check whether spell checking is enabled and setup plugin
	init: function(editor) {
		var enabled = false,
			langCode = window.wgContentLanguage;

		// check state of spell checking feature for current content language
		if (typeof window.wgSpellCheckerLangIsSupported != 'undefined') {
			if (window.wgSpellCheckerLangIsSupported) {
				RTE.log('spell checking enabled for "' + langCode  + '"');
				enabled = true;
			}
			else {
				RTE.log('spell checking is not supported for "' + langCode  + '"');
			}
		}
		else {
			RTE.log('spell checking disabled');
		}

		// setup spell checking feature
		if (enabled) {
			editor.spellchecker = new CKEDITOR.spellchecker(editor, langCode);
		}
	}
});

/**
 * Spell checker helper object
 *
 * Performs AJAX request, highlight words and handles suggestions in context menu
 */
CKEDITOR.spellchecker = function(editor, langCode) {
	var self = this;

	this.editor = editor;
	this.langCode = langCode;

	// create an instance of HTML parser
	// @see http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.htmlParser.html
	this.parser = new CKEDITOR.htmlParser();

	// TODO: use client-side storage to store this.wordsCache between requests
	// @see http://plugins.jquery.com/project/html5Storage

	// perform check when editor is initialized / switch to wysiwyg mode
	editor.on('wysiwygModeReady', function() {
		self.checkEditbox();
	});

	// show suggestions in context menu
	// @see http://cksource.com/forums/viewtopic.php?f=11&t=18151
	editor.on('instanceReady', function() {
		// handle contextmenu
		var menu = editor.contextMenu;

		menu.addListener(function(node, selection) {
			// in Chrome node passed to listeners from contextmenu contains parent of element contextmenu is shown for
			if (CKEDITOR.env.webkit) {
				node = menu.originalEvent.getTarget();
			}
			return self.showSuggestions(node);
		});
	});

	// perform SpellCheckingAsYouType
	this.setupScayt();

	// remove <span>s  added by spell checker when switching to source mode / returning HTML when saving
	var dataProcessor = editor.dataProcessor,
		htmlFilter = dataProcessor && dataProcessor.htmlFilter,
		spanRegExp = /^spellchecker/;

	if (htmlFilter) {
		htmlFilter.addRules({
			elements: {
				span: function(element) {
					if (spanRegExp.test(element.attributes['class'])) {
						delete element.name;
						return element;
					}
				}
			}
		});
	}

	// setup nodeRunner
	this.nodeRunner = new CKEDITOR.nodeRunner();
	this.nodeRunner.isSkipped = this.isIgnoredNode;
};

CKEDITOR.spellchecker.prototype = {

	// store previous results of spell checking as [word] => [data]
	// data can be either:
	//  * 1 - word is spelled correctly
	//  * 0 - word is misspelled, but suggestions have to fetched
	//  * ['foo', 'bar', ...] - words is misspelled, data containts spelling suggestions
	wordsCache: {},

	// given word is correct
	CORRECT: 1,

	// given word is misspelled, suggestions have to be fetched
	MISSPELLED: 0,

	// when there's more than X suggestions, show the rest in a submenu
	SUGGESTIONS_LIMIT: 6,

	// how long [ms] to wait before sending SCAYT request
	SCAYT_DELAY_TIME: 1000,

	// how long [number of characters] to wait before sending SCAYT request
	SCAYT_DELAY_CHARS: 20,

	// editor's text content spell checking was performed recently
	recentText: '',

	// helper method for recursively runnning over HTML nodes in wysiwyg mode
	nodeRunner: false,

	// send AJAX request
	ajax: function(method, params, callback) {
		params = params || {};
		params.method = method;

		jQuery.post(window.wgSpellCheckerUrl, params, function(data) {
			if (typeof callback == 'function') {
				callback(data);
			}
		}, 'json');
	},

	// check if given node is highlighted as an spelling error
	isMarkedNode: function(node) {
		return node.hasClass('spellchecker-misspell');
	},

	// whether given node can be ignored during spell checking / skipped by nodeRunner
	isIgnoredNode: function(node) {
		if (node.is('a')) {
			// don't check interwiki links
			if (node.hasClass('extiw')) {
				return true;
			}

			// don't check "raw" interwiki links
			if (node.getAttribute('rel') == 'nofollow' && (node.getAttribute('href') == node.getText())) {
				return true;
			}
		}

		return false;
	},

	// convert editor's HTML content into plain text
	getTextFromEditor: function() {
		var separators = this.getSeparators(),
			text = '';

		// add every text node found to common stack
		this.nodeRunner.walkTextNodes(this.editor.document.getBody(), function(node) {
			text += node.getText() + ' ';
		});

		// additional text cleanup
		text = text.
			// remove HTML entities (&amp;)
			replace(/&[^;]+;/g, ' ').
			// remove words separators
			replace(new RegExp('([0-9]|[' + separators + '])', 'g'), ' ').
			// remove multiple spaces
			replace(/\s+/g, ' ');

		// remove trailing spaces
		text = $.trim(text);

		return text;
	},

	// get list of words from given texts
	getWords: function(text) {
		var words = [],
			index = [],
			raw = text.split(' ');

		$.each(raw, function(i, word) {
			if (!index[word]) {
				index[word] = 1;
				words.push(word);
			}
		});

		return words;
	},

	// get regexp for word separators
	getSeparators: function() {
		var i,
			re = '',
			str = '\\s!"#$%&()*+,-./:;<=>?@[]^_{|}\xA7\xA9\xAB\xAE\xB1\xB6\xB7\xB8\xBB\xBC\xBD\xBE\xBF\xD7\xF7\xA4\u201d\u201c';

		// escape for RegExp
		for (i=0; i<str.length; i++) {
			re += '\\' + str.charAt(i);
		}

		return re;
	},

	// get suggestions for given word
	getSuggestions: function(word) {
		var data = this.wordsCache[word];

		if (data && data.length) {
			return data;
		}
	},

	// check spelling of given list of words
	checkWords: function(words, callback) {
		var self = this,
			w,
			wordsList = [];

		RTE.log('found ' + words.length + ' unique word(s)');

		// check wordsCache for already checked words
		for (w=0; w<words.length; w++) {
			if (typeof this.wordsCache[ words[w] ] == 'undefined') {
				// not checked yet, add to the list
				wordsList.push(words[w]);
			}
		}

		// all words are already checked, execute callback immediately
		if (wordsList.length == 0) {
			RTE.log('spell checking data already in cache');

			callback.call();
			return;
		}

		RTE.log('checking ' + wordsList.length + ' unique word(s)');

		// let's perform spell checking
		var params = {
			lang: this.langCode,
			words: wordsList.join(',')
		};

		this.ajax('checkWords', params, function(data) {
			if (data.info) {
				RTE.log(data['correct'] + ' word(s) spelled correctly (' + data['info']['provider'] + ')');

				self.updateWordsCache(wordsList, data.suggestions);

				if (typeof callback == 'function') {
					callback.call();
				}
			}
			else {
				RTE.log('spell checking request has failed!');
			}
		});
	},

	// update wordsCache with spelling data
	updateWordsCache: function(words, suggestions) {
		var wordsCache = this.wordsCache,
			CORRECT = this.CORRECT;

		$.each(words, function(i, word) {
			if (suggestions[word]) {
				wordsCache[word] = suggestions[word];
			}
			else {
				wordsCache[word] = CORRECT;
			}
		});

		//RTE.log(this.wordsCache);
	},

	// get the list of misspelled words
	getMisspelledWords: function() {
		var CORRECT = this.CORRECT,
			misspelled = [];

		// scan wordsCache and find misspelled words
		$.each(this.wordsCache, function(word, data) {
			if (data != CORRECT) {
				misspelled.push(word);
			}
		});

		return misspelled;
	},

	// highlight misspelled words
	highlightWords: function() {
		// remove highlighting - perform spell checking for words corrected manually
		this.removeHighlight();

		var misspelledList = this.getMisspelledWords().join('|'),
			textNodes = [],
			self = this;

		// there's nothing to highlight
		if (misspelledList == '') {
			return;
		}

		// collect all text nodes (ignore already highlighted words and read only nodes)
		this.nodeRunner.walkTextNodes(this.editor.document.getBody(), function(node) {
			if (!self.isMarkedNode(node.getParent())) {
				textNodes.push(node);
			}
		});

		//RTE.log(textNodes);

		// highlight misspelled words
		var separators = this.getSeparators(),
			re = new RegExp('(^|[' + separators + '])(' + misspelledList + ')($|[' + separators + '])', 'g');

		$.each(textNodes, function(i, node) {
			var value = node.getText(),
				parentNode = false;

			if (re.test(value)) {
				// highlight misspelled words
				value = value.replace(re, '$1<span class="spellchecker-misspell">$2</span>$3');
				parentNode = node.getParent();

				if (parentNode.hasClass('spellchecker-wrapper') && parentNode.getChildCount() == 1) {
					// already wrapped
					parentNode.setHtml(value);
				}
				else {
					// wrap text node within <span>
					var wrapper = new CKEDITOR.dom.element('span');
					wrapper.setHtml(value);
					wrapper.addClass('spellchecker-wrapper');

					// add replace current node with wrapped version
					wrapper.replace(node);
				}
			}
		});
	},

	// remove highlighted words (apply to given node or whole editor)
	removeHighlight: function(node) {
		var self = this;

		if (!node) {
			node =  this.editor.document.getBody();
		}

		// find marked nodes and convert them to text nodes
		this.nodeRunner.walk(node, function(node) {
			if (node.type == CKEDITOR.NODE_ELEMENT && self.isMarkedNode(node)) {
				var newNode = new CKEDITOR.dom.text(node.getText());
				newNode.replace(node);
			}
		});
	},

	// check spelling in given instance of editor
	checkEditbox: function() {
		if (this.editor.mode != 'wysiwyg') {
			return;
		}

		// get HTML to be checked
		var text = this.getTextFromEditor();

		// there's nothing to check
		if (text == '') {
			return;
		}

		// editor's content has not been changed since recent spellcheck
		if (text == this.recentText) {
			RTE.log('text already checked');
			return;
		}

		this.recentText = text;

		// get list of words found
		//console.time('getWords');
		var words = this.getWords(text);
		//console.timeEnd('getWords');

		// perform spell checking and then highlight misspelled words
		var self = this;
		this.checkWords(words, function() {
			self.highlightWords();
		});
	},

	// show suggestions in context menu
	showSuggestions: function(node) {
		if (this.isMarkedNode(node)) {
			var commands = {},
				subCommands = {},
				n,
				word = node.getText(),
				self = this,
				suggestions = this.getSuggestions(word);

			// for some misspelled words there may not be any suggestions
			if (!suggestions) {
				RTE.log('no suggestions for "' + word + '"');
				return;
			}

			RTE.log('showing ' + suggestions.length +  ' suggestion(s) for "' + word + '"');

			for (n = 0; n < suggestions.length; n++) {
				// register spell correction command
				var commandName = this.addSuggestItem(n+1, suggestions[n], function(suggestion) {
					self.applySuggestion(node, suggestion);
				});

				if (n < this.SUGGESTIONS_LIMIT) {
					// show this suggestion in "main" context menu
					commands[commandName] = CKEDITOR.TRISTATE_OFF;
				}
				else {
					// show this suggestion in submenu
					subCommands[commandName] = CKEDITOR.TRISTATE_OFF;
				}
			}

			if (suggestions.length > this.SUGGESTIONS_LIMIT) {
				// create "more" submenu
				this.editor.addMenuItem('spellcheckerMore', {
					label: this.editor.lang.spellchecker.moreSuggestions,
					group: 'spellcheckermore',
					getItems: function() {
						return subCommands;
					}
				});

				// add submenu item
				commands['spellcheckerMore'] = CKEDITOR.TRISTATE_OFF;
			}

			return commands;
		}
	},

	// helper function to add items to context menu
	addSuggestItem: function(index, suggestion, callback) {
		var commandName = 'spellcheckerSuggest' + suggestion.replace(/[^\w]/g, '_');

		// register command
		this.editor.addCommand(commandName, {
			exec: function() {
				callback(suggestion);
			}
		});
		this.editor.addMenuItem(commandName, {
			command: commandName,
			group: 'spellchecker',
			label : suggestion,
			order: index
		});

		return commandName;
	},

	// apply spelling suggestion for given node
	applySuggestion: function(node, suggestion) {
		// save undo step
		this.editor.fire('saveSnapshot');

		var newNode = new CKEDITOR.dom.text(suggestion);
		newNode.replace(node);

		// save undo step
		this.editor.fire('saveSnapshot');

		RTE.track('spellchecker', 'applySuggestion');
	},

	// setup SCAYT (SpellCheckAsYouType) feature
	scaytCharacters: 0,
	scaytTimeout: false,

	setupScayt: function() {
		var self = this;

		this.editor.on('key', function(ev) {
			var keyCode = ev.data.keyCode;

			// remove pending check
			if (self.scaytTimeout) {
				clearTimeout(self.scaytTimeout);
				self.scaytTimeout = false;
			}

			// schedule check
			self.scaytTimeout = setTimeout(function() {
				self.performScayt();
			}, self.SCAYT_DELAY_TIME);

			// handle characters delay
			self.scaytCharacters++;

			if (self.scaytCharacters > self.SCAYT_DELAY_CHARS) {
				self.performScayt();
			}
		});
	},

	// do a spell check and reset timer / counter
	performScayt: function() {
		// reset counters
		clearTimeout(this.scaytTimeout);
		this.scaytTimeout = false;
		this.scaytCharacters = 0;

		this.checkEditbox();
	}
};
