define('GlobalShortcuts', ['Mousetrap', 'mw', 'PageActions'], function (Mousetrap, mw, PageActions) {
	'use strict';

	var all = {},
		INITIAL_SHORTCUTS = {
			// Actions
			delete: ['d'],
			edit: ['e'],
			flag: ['f'],
			move: ['m'],
			startWikia: ['s'],
			classify: ['k'],
			// Global navigation
			discussions: ['g d'],
			history: ['g h'],
			insights: ['g i'],
			recentChanges: ['g r'],
			// Local navigation / focus
			help: ['?'],
			search: [ 'g s', '/' ]
		};

	function initShortcut( actionId, key ) {
		console.log('Installing shortcut "' + key + '" for ' + actionId);
		Mousetrap.bind(key,function(){
			console.log('Triggered shortcut "' + key + '" for ' + actionId);
			PageActions.find(actionId).action();
		});
	}

	function add( actionId, key ) {
		if (!PageActions.find(actionId)) {
			throw new Error('Unknown action: ' + actionId);
		}
		var current = (actionId in all) ? all[actionId] : [];
		if (current.indexOf(key)==-1) {
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
