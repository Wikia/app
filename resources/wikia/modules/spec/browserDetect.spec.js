/*global describe, modules, expect, it*/
describe('browserDetect', function () {
	'use strict';

	var winMock = {
			navigator: {
				userAgent: ''
			}
		},
		browserDetectModule;

	it('Validates Firefox userAgent', function() {
		winMock.navigator.userAgent =
			'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:33.0) Gecko/20100101 Firefox/33.0';

		browserDetectModule = modules['wikia.browserDetect'](winMock);
		expect(browserDetectModule.isFirefox()).toBe(true);
	});

	it('Validates Chrome userAgent if Chrome', function() {
		winMock.navigator.userAgent =
			'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36';

		browserDetectModule = modules['wikia.browserDetect'](winMock);
		expect(browserDetectModule.isChrome()).toBeTruthy();
	});

	it('Validates Chrome userAgent if Firefox', function() {
		winMock.navigator.userAgent =
			'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:33.0) Gecko/20100101 Firefox/33.0';

		browserDetectModule = modules['wikia.browserDetect'](winMock);
		expect(browserDetectModule.isChrome()).toBeFalsy();
	});

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

	it('Get OS and browser name with version', function () {
		var testCases = [
			{
				userAgent: 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.8.1.12) Gecko/20080214 Firefox/2.0.0.12',
				os: 'Linux',
				browser: 'Firefox 2',
				version: 2
			},
			{
				userAgent: 'Mozilla/5.0 (Windows NT 6.1; rv:15.0) Gecko/20120716 Firefox/15.0a2',
				os: 'Windows',
				browser: 'Firefox 15',
				version: 15
			},
			{
				userAgent: 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:25.0) Gecko/20100101 Firefox/25.0',
				os: 'OSX',
				browser: 'Firefox 25',
				version: 25
			},
			{
				userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.10240',
				os: 'Windows',
				browser: 'Edge 12',
				version: 12
			},
			{
				userAgent: 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.45 Safari/535.19',
				os: 'OSX',
				browser: 'Chrome 18',
				version: 18
			},
			{
				userAgent: 'Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5',
				os: 'Windows',
				browser: 'Safari 5',
				version: 5
			},
			{
				userAgent: 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53',
				os: 'iOS',
				browser: 'Safari 7',
				version: 7
			},
			{
				userAgent: 'Mozilla/5.0 (Linux; Android 4.0.4; Galaxy Nexus Build/IMM76B) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.133 Mobile Safari/535.19',
				os: 'Android',
				browser: 'Chrome 18',
				version: 18
			}
		];

		testCases.forEach(function (testCase) {
			winMock.navigator.userAgent = testCase.userAgent;
			browserDetectModule = modules['wikia.browserDetect'](winMock);

			expect(browserDetectModule.getOS()).toBe(testCase.os);
			expect(browserDetectModule.getBrowser()).toBe(testCase.browser);
			expect(browserDetectModule.getBrowserVersion()).toBe(testCase.version);
		});
	});
});
