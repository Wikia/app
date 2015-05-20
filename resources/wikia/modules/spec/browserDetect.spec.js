/* global describe, modules, expect, it */
describe('browserDetect', function () {
	'use strict';

	var winMock = {
			navigator: {
				userAgent: ''
			}
		},
		browserDetectModule;

	it('Check if position fixed is not supported for iPad with iOS7', function () {
		winMock.navigator.userAgent =
			'Mozilla/5.0 (iPad; CPU OS 7_0 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53';

		browserDetectModule = modules['wikia.browserDetect'](winMock);
		expect(browserDetectModule.isIOS7orLower()).toBe(true);
	});

	it('Check if position fixed is not supported for iPad with iOS6', function () {
		winMock.navigator.userAgent =
			'Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53';

		browserDetectModule = modules['wikia.browserDetect'](winMock);
		expect(browserDetectModule.isIOS7orLower()).toBe(true);
	});

	it('Check if position fixed is supported for iPad with iOS8', function () {
		winMock.navigator.userAgent =
			'Mozilla/5.0 (iPad; CPU OS 8_0 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53';

		browserDetectModule = modules['wikia.browserDetect'](winMock);
		expect(browserDetectModule.isIOS7orLower()).toBe(false);
	});

	it('Check if position fixed is supported for Android device', function () {
		winMock.navigator.userAgent =
			'Mozilla/5.0 (Linux; Android 4.3; Nexus 7 Build/JSS15Q) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.72 Safari/537.36';
		browserDetectModule = modules['wikia.browserDetect'](winMock);
		expect(browserDetectModule.isIOS7orLower()).toBe(false);
	});
});
