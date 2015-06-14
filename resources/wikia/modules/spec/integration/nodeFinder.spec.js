describe('nodeFinder', function () {
	'use strict';

	var nodeFinder,
		articleNode = document.createElement('div'),
		extenderNode = document.createElement('div'),
		headerNode = document.createElement('h2'),
		noscriptNode = document.createElement('noscript'),
		hiddenNode = document.createElement('div'),
		textNode = document.createTextNode('text node'),
		commentNode = document.createComment('comment node'),
		nonVisibleForSloth = [noscriptNode, hiddenNode, textNode, commentNode],
		nonVisibleInstertionId = 6,
		clonedNode,
		lastNode,
		id,
		// define the callback here to avoid defining an anonymous funcion inside a loop
		appendChildToArticleNode = function (node) {
			articleNode.appendChild(node);
		};

	// prepare node properties
	articleNode.id = 'nodeFinder-article-content';
	articleNode.style.width = '1000px';
	extenderNode.style.height = '200px';
	headerNode.style.height = '20px';
	headerNode.style.margin = '0';
	noscriptNode.id = 'nodeFinder-noscript-node';
	noscriptNode.innerHTML = 'noscript node';
	hiddenNode.style.display = 'none';
	hiddenNode.id = 'nodeFinder-hidden-node';
	hiddenNode.innerHTML = 'hidden node';
	textNode.id = 'nodeFinder-text-node';
	commentNode.id = 'nodeFinder-comment-node';
	document.body.style.margin = '0';

	// create node structure
	for (id = 0; id < 10; id++) {
		extenderNode.id = 'nodeFinder-extender-' + id;
		clonedNode = extenderNode.cloneNode();
		articleNode.appendChild(clonedNode);

		// add nodes which are non visilble for Sloth module in the middle of the testing container
		if (id === nonVisibleInstertionId) {
			nonVisibleForSloth.forEach(appendChildToArticleNode);
		}

		headerNode.id = 'nodeFinder-h2-' + id;
		headerNode.style.width = id === 4 ? '800px' : '1000px';
		clonedNode = headerNode.cloneNode();
		articleNode.appendChild(clonedNode);
	}

	// save the last visible node
	lastNode = articleNode.lastChild;

	// add nodes which are non visilble for Sloth module at the end of the testing container
	nonVisibleForSloth.forEach(function (node) {
		clonedNode = node.cloneNode(true);
		clonedNode.id += '-aricle-end';
		articleNode.appendChild(clonedNode);
	});

	// render the nodes
	document.body.appendChild(articleNode);

	// load the tested module
	nodeFinder = modules['wikia.nodeFinder']();

	// define the testing rules
	it('getChildByOffsetTop should return a node', function () {
		var header = nodeFinder.getFullWidthChildByOffsetTop(articleNode, 'h2', 100);
		expect(header.id).toBe('nodeFinder-h2-0');

		header = nodeFinder.getFullWidthChildByOffsetTop(articleNode, 'h2', 300);
		expect(header.id).toBe('nodeFinder-h2-1');

		header = nodeFinder.getFullWidthChildByOffsetTop(articleNode, 'h2', 1000);
		expect(header.id).toBe('nodeFinder-h2-5');
	});

	it('getPreviousVisibleSibling should return a node', function () {
		var referenceNode = document.getElementById('nodeFinder-h2-' + nonVisibleInstertionId),
			previousNode = document.getElementById('nodeFinder-extender-' + nonVisibleInstertionId),
			previousVisibleSibling = nodeFinder.getPreviousVisibleSibling(referenceNode);

		expect(previousVisibleSibling.id).toBe(previousNode.id);
	});

	it('getLastVisibleChild should return a node', function () {
		var lastVisibleElement = nodeFinder.getLastVisibleChild(articleNode);

		expect(lastVisibleElement.id).toBe(lastNode.id);
	});
});
