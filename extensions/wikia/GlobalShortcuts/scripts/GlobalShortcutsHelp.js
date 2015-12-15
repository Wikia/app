define('GlobalShortcutsHelp',
	['mw', 'wikia.nirvana', 'wikia.mustache', 'wikia.throbber', 'GlobalShortcuts', 'PageActions'],
	function (mw, nirvana, mustache, throbber, GlobalShortcuts, PageActions) {
		'use strict';

		var modalConfig,
			templates = {};

		function open() {
			throbber.cover();

			$.when(
				loadTemplates()
			).done(handleRequestsForModal);
		}

		function loadTemplates() {
			return templates.keyCombination || $.Deferred(function (dfd) {
					Wikia.getMultiTypePackage({
						mustache: 'extensions/wikia/GlobalShortcuts/templates/KeyCombination.mustache,' +
							'extensions/wikia/GlobalShortcuts/templates/GlobalShortcutsController_help.mustache',
						callback: function (pkg) {
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
			setupTemplateClassificationModal(
				mustache.render(templates.help, {actions: data})
			);
			require(['wikia.ui.factory'], function (uiFactory) {
				/* Initialize the modal component */
				uiFactory.init(['modal']).then(createComponent);
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
				keysCount;

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
			keyCombinationHtml = mustache.render(templates.keyCombination, {keyCombination:keyCombination});
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
			/* Show the modal */
			modalInstance.show();
			throbber.uncover();
			// Add footer hint
			modalInstance.$element.find('footer')
				.html('Press <span class="key">.</span> to explore shortcuts.');
		}

		function setupTemplateClassificationModal(content) {
			/* Modal component configuration */
			modalConfig = {
				vars: {
					id: 'GlobalShortcutsHelp',
					classes: ['global-shortcuts-help'],
					size: 'medium', // size of the modal
					content: content, // content
					title: 'Keyboard shortcuts'
				}
			};
		}

		return {
			open: open
		};
	}
);
