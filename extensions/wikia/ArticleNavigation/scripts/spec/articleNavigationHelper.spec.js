/*global describe, expect, it, modules*/
describe('wikia.articleNavigationHelper', function () {
	'use strict';
	var toolbarCorrectItemMock = {
			type: 'link',
			caption: 'foo',
			'tracker-name': 'bar',
			href: '/foo/bar'
		},
		toolbarDisabledItemMock = {
			type: 'disabled',
			caption: 'bar',
			'tracker-name': 'foo',
			href: 'bar/foo'
		},
		toolbarNoHrefItemMock = {
			type: 'link',
			caption: 'fizz',
			'tracker-name': 'buzz'
		},
		toolbarNoCaptionItemMock = {
			type: 'link',
			'tracker-name': 'buzz',
			href: 'fizz/buzz'
		}, articleNavigationHelper = modules['wikia.articleNavigationHelper']();

	it('Only not disabled items with href and caption are returned', function() {
		var toolbarData = [
			toolbarCorrectItemMock,
			toolbarDisabledItemMock,
			toolbarNoCaptionItemMock,
			toolbarNoHrefItemMock
		];

		expect(articleNavigationHelper.extractToolbarItems(toolbarData)).toEqual([{
			title: toolbarCorrectItemMock.caption,
			href: toolbarCorrectItemMock.href
		}]);
	});
});
