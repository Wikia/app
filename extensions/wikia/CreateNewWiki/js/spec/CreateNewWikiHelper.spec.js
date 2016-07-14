describe('ext.createNewWiki.helper', function () {
	'use strict';
	it('sanitizeWikiName', function () {
		var testCases = [
			{
				wikiName: 'foo',
				latinise: 'foo',
				expected: 'foo'
			}, {
				wikiName: ' foo ',
				latinise: ' foo ',
				expected: 'foo'
			}, {
				wikiName: 'foo bar',
				latinise: 'foo bar',
				expected: 'foo-bar'
			}, {
				wikiName: ' foo 123 ',
				latinise: ' foo 123 ',
				expected: 'foo-123'
			}, {
				wikiName: 'foo??',
				latinise: 'foo??',
				expected: 'foo'
			}
		];

		testCases.forEach(function (testCase) {
			var stringHelperMock = {
					latinise: function () {
						return testCase.latinise;
					}
				},
				helper = modules['ext.createNewWiki.helper'](stringHelperMock);
			expect(helper.sanitizeWikiName(testCase.wikiName)).toBe(testCase.expected);
		});
	});

	it('getLoginRedirectURL', function () {
		var testCases = [
			{
				wikiName: 'foo',
				wikiDomain: 'foo',
				wikiLanguage: 'pl',
				toStringOutput: '?wikiName=foo&wikiDomain=foo&wikiLanguage=pl',
				expected: '/signin?redirect=%3FwikiName%3Dfoo%26wikiDomain%3Dfoo%26wikiLanguage%3Dpl'
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
