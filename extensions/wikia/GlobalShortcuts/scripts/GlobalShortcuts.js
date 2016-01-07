define('GlobalShortcuts', ['Mousetrap', 'mw', 'PageActions'], function (Mousetrap, mw, PageActions) {
	'use strict';

	var all = {},
		INITIAL_SHORTCUTS = {
			// Actions
			'page:Delete': ['d'],
			'page:Edit': ['e'],
			'page:Flag': ['f'],
			'page:Move': ['m'],
			'general:StartWikia': ['s'],
			'page:Classify': ['k'],
			// Global navigation
			'page:Discussions': ['g d'],
			'page:History': ['g h'],
			'special:Insights': ['g i'],
			'special:Recentchanges': ['g r'],
			// Local navigation / focus
			'help:Keyboard': ['?'],
			'wikia:Search': [ 'g s', '/' ],
			'help:Actions': [ '.' ]
		};

	function initShortcut(actionId, key) {
		console.log('Installing shortcut "' + key + '" for ' + actionId);
		Mousetrap.bind(key,function(){
			console.log('Triggered shortcut "' + key + '" for ' + actionId);
			PageActions.find(actionId).execute();
		});
	}

	function add(actionId, key) {
		if (!PageActions.find(actionId)) {
			throw new Error('Unknown action: ' + actionId);
		}
		var current = (actionId in all) ? all[actionId] : [];
		if (current.indexOf(key) === -1) {
			current.push(key);
			all[actionId] = current;
			initShortcut(actionId,key);
		}
	}

	function find(actionId) {
		return (actionId in all) ? all[actionId] : [];
	}

	Object.keys(INITIAL_SHORTCUTS).forEach(function(id){
		INITIAL_SHORTCUTS[id].forEach(function(key){
			add(id,key);
		});
	});

	return {
		all: all,
		add: add,
		find: find
	};
});

require(['GlobalShortcuts'], function (gs) {
});
