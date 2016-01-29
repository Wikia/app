define('GlobalShortcutsSuggestions',
	['mw', 'wikia.nirvana', 'PageActions', 'GlobalShortcuts', 'GlobalShortcuts.RenderKeys', 'GlobalShortcutsTracking'],
	function (mw, nirvana, PageActions, GlobalShortcuts, RenderKeys, tracker) {
		'use strict';

		function GlobalShortcutsSuggestions($el, closeCb) {
			this.$el = $el;
			this.closeCb = closeCb;

			require(['devbridge.autocomplete'], function (Autocomplete) {
				$.fn.suggestionsAutocomplete = Autocomplete.autocomplete;

				this.init();
			}.bind(this));
		}

		GlobalShortcutsSuggestions.prototype.close = function () {
			this.closeCb && this.closeCb();
		};

		GlobalShortcutsSuggestions.prototype.suggestionsAsync = function () {
			return RenderKeys.loadTemplates().then(function () {
				var ret = [];
				PageActions.sortList(PageActions.all).forEach(function (pageAction) {
					var shortcuts = GlobalShortcuts.find(pageAction.id);
					ret.push({
						value: pageAction.caption,
						data: {
							actionId: pageAction.id,
							shortcuts: shortcuts,
							html: RenderKeys.getHtml(shortcuts),
							category: pageAction.category
						}
					});
				});
				return ret;
			});
		};

		GlobalShortcutsSuggestions.prototype.init = function () {
			var autocompleteReEscape = new RegExp('(\\' + ['/', '.', '*', '+', '?', '|', '(', ')',
					'[', ']', '{', '}', '\\'].join('|\\') + ')', 'gi');

			this.suggestionsAsync().done(function (suggestions) {
				this.$el.suggestionsAutocomplete({
					lookup: suggestions,
					onSelect: function (suggestion) {
						var actionId = suggestion.data.actionId;
						this.close();
						tracker.trackClick(actionId);
						PageActions.find(actionId).execute();
					}.bind(this),
					groupBy: 'category',
					appendTo: this.$el.parent().next(),
					maxHeight: 320,
					minChars: 0,
					selectedClass: 'selected',
					width: '100%',
					preserveInput: true,
					formatResult: function (suggestion, currentValue) {
						var out = '',
							pattern = '(' + currentValue.replace(autocompleteReEscape, '\\$1') + ')';
						out += '<span class="label-in-suggestions">' +
						suggestion.value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>') +
						'</span>';
						if (suggestion.data.shortcuts) {
							out += suggestion.data.html;
						}
						return out;
					}.bind(this),
					skipBadQueries: true,
					autoSelectFirst: true
				});

				this.$el.focus();

			}.bind(this));

		};

		return GlobalShortcutsSuggestions;
	}
);
