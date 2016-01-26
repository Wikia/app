/**
 * Module contains list of actions that can be performed.
 * (actions doesn't necessarily need to have shortcut keys assigned,
 * but if they have it can be found in GlobalShortcuts module)
 * Keeps references on functions that handles actions
 */
define('PageActions', ['mw', 'jquery'], function (mw, $) {
	'use strict';

	var CATEGORY_WEIGHTS = {},
		categoryOtherName = mw.message('global-shortcuts-category-other').escaped(),
		all = [],
		byId = {};

	CATEGORY_WEIGHTS[mw.message('global-shortcuts-category-current-page').escaped()] = 10;
	CATEGORY_WEIGHTS[mw.message('global-shortcuts-category-current-wikia').escaped()] = 20;
	CATEGORY_WEIGHTS[categoryOtherName] = 1000;

	function PageAction(id, caption, fn, category, weight) {
		this.id = id;
		this.caption = '';
		this.fn = $.noop;
		this.category = categoryOtherName;
		this.categoryWeight = this._calculateCategoryWeight();
		this.weight = 500;
		this.update({
			caption: caption,
			fn: fn,
			category: category || categoryOtherName,
			weight: weight || 500
		});
	}

	PageAction.prototype.update = function (key, value) {
		if (typeof key !== 'string') {
			Object.keys(key).forEach(function (k) {
				this.update(k, key[k]);
			}.bind(this));
			return;
		}

		if (!value) {
			return;
		}
		if (key === 'caption') {
			this.caption = value;
		} else if (key === 'fn') {
			this.fn = value;
		} else if (key === 'category') {
			this.category = value;
			this.categoryWeight = this._calculateCategoryWeight();
		} else if (key === 'weight') {
			this.weight = value;
		} else {
			throw new Error('Invalid property for PageAction: ' + key);
		}
	};

	PageAction.prototype.execute = function () {
		this.fn.call(window);
	};

	PageAction.prototype._calculateCategoryWeight = function () {
		if (this.category in CATEGORY_WEIGHTS) {
			return CATEGORY_WEIGHTS[this.category] * 1000;
		}
		return 100 * 1000;
	};

	function register(pageAction, canReplace) {
		if (!(pageAction instanceof PageAction)) {
			throw new Error('Invalid argument - requires PageAction instance');
		}
		if (!canReplace && (pageAction.id in byId)) {
			throw new Error('Could not register more than one action with the same ID: ' + pageAction.id);
		}
		all.push(pageAction);
		byId[pageAction.id] = pageAction;
	}

	function add(desc, canReplace) {
		var id = desc.id,
			caption = desc.caption,
			category = desc.category,
			fn, pageAction;
		if (!id || !caption) {
			console.error('Invalid action description - missing id and/or caption: ', desc);
		}
		if (desc.href) {
			fn = function () {
				window.location.href = desc.href;
			};
		}
		if (desc.fn) {
			fn = desc.fn;
		}
		if (!fn) {
			console.error('Invalid action description - missing action specifier: ', desc);
		}
		pageAction = new PageAction(id, caption, fn, category, desc.weight);
		register(pageAction, canReplace);
	}

	function find(id) {
		return byId[id];
	}

	function sortList(pageActions) {
		var items = pageActions.map(function (pageAction) {
			return [
				[pageAction.categoryWeight, pageAction.category, pageAction.weight, pageAction.caption],
				pageAction
			];
		});
		items.sort(function (a, b) {
			for (var i = 0; i < a[0].length; i++) {
				if (a[0][i] < b[0][i]) {
					return -1;
				} else if (a[0][i] > b[0][i]) {
					return 1;
				}
			}
			return 0;
		});
		return items.map(function (item) {
			return item[1];
		});
	}

	// default actions
	(window.wgWikiaPageActions || []).forEach(function (actionDesc) {
		add(actionDesc);
	});

	return {
		all: all,
		add: add,
		find: find,
		sortList: sortList
	};
});

require(['jquery', 'GlobalShortcuts'], function ($, gs) {
	'use strict';
	$(gs);
});
