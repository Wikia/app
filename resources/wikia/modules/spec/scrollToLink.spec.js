describe("scrollToLink", function() {
	"use strict";

	// mock window
	var windowMock = {
			document: {
				title: '',
				getElementById: function() {
					return {};
				}
			},
			setTimeout: function(func, delay) {
				func();
			},
			location: {
				hash: '',
				pathname: 'pathname'
			},
			position: {
				x: 0,
				y: 0
			},
			scrollTo: function(x, y) {
				this.position.x = x;
				this.position.y = y;
			}
		},
		querystringMock = function() {
			return {
				sanitizeHref: function(h) {
					h = h.trim();
					return (h.length > 0 && h[0] === '#') ? h.slice(1) : '';
				}
			}
		},
		historyMock = {
			state: {
				url: '',
				title: '',
				data: {}
			},
			length: 0,
			pushState: function(data, title, url) {
				this.length++;
				this.state.data = data;
				this.state.title = title;
				this.state.url = url;
				return true;
			}
		},
		jQueryMock = function() {
			return {
				offset: function() {
					return {
						top: 10
					}
				}
			}
		},
		scrollToLinkApi = modules['wikia.scrollToLink'](windowMock, querystringMock, historyMock, jQueryMock);

	it('registers AMD module', function() {
		expect(scrollToLinkApi).toBeDefined();
		expect(typeof scrollToLinkApi).toBe('object');
	});

	it('gives nice and clean API', function() {
		expect(typeof scrollToLinkApi.handleScrollTo).toBe('function', 'handleScrollTo');
	});

	it('handles scrollTo for valid hashes', function() {
		var testData = [{
			params: {
				hash: '#hash',
				offset: 20
			},
			result: {
				success: true,
				y: 30,
				url: 'pathname#hash'
			}
		}, {
			params: {
				hash: '#hash.2',
				offset: 5
			},
			result: {
				success: true,
				y: 15,
				url: 'pathname#hash.2'
			}
		}, {
			params: {
				hash: '#hash 3',
				offset: 100
			},
			result: {
				success: true,
				y: 110,
				url: 'pathname#hash 3'
			}
		}, {
			params: {
				hash: '#hash',
				offset: -10
			},
			result: {
				success: true,
				y: 0,
				url: 'pathname#hash'
			}
		}];

		testData.forEach(function(data) {
			var result = scrollToLinkApi.handleScrollTo(data.params.hash, data.params.offset);

			expect(result).toBe(data.result.success);
			expect(windowMock.position.y).toBe(data.result.y);
			expect(historyMock.state.url).toBe(data.result.url);
		});
	});

	it('handles scrollTo for invalid hashes', function() {
		var testData = [{
			prepare: {
				url: 'pathname#previous1',
				y: 100
			},
			params: {
				hash: 'http://some.link.example.com/link',
				offset: 20
			},
			result: false
		}, {
			prepare: {
				url: 'pathname',
				y: 0
			},
			params: {
				hash: '   #   ',
				offset: 20
			},
			result: false
		}];

		testData.forEach(function(data) {
			var result;

			historyMock.state.url = data.prepare.url;
			windowMock.position.y = data.prepare.y;

			result = scrollToLinkApi.handleScrollTo(data.params.hash, data.params.offset);

			expect(result).toBe(data.result);
			expect(windowMock.position.y).toBe(data.prepare.y);
			expect(historyMock.state.url).toBe(data.prepare.url);
		});
	});
});
