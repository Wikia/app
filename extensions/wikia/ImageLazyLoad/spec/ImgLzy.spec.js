describe('Image lazy loading', function () {
	// use an imaginary 1000px tall window viewport for test
	var windowMock = {
		innerHeight: 1000
	};

	var ImgLzy = modules['wikia.ImgLzy']($, windowMock);

	var visibleTestCases = {
		'nearby image below viewport': { top: 1600, bottom: 2000 },
		'nearby image above viewport': { top: -1000, bottom: -600 },
		'image within viewport': { top: 500, bottom: 900 }
	};

	Object.keys(visibleTestCases).forEach(function (testName) {
		var mockElement = {
			getBoundingClientRect: function () {
				return visibleTestCases[testName];
			}
		};

		it('considers' + testName + 'visible when element is not hidden', function () {
			mockElement.offsetParent = true;

			expect(ImgLzy.isVisibleInViewport(mockElement)).toBe(true);
		});

		it('does not consider' + testName + ' visible when element is hidden', function () {
			mockElement.offsetParent = false;

			expect(ImgLzy.isVisibleInViewport(mockElement)).toBe(false);
		});
	});

	var notVisibleTestCases = {
		'distant image below viewport': { top: 1800, bottom: 2300 },
		'distant image above viewport': { top: -2000, bottom: -1400 },
	};

	Object.keys(notVisibleTestCases).forEach(function (testName) {
		var mockElement = {
			offsetParent: true,
			getBoundingClientRect: function () {
				return notVisibleTestCases[testName];
			}
		};

		it('considers ' + testName + ' not visible', function () {
			expect(ImgLzy.isVisibleInViewport(mockElement)).toBe(false);
		});
	});

	it('manually loads image', function () {
		var image = document.createElement('img');
		image.setAttribute('data-src', 'http://www.example.com/');
		image.className = 'lzy lzyPlcHld';

		ImgLzy.load(image);

		expect(image.className).toBe('');
		expect(image.src).toBe('http://www.example.com/');
	});
});
