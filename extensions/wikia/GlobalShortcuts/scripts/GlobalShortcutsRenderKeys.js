define('GlobalShortcuts.RenderKeys',
	['mw', 'wikia.nirvana', 'wikia.mustache'],
	function (mw, nirvana, mustache) {
		'use strict';

		var templates = {},
			orSeparator = {or:1};

		function loadTemplates() {
			return $.Deferred(function (dfd) {
					if (templates.keyCombination) {
						dfd.resolve(templates);
						return dfd.promise();
					}
					Wikia.getMultiTypePackage({
						mustache: 'extensions/wikia/GlobalShortcuts/templates/KeyCombination2.mustache',
						messages: 'GlobalShortcuts',
						callback: function (pkg) {
							mw.messages.set(pkg.messages);
							templates.keyCombination = pkg.mustache[0];
							dfd.resolve(templates);
						}
					});
					return dfd.promise();
				});
		}

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

		function getHtml (keyCombinations) {
			if (!templates.keyCombination) {
				throw new Error('Required template is not loaded yet. ' +
				'Please call loadTemplates method before and wait for resolution.');
			}
			var data;
			keyCombinations = keyCombinations.map(wrapToArr);
			// Split combos by or
			data = insertBetween(keyCombinations, orSeparator);
			// Split each combo by space
			data = splitCombosBySpace(data);
			// Split each combo by plus
			data = splitCombosByPlus(data);

			data = wrapCombos(data);
			// Prapare object for mustache
			for (var key in data) {
				if (data[key].combo[0]) {
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
				class: 'key-combination-in-suggestions',
				orMsg: mw.message('global-shortcuts-key-or').plain(),
				thenMsg: mw.message('global-shortcuts-key-then').plain()
			});
		}

		function wrapToArr(item) {
			return [].concat(item);
		}

		function splitCombosBySpace(keyCombinations) {
			var comboBySpaceAndPlus = [];
			keyCombinations.forEach(function (keys, ind) {
				if (!keys[0]) {
					comboBySpaceAndPlus[ind] = keys;
					return;
				}
				comboBySpaceAndPlus[ind] = keys.map(splitComboBySpaceMap);
			});
			comboBySpaceAndPlus = flattenOneLevNest(comboBySpaceAndPlus);
			return comboBySpaceAndPlus;
		}

		function splitComboBySpaceMap(singleCombo) {
			return insertBetween(singleCombo.split(' '), ' ');
		}

		function splitCombosByPlus(keyCombinations) {
			var comboBySpaceAndPlus = [];
			keyCombinations.forEach(function (keys, ind) {
				if (!keys[0]) {
					comboBySpaceAndPlus[ind] = keys;
					return;
				}
				comboBySpaceAndPlus[ind] = keys.map(splitComboByPlusMap);
			});
			comboBySpaceAndPlus = flattenOneLevNest(comboBySpaceAndPlus);
			return comboBySpaceAndPlus;
		}
		function splitComboByPlusMap(singleCombo) {
			return insertBetween(singleCombo.split('+'), '+');
		}

		function wrapCombos(combos) {
			return combos.map(wrapCombo);
		}

		function wrapCombo(combo) {
			return {combo:combo};
		}

		function flattenOneLevNest(arr) {
			return arr.concat.apply([], arr);
		}

		return {
			getHtml: getHtml,
			loadTemplates: loadTemplates
		};
	}
);
