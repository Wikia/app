/* global describe, modules, expect, it, spyOn */
describe('wikia.dom', function() {
	'use strict';
	var tree, docMock = {},
		domModule = modules['wikia.dom'](docMock);

	function Node(classes) {
		var self = this;
		this.classList = {
			contains: function(className) {
				return className === self.classes;
			}
		};

		this.classes = classes;
		this.parentNode = '';
	}

	function createTree(nodesLevel) {
		var nodes = [];
		for (var i=nodesLevel; i>0; i--) {
			nodes[i] = new Node(i.toString());
		}

		for (var j=nodesLevel; j>0; j--) {
			nodes[j].parentNode = nodes[j-1] || '';
		}

		return nodes;
	}

	it('Find closest element with given class', function() {
		tree = createTree(1);
		//Check if correct element is returned when first element is the wanted one
		expect(domModule.closestByClassName(tree[1], '1')).toBe(tree[1]);
		tree = createTree(5);
		//Check if correct element is returned when wanted element is 4th parent
		expect(domModule.closestByClassName(tree[5], '1')).toBe(tree[1]);
	});

	it('Return false when given element is not found or not reachable because of provided range', function() {
		tree = createTree(5);
		//Check if false is returned if element is not reachable
		expect(domModule.closestByClassName(tree[5], '6')).toBe(false);
		//Check if false is returned if element is not reachable because maxParentsCount is set
		expect(domModule.closestByClassName(tree[5], '1', 3)).toBe(false);
	});

	it('Find closest element with given class when range is provided', function() {
		tree = createTree(6);
		//Check if correct element is returned when wanted element is reachable because maxParentsCount is set
		expect(domModule.closestByClassName(tree[6], '1', 6)).toBe(tree[1]);

	});
});

describe('wikia.dom', function(){
	'use strict';
	var classes = [],
		elementMock = {
			classList: {
				add: function(className) {
					classes.push(className);
				}
			}
		},
		docMock = {
			createElement: function() {return elementMock;}
		}, domModule;

	domModule = modules['wikia.dom'](docMock);

	it('Throw an error when wrong argument type is provided', function() {
		//Check if Error is thrown when wrong type of argument is provided
		expect(function() {
			domModule.createElementWithClass('div', 'foo');
		}).toThrow('Classes argument must be an array');
	});

	it('Check if class is added when class list was initially empty', function() {
		domModule.createElementWithClass('div', ['foo']);

		//Check if correct classes are added to element if classes were empty
		expect(classes).toEqual(['foo']);
	});

	it('Check if class is added when class list contains some elements initially', function() {
		classes = ['foo'];
		domModule.createElementWithClass('div', ['bar']);

		//Check if classes contains newly added class and already existing one
		expect(classes).toEqual(['foo', 'bar']);
	});
});
