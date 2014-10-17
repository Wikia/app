/* global describe, modules, expect, it, spyOn */
describe('wikia.dom', function() {
	'use strict';

	it('Find closest element with give class', function() {
		var docMock = {},
			domModule = modules['wikia.dom'](docMock),
			tree;

		function createNode(id) {
			return {
				classList: {
					contains: function(className) {
						return parseInt(className) === id;
					}
				},
				className: id,
				parentNode: ''
			};
		}

		function createTree(nodesLevel) {
			var nodes = [];
			for (var i=nodesLevel; i>0; i--) {
				nodes[i] = createNode(i);
			}

			for (var j=nodesLevel; j>0; j--) {
				nodes[j].parentNode = nodes[j-1];
			}

			return nodes;
		}

		tree = createTree(1);
		//Check if correct element is returned when first element is the wanted one
		expect(domModule.closestByClassName(tree[1], '1')).toBe(tree[1]);

		tree = createTree(5);
		//Check if correct element is returned when wanted element is 4th parent
		expect(domModule.closestByClassName(tree[5], '1')).toBe(tree[1]);
		//Check if false is returned if element is not reachable
		expect(domModule.closestByClassName(tree[5], '6')).toBe(false);
		//Check if false is returned if element is not reachable because maxParentsCount is set
		expect(domModule.closestByClassName(tree[5], '1', 3)).toBe(false);

		tree = createTree(6);
		//Check if correct element is returned when wanted element is reachable because maxParentsCount is set
		expect(domModule.closestByClassName(tree[6], '1', 6)).toBe(tree[1]);
	});

	it('Create element with given class list', function() {
		var classes = [],
			elementMock = {
				classList: {
					add: function(className) {
						classes.push(className);
					}
				}
			},
			docMock = {
				createElement: function() {
					return;
				}
			}, domModule;

		spyOn(docMock, 'createElement').andReturn(elementMock);
		domModule = modules['wikia.dom'](docMock);

		//Check if Error is thrown when wrong type of argument is provided
		expect(function() {
			domModule.createElementWithClass('div', 'foo');
		}).toThrow('Classes argument must be an array');

		//Check if createElement method is not called when wrong type of argument is provided
		expect(docMock.createElement.calls.length).toBe(0);

		domModule.createElementWithClass('div', []);
		//Check if createElement method is called when correct type of argument is provided
		expect(docMock.createElement.calls.length).toBe(1);

		domModule.createElementWithClass('div', ['foo']);
		//Check if correct classes are added to element if classes was empty
		expect(classes).toEqual(['foo']);

		domModule.createElementWithClass('div', ['bar']);
		//Check if classes contains newly added class and already existing one
		expect(classes).toEqual(['foo', 'bar']);
	});
});
