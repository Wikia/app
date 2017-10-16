/*global describe,modules,it,expect,spyOn,jasmine*/
/*jshint maxlen:200*/
/*jslint unparam:true*/

describe('ext.wikia.articleVideo.ooyalaPlayer', function () {
	'use strict';

	it('should display length of the video in correct format', function () {
		var OoyalaHTML5Player = modules['ooyala-player'](),
			testCases = [
				{
					value: 615,
					expected: '10:15'
				}, {
					value: 0,
					expected: '0:00'
				}, {
					value: 1,
					expected: '0:01'
				}, {
					value: 60,
					expected: '1:00'
				}, {
					value: 125.401,
					expected: '2:05'
				}, {
					value: 5940,
					expected: '1:39:00'
				}, {
					value: 54000,
					expected: '15:00:00'
				}, {
					value: 720000,
					expected: '200:00:00'
				}
			];
		testCases.forEach(function (item) {
			expect(OoyalaHTML5Player.prototype.getFormattedDuration(item.value)).toBe(item.expected);
		});

	});
});
