define('GlobalShortcutsSuggestions', ['mw', 'wikia.nirvana', 'PageActions', 'GlobalShortcuts'], function (mw, nirvana, PageActions, GlobalShortcuts) {
	'use strict';

	function GlobalShortcutsSuggestions( $el, closeCb ) {
		this.$el = $el;
		this.closeCb = closeCb;
		this.init();
	}

	GlobalShortcutsSuggestions.prototype.suggestions = function() {
		var ret = { suggestions: [], data: [] },
			formatShortcuts = this.formatShortcuts;
		PageActions.all.forEach(function(pageAction){
			var shortcuts = GlobalShortcuts.find(pageAction.id);
			ret.suggestions.push(pageAction.caption);
			ret.data.push({
				actionId: pageAction.id,
				shortcuts: shortcuts,
				html: formatShortcuts(shortcuts)
			});
		});
		console.log('suggestions',ret);
		return ret;
	};

	GlobalShortcutsSuggestions.prototype.formatShortcuts = function(keyCombinations) {
		return [
			'<span class="key-combination-in-suggestions">',
			keyCombinations.map(function(keyCombination){
				return keyCombination.split(' ').map(function(singleKey){
					return '<span class="key">' + singleKey + '</span>';
				}).join(' then ');
			}).join(' <strong>or</strong> '),
			'</span>'
		].join('');
	};

	GlobalShortcutsSuggestions.prototype.init = function() {
		var autocompleteReEscape = new RegExp('(\\' + ['/', '.', '*', '+', '?', '|', '(', ')',
				'[', ']', '{', '}', '\\'].join('|\\') + ')', 'g');
		$.when(
			mw.loader.use('jquery.autocomplete')
		).then(function() {
			this.$el.autocomplete({
				lookup: this.suggestions(),
				onSelect: function(value, data, event) {
					console.log(arguments);
					var actionId = data.actionId;
					this.closeCb();
					PageActions.find(actionId).action();
				}.bind(this),
				appendTo: this.$el.parent().next(),
				maxHeight: 320,
				selectedClass: 'selected',
				width: '100%',
				matchFromStart: false,
				// Add span around every autocomplete result
				fnFormatResult: function(value, data, currentInput) {
					console.log(arguments);
					var out = '',
						pattern = '(' + currentInput.replace(autocompleteReEscape, '\\$1') + ')';
					out += '<span class="label-in-suggestions">' +
						value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>') +
						'</span>';
					if (data.shortcuts) {
						out += data.html;
					}
					console.log(out);
					return out;
				}.bind(this),
				// BugId:4625 - always send the request even if previous one returned no suggestions
				skipBadQueries: true
			});
		}.bind(this));
	};

	return GlobalShortcutsSuggestions;
});
