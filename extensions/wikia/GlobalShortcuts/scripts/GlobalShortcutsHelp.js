define('GlobalShortcutsHelp',
	['mw', 'wikia.nirvana', 'wikia.mustache', 'GlobalShortcuts', 'PageActions', 'GlobalShortcutsTracking'],
	function (mw, nirvana, mustache, GlobalShortcuts, PageActions, tracker) {
		'use strict';

		var modalConfig,
			templates = {};

		function open() {
			tracker.trackClick('help:Keyboard');

			$.when(
				loadTemplates()
			).done(handleRequestsForModal);
		}

		function loadTemplates() {
			return templates.keyCombination || $.Deferred(function (dfd) {
					Wikia.getMultiTypePackage({
						mustache: 'extensions/wikia/GlobalShortcuts/templates/KeyCombination.mustache,' +
							'extensions/wikia/GlobalShortcuts/templates/GlobalShortcutsController_help.mustache',
						messages: 'GlobalShortcuts',
						callback: function (pkg) {
							mw.messages.set(pkg.messages);
							templates.keyCombination = pkg.mustache[0];
							templates.help = pkg.mustache[1];
							dfd.resolve(templates);
						}
					});
					return dfd.promise();
				});
		}

		function handleRequestsForModal() {
			var data = prepareData();

			// Set modal content
			setupModal(
				mustache.render(templates.help, {actions: data})
			);
			require(['wikia.ui.factory'], function (uiFactory) {
				/* Initialize the modal component */
				$.when(
					uiFactory.init(['modal']),
					mw.loader.using(['mediawiki.jqueryMsg'])
				).then(createComponent);
			});
		}

		function prepareData() {
			var data = [],
				i = 0;
			for (var id in GlobalShortcuts.all) {
				data[i] = {
					keyCombination: parseShortcut(GlobalShortcuts.all[id]),
					label: PageActions.find(id).caption
				};
				i++;
			}
			return data;
		}

		function parseShortcut(combos) {
			var comboNum = 0,
				combosCount,
				keyCombination = [],
				keyCombinationHtml = '',
				keysCount,
				templateParams;

			combosCount = combos.length;
			for (var id in combos) {
				keyCombination[id] = {combo: combos[id].split(' ')};
				keysCount = keyCombination[id].combo.length;
				for (var j = 0; j < keysCount; j++) {
					keyCombination[id].combo[j] = {
						'key': keyCombination[id].combo[j],
						'space': j < keysCount - 1 ? 1 : 0
					};
				}
				keyCombination[id].combo[j - 1].or = comboNum < combosCount - 1 ? 1 : 0;
				comboNum++;
			}
			templateParams = {
				keyCombination: keyCombination,
				orMsg: mw.message('global-shortcuts-key-or').plain(),
				thenMsg: mw.message('global-shortcuts-key-then').plain()
			};
			keyCombinationHtml = mustache.render(templates.keyCombination, templateParams);
			return keyCombinationHtml;
		}

		/**
		 * Creates modal UI component
		 * One of sub-tasks for getting modal shown
		 */
		function createComponent(uiModal) {
			/* Create the wrapping JS Object using the modalConfig */
			uiModal.createComponent(modalConfig, processInstance);
		}

		/**
		 * CreateComponent callback that finally shows modal
		 * and binds submit action to Done button
		 * One of sub-tasks for getting modal shown
		 */
		function processInstance(modalInstance) {
			var dotKey = '<span class="key">.</span>';
			/* Show the modal */
			modalInstance.show();
			// Add footer hint
			modalInstance.$element.find('footer')
				.html(mw.message('template-class-global-shortcuts-press-to-explore-shortcuts', dotKey).parse());
		}

		function setupModal(content) {
			/* Modal component configuration */
			modalConfig = {
				vars: {
					id: 'GlobalShortcutsHelp',
					classes: ['global-shortcuts-help'],
					size: 'medium', // size of the modal
					content: content, // content
					title: mw.message('global-shortcuts-title-keyboard-shortcuts').escaped()
				}
			};
		}

		return {
			open: open
		};
	}
);
