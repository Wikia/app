describe('ext.wikia.design-system.on-site-notifications.tracking', function () {
	'use strict';


	it('getLoginRedirectURL', function () {
		var testCases = [
			{
				wikiName: 'foo',
				wikiDomain: 'foo',
				wikiLanguage: 'pl',
				toStringOutput: '?wikiName=foo&wikiDomain=foo&wikiLanguage=pl',
				expected: '/register?redirect=%3FwikiName%3Dfoo%26wikiDomain%3Dfoo%26wikiLanguage%3Dpl'
			}
		];

		testCases.forEach(function (testCase) {
			var queryStringMock = {
					setVal: function () {
					},
					toString: function () {
						return testCase.toStringOutput;
					}
				},
				QueryString = function () {
					return queryStringMock;
				},
				helper = modules['ext.createNewWiki.helper']({}, QueryString);

			expect(helper.getLoginRedirectURL(testCase.wikiName, testCase.wikiDomain, testCase.wikiLanguage))
				.toBe(testCase.expected);
		});
	});
});
