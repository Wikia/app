/**
 * Module contains list of actions that can be performed.
 * (actions doesn't necessarily need to have shortcut keys assigned,
 * but if they have it can be found in GlobalShortcuts module)
 * Keeps references on functions that handles actions
 */
define('PageActions', ['mw', 'jquery'], function (mw, $) {
	'use strict';

	var CATEGORY_WEIGHTS = {
			'Current page': 10,
			'Current wikia': 20,
			'Other': 1000
		},
		all = [],
		byId = {},
		globalShortcutsConfig = mw.config.get('globalShortcutsConfig');

	function PageAction(id, caption, fn, category, weight) {
		this.id = id;
		this.caption = '';
		this.fn = $.noop;
		this.category = 'Other';
		this.categoryWeight = this._calculateCategoryWeight();
		this.weight = 500;
		this.update({
			caption: caption,
			fn: fn,
			category: category || 'Other',
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

	function addMany(many) {
		many.forEach(function (one) {
			add(one);
		});
	}

	function addOrOverride(desc, propertiesToOverride) {
		var upd = {};
		if (propertiesToOverride && (desc.id in byId)) {
			propertiesToOverride.forEach(function (property) {
				upd[property] = desc[property];
			});
			find(desc.id).update(upd);
		} else {
			add(desc);
		}
	}

	function addOrOverrideMany(many) {
		many.forEach(function (one) {
			var override;
			one = $.extend({}, one);
			override = one.override || [];
			delete one.override;
			addOrOverride(one, override);
		});
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

	addOrOverrideMany([{
		id: 'page:Delete',
		caption: 'Delete page',
		fn: function () {
			$('[accesskey=d]')[0].click();
		},
		category: 'Current page',
		weight: 900,
		override: ['caption', 'fn', 'weight']
	}, {
		id: 'page:Edit',
		caption: 'Edit page',
		fn: function () {
			$('#ca-edit')[0].click();
		},
		category: 'Current page',
		weight: 100,
		override: ['caption', 'fn', 'weight']
	}, {
		id: 'page:Move',
		caption: 'Move page',
		fn: function () {
			$('[accesskey=m]')[0].click();
		},
		category: 'Current page',
		weight: 900,
		override: ['caption', 'fn', 'weight']
	}, {
		id: 'page:History',
		caption: 'Open page history',
		fn: function () {
			$('[accesskey=h]')[0].click();
		},
		category: 'Current page',
		override: ['caption', 'fn']
	}, {
		id: 'general:StartWikia',
		caption: 'Start a new wikia',
		fn: function () {
			$('[data-id=start-wikia]')[0].click();
		},
		category: 'Global'
	}, {
		id: 'page:Discussions',
		caption: 'Open discussions',
		fn: function () {
			window.location.href = mw.config.get('location').origin + '/d';
		},
		weight: 600,
		category: 'Current page'
	}, {
		id: 'help:Keyboard',
		caption: 'Keyboard shortcuts help',
		fn: function () {
			require(['GlobalShortcutsHelp'], function (help) {
				help.open();
			});
		},
		category: 'Help'
	}, {
		id: 'wikia:Search',
		caption: 'Search for a page',
		fn: function () {
			$('#searchInput')[0].focus();
		},
		category: 'Current wikia'
	}, {
		id: 'help:Actions',
		caption: 'Action list',
		fn: function () {
			require(['GlobalShortcutsSearch'], function (GlobalShortcutsSearch) {
				var searchModal = new GlobalShortcutsSearch();
				searchModal.open();
			});
		},
		category: 'Help'
	}]);

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
