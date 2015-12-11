define('PageActions', ['mw'], function (mw) {
	'use strict';

	var globalShortcutsConfig = mw.config.get('globalShortcutsConfig');

	var all = [],
		byId = {};

	function PageAction( id, caption, action ) {
		this.id = id;
		this.caption = caption;
		this.action = action;
	}

	function add( id, caption, action ) {
		var o = new PageAction(id,caption,action);
		if (id in byId) {
			throw new Error('Could not register more than one action with the same ID: ' + id);
		}
		all.push(o);
		byId[id] = o;
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
		'insights': [ 'Open Wikia Insights', function() {
			window.location.href = globalShortcutsConfig.insights;
		}],
		'recentChanges': [ 'Recent changes list', function(){
			window.location.href = globalShortcutsConfig.recentChanges;
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
