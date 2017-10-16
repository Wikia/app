/* global describe, modules, expect, it */
describe('wikia.dom', function () {
	'use strict';
	var tree, docMock = {},
		domModule = modules['wikia.dom'](docMock),
		tagNames = ['DIV', 'H1', 'A', 'SPAN', 'IMG'];

	/**
	 * Create Node
	 * @param {String} classes - classes which should be set in new node
	 * @constructor
	 */
	function Node(classes) {
		var self = this,
			classesNames = classes.toString(),
			tagName = tagNames[(classes % 6) - 1];

		this.classList = {
			contains: function (className) {
				return className === self.classes;
			}
		};

		this.classes = classesNames;
		this.tagName = tagName;
		this.parentNode = '';
	}

	/**
	 * Create tree of connected nodes
	 * @param {Number} nodesLevel - how deep should be newly created tree
	 * @returns {Array} created tree
	 */
	function createTree(nodesLevel) {
		var nodes = [];
		for (var i = nodesLevel; i > 0; i--) {
			nodes[i] = new Node(i);
		}

		for (var j = nodesLevel; j > 0; j--) {
			nodes[j].parentNode = nodes[j - 1] || '';
		}

		return nodes;
	}

	it('Find closest element with given class', function () {
		tree = createTree(1);
		//Check if correct element is returned when first element is the wanted one
		expect(domModule.closestByClassName(tree[1], '1')).toBe(tree[1]);
		tree = createTree(5);
		//Check if correct element is returned when wanted element is 4th parent
		expect(domModule.closestByClassName(tree[5], '1')).toBe(tree[1]);
	});

	it('Return false when given element is not found or not reachable because of provided range', function () {
		tree = createTree(5);
		//Check if false is returned if element is not reachable
		expect(domModule.closestByClassName(tree[5], '6')).toBe(false);
		//Check if false is returned if element is not reachable because maxParentsCount is set
		expect(domModule.closestByClassName(tree[5], '1', 3)).toBe(false);
	});

	it('Find closest element with given class when range is provided', function () {
		tree = createTree(6);
		//Check if correct element is returned when wanted element is reachable because maxParentsCount is set
		expect(domModule.closestByClassName(tree[6], '1', 6)).toBe(tree[1]);
	});

	it('Find closest element with given tag name', function () {
		tree = createTree(1);
		//Check if correct element is returned when first element is the wanted one
		expect(domModule.closestByTagName(tree[1], 'div')).toBe(tree[1]);
		tree = createTree(5);
		//Check if correct element is returned with different combinations
		expect(domModule.closestByTagName(tree[5], 'div')).toBe(tree[1]);
		expect(domModule.closestByTagName(tree[5], 'h1')).toBe(tree[2]);
		expect(domModule.closestByTagName(tree[4], 'a')).toBe(tree[3]);
	});

	it('Return false when given element is not found or not reachable because of provided range', function () {
		tree = createTree(5);
		//Check if false is returned if element is not reachable
		expect(domModule.closestByTagName(tree[5], 'section')).toBe(false);
		//Check if false is returned if element is not reachable because maxParentsCount is set
		expect(domModule.closestByTagName(tree[5], 'h1', 2)).toBe(false);
	});
});

describe('wikia.dom', function () {
	'use strict';
	var classes = [],
		elementMock = {
			classList: {
				add: function (className) {
					classes.push(className);
				}
			}
		},
		docMock = {
			createElement: function () {
				return elementMock;
			}
		},
		domModule;

	domModule = modules['wikia.dom'](docMock);

	it('Throw an error when wrong argument type is provided', function () {
		//Check if Error is thrown when wrong type of argument is provided
		expect(function () {
			domModule.createElementWithClass('div', 'foo');
		}).toThrow(new Error('Classes argument must be an array'));
	});

	it('Check if class is added when class list was initially empty', function () {
		domModule.createElementWithClass('div', ['foo']);

		//Check if correct classes are added to element if classes were empty
		expect(classes).toEqual(['foo']);
	});

	it('Check if class is added when class list contains some elements initially', function () {
		classes = ['foo'];
		domModule.createElementWithClass('div', ['bar']);

		//Check if classes contains newly added class and already existing one
		expect(classes).toEqual(['foo', 'bar']);
	});
});
