define('GlobalShortcuts.RenderKeys',
	['mw', 'wikia.nirvana', 'wikia.mustache'],
	function (mw, nirvana, mustache) {
		'use strict';

		var templates = {},
			orSeparator = {combo:{or:1}};

		function loadTemplates() {
			return templates.keyCombination || $.Deferred(function (dfd) {
					Wikia.getMultiTypePackage({
						mustache: 'extensions/wikia/GlobalShortcuts/templates/KeyCombination2.mustache',
						callback: function (pkg) {
							templates.keyCombination = pkg.mustache[0];
							dfd.resolve(templates);
						}
					});
					return dfd.promise();
				});
		}
		loadTemplates();

		function insertBetween(arr, elem) {
			var len = arr.length,
				newArr = [];
			for (var i = 0; i < len; i++) {
				newArr.push(arr[i]);
				if (i < len - 1) {
					newArr.push(elem);
				}
			}
			return newArr;
		}

		function formatShortcuts (keyCombinations) {
			var data = insertBetween(splitKeys(keyCombinations), orSeparator);

			// Prapare object for mustache
			for (var key in data) {
				if (!!data[key].combo[0]) {
					data[key].combo = data[key].combo.map(function (key) {
						switch (key) {
							case ' ':
								return {space: 1};
							case '+':
								return {plus: 1};
							default:
								return {key: key};
						}
					});
				}
			}

			return mustache.render(templates.keyCombination, {
				keyCombination: data,
				class: 'key-combination-in-suggestions'
			});
		}

		function splitKeys(keyCombinations) {
			return keyCombinations.map(splitComboBySpace);
		}

		function splitComboBySpace(singleCombo) {
			var comboBySpace,
				comboBySpaceAndPlus;
			comboBySpace = insertBetween(singleCombo.split(' '), ' ');
			comboBySpaceAndPlus = splitComboByPlus(comboBySpace);

			// Return object prepared for mustache
			return {combo: comboBySpaceAndPlus};
		}

		function splitComboByPlus(comboBySpace) {
			var comboBySpaceAndPlus = comboBySpace.map(splitComboByPlusMap);
			comboBySpaceAndPlus = flattenOneLevNest(comboBySpaceAndPlus);
			return comboBySpaceAndPlus;
		}
		function splitComboByPlusMap(singleCombo) {
			return insertBetween(singleCombo.split('+'), '+');
		}

		function flattenOneLevNest(arr) {
			return arr.concat.apply([], arr);
		}

		return {
			formatShortcuts: formatShortcuts
		};
	}
);
