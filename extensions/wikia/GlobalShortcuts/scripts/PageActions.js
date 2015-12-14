define('PageActions', ['mw'], function (mw) {
	'use strict';

	var globalShortcutsConfig = mw.config.get('globalShortcutsConfig');

	var all = [],
		byId = {};

	function PageAction( id, caption, action, category ) {
		this.id = id;
		this.caption = caption;
		this.action = action;
		this.category = category || 'Other';
	}

	function add( id, caption, action, category ) {
		var o = new PageAction(id,caption,action,category);
		if (id in byId) {
			throw new Error('Could not register more than one action with the same ID: ' + id);
		}
		all.push(o);
		byId[id] = o;
	}

	function addFromDesc( desc ) {
		var id = desc.id,
			caption = desc.caption,
			category = desc.category,
			action;
		if (!id||!caption) {
			console.error('Invalid action description - missing id and/or caption: ',desc);
		}
		if (desc.href) {
			action = function() {
				window.location.href = desc.href;
			}
		}
		if (!action) {
			console.error('Invalid action description - missing action specifier: ',desc);
		}
		add(id,caption,action,category);
	}

	function addMany( o ) {
		for (var key in o) {
			if (o.hasOwnProperty(key)) {
				add(key, o[key][0], o[key][1]);
			}
		}
	}

	function find(id) {
		return byId[id];
	}

	// default actions
	addMany({
		'delete': ['Delete page', function(){
			$('[accesskey=d]')[0].click();
		}],
		'edit': ['Edit page', function(){
			$('#ca-edit')[0].click();
		}],
		'flag': ['Change page flags', function(){
			$('#ca-flags')[0].click();
		}],
		'move': [ 'Move page', function() {
			$('[accesskey=m]')[0].click();
		}],
		'startWikia': [ 'Start a new wikia', function(){
			$('[data-id=start-wikia]')[0].click();
		}],
		'classify': [ 'Classify page', function() {
			require(['TemplateClassificationModal'], function shortcutOpenTemplateClassification(tc) {
				tc.open();
			});
		}],
		'discussions': [ 'Open discussions', function() {
			window.location.href = mw.config.get('location').origin + '/d';
		}],
		'history': [ 'Open page history', function() {
			$('[accesskey=h]')[0].click();
		}],
		'help': [ 'Keyboard shortcuts help', function () {
			require(['GlobalShortcutsHelp'], function(help) {
				help.open();
			});
		}],
		'search': [ 'Search for a page', function(){
			$('#searchInput')[0].focus();
		}],
		'actionSearch': [ 'Action explorer', function(){
			require(['GlobalShortcutsSearch'], function(GlobalShortcutsSearch){
				var searchModal = new GlobalShortcutsSearch();
				searchModal.open();
			});
		}]
	});

	(window.wgWikiaPageActions||[]).forEach(function(actionDesc){
		addFromDesc(actionDesc);
	});

	return {
		all: all,
		add: add,
		find: find
	}
});

require(['jquery', 'GlobalShortcuts'], function ($, gs) {
	'use strict';
	$(gs);
});
