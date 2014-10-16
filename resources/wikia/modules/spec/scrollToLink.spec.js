describe("scrollToLink", function () {
	"use strict";

	// mock window
	var windowMock = {
			document: {
				title: '',
				getElementById: function() {
					return {};
				}
			},
			setTimeout: function() {},
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
		querystringMock = function(){
			return {
				sanitizeHref: function(h) {
					return (h.length > 0) ? h.slice(1) : '';
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
		jQueryMock = function(){
			return {
				offset: function(){
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
		expect(typeof scrollToLinkApi.disableBrowserJump).toBe('function', 'disableBrowserJump');
	});
	//
	it('properly resets browser jump', function() {
		windowMock.position.y = 10;
		windowMock.location.hash = '#hash';

		scrollToLinkApi.disableBrowserJump();
		expect(windowMock.position.y).toBe(0);
	});

	it('handles scrollTo', function() {
		var result = false,
			previous;

		result = scrollToLinkApi.handleScrollTo('#hash', 20);
		expect(result).toBe(true);
		expect(windowMock.position.y).toBe(30);
		expect(historyMock.state.url).toBe('pathname#hash');

		result = scrollToLinkApi.handleScrollTo('#hash2', 50);
		expect(result).toBe(true);
		expect(windowMock.position.y).toBe(60);
		expect(historyMock.state.url).toBe('pathname#hash2');

		result = scrollToLinkApi.handleScrollTo('#hash.9', 15);
		expect(result).toBe(true);
		expect(windowMock.position.y).toBe(25);
		expect(historyMock.state.url).toBe('pathname#hash.9');

		result = scrollToLinkApi.handleScrollTo('#hash 1 2 3', 17);
		expect(result).toBe(true);
		expect(windowMock.position.y).toBe(27);
		expect(historyMock.state.url).toBe('pathname#hash 1 2 3');

		windowMock.position.y = 5;
		previous = historyMock.state.url;
		result = scrollToLinkApi.handleScrollTo('#', 15);
		expect(result).toBe(false);
		expect(windowMock.position.y).toBe(5);
		expect(historyMock.state.url).toBe(previous);
	});
});
