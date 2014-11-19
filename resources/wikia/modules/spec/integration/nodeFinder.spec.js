describe('nodeFinder', function(){
	'use strict';

	var nodeFinder,
		articleMock = document.createElement('div'),
		extenderMock = document.createElement('div'),
		h2Mock = document.createElement('h2'),
		noscriptMock = document.createElement('noscript'),
		hiddenMock = document.createElement('div'),
		zeroHeightMock = document.createElement('div'),
		textNode = document.createTextNode('foo'),
		cloneNode,
		id;

	articleMock.id = 'article-content';
	extenderMock.style.height = '200px';
	hiddenMock.style.visibility = 'hidden';
	zeroHeightMock.style.height = '0';

	for(id = 0; id < 10; id ++) {
		cloneNode = extenderMock.cloneNode();
		articleMock.appendChild(cloneNode);
		h2Mock.id = 'h2-' + id;
		cloneNode = h2Mock.cloneNode();
		articleMock.appendChild(cloneNode);
	}

	articleMock.appendChild(noscriptMock);
	articleMock.appendChild(hiddenMock);
	articleMock.appendChild(zeroHeightMock);
	articleMock.appendChild(textNode);

	document.body.appendChild(articleMock);

	nodeFinder = modules['wikia.nodeFinder']();

	it('header should returned', function() {
		var header = nodeFinder.getChildByOffsetTop(articleMock, 'h2', 100);
		expect(header.id).toBe('h2-0');

		header = nodeFinder.getChildByOffsetTop(articleMock, 'h2', 300);
		expect(header.id).toBe('h2-1');

		header = nodeFinder.getChildByOffsetTop(articleMock, 'h2', 1000);
		expect(header.id).toBe('h2-4');
	});
});
