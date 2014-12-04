describe('Image Serving', function () {
	'use strict';

	var imageServing = modules['wikia.imageServing']();

	it('registers AMD module', function() {
		expect(imageServing).toBeDefined();
		expect(typeof imageServing).toBe('object');
	});

	it('gives nice and clean API', function() {
		expect(typeof imageServing.getCutParams).toBe('function', 'getCutParams');
	});

	it('return correct response object', function() {
		var cutOptions = imageServing.getCutParams(1, 1, 1, 1);
		expect(typeof cutOptions).toBe('object');
		expect(typeof cutOptions.offsetX).toBe('number');
		expect(typeof cutOptions.offsetY).toBe('number');
		expect(typeof cutOptions.windowWidth).toBe('number');
		expect(typeof cutOptions.windowHeight).toBe('number');
	});

	using('image sizes', [
		{
			originalWidth: 160,
			originalHeight: 90,
			expectedWidth: 160,
			expectedHeight: 90,
			offsetX: 0,
			offsetY: 0,
			windowWidth: 160,
			windowHeight: 90
		},
		{
			originalWidth: 320,
			originalHeight: 180,
			expectedWidth: 160,
			expectedHeight: 90,
			offsetX: 0,
			offsetY: 0,
			windowWidth: 320,
			windowHeight: 180
		},
		{
			originalWidth: 100,
			originalHeight: 100,
			expectedWidth: 200,
			expectedHeight: 100,
			offsetX: 0,
			offsetY: 10,
			windowWidth: 100,
			windowHeight: 50
		},
		{
			originalWidth: 100,
			originalHeight: 100,
			expectedWidth: 400,
			expectedHeight: 100,
			offsetX: 0,
			offsetY: 30,
			windowWidth: 100,
			windowHeight: 25
		},
		{
			originalWidth: 100,
			originalHeight: 100,
			expectedWidth: 100,
			expectedHeight: 200,
			offsetX: 25,
			offsetY: 0,
			windowWidth: 50,
			windowHeight: 100
		},
	], function(image) {
		it('correctly cuts image', function() {
			var cutOptions = imageServing.getCutParams(
				image.originalWidth,
				image.originalHeight,
				image.expectedWidth,
				image.expectedHeight);
			expect(cutOptions.offsetX).toBe(image.offsetX);
			expect(cutOptions.offsetY).toBe(image.offsetY);
			expect(cutOptions.windowWidth).toBe(image.windowWidth);
			expect(cutOptions.windowHeight).toBe(image.windowHeight);
		});
	});
});
