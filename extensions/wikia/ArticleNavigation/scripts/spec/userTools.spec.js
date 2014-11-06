/*global describe, expect, it, modules*/
describe('wikia.userTools', function () {
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
		},
		userTools = modules['wikia.userTools']();

	it('Only not disabled items with href and caption are returned', function () {
		var toolbarData = [
			toolbarCorrectItemMock,
			toolbarDisabledItemMock,
			toolbarNoCaptionItemMock,
			toolbarNoHrefItemMock
		];

		expect(userTools.extractToolbarItems(toolbarData)).toEqual([{
			title: toolbarCorrectItemMock.caption,
			href: toolbarCorrectItemMock.href,
			dataAttr: [{
				'key': 'name',
				value: 'bar'
			}]
		}]);
	});
});
