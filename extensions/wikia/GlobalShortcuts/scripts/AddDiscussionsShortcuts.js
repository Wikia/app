/**
 * A module for adding shortcut key to GlobalShortcuts extension for opening discussions page
 */
require(['GlobalShortcuts', 'PageActions', 'mw', 'wikia.loader', 'wikia.window'],
	function (GlobalShortcuts, PageActions, mw, loader, w) {
		'use strict';

		function init() {
			$.when(
				loader({
					type: loader.MULTI,
					resources: {
						messages: 'GlobalShortcuts'
					}
				})
			).done(function (res) {
					mw.messages.set(res.messages);
					addShortcuts();
				});
		}

		function addShortcuts() {
			var actionId = 'page:Discussions',
				actionDescription = {
					id: actionId,
					caption: mw.message('global-shortcuts-caption-open-discussions').plain(),
					fn: openDiscussions,
					weight: 600,
					category: mw.message('global-shortcuts-category-current-wikia').escaped()
				};

			PageActions.add(actionDescription);
			GlobalShortcuts.add(actionId, 'g d');

			function openDiscussions() {
				w.location.href = mw.config.get('location').origin + mw.config.get('wgScriptPath') + '/f';
			}
		}

		init();

	}
);
