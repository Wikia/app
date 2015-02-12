describe('Image Serving', function () {
	'use strict';

	var imageServing = modules['wikia.imageServing']();

	it('registers AMD module', function () {
		expect(imageServing).toBeDefined();
		expect(typeof imageServing).toBe('object');
	});

	it('gives nice and clean API', function () {
		expect(typeof imageServing.getCutParams).toBe('function', 'getCutParams');
	});

	it('return correct response object', function () {
		var cutOptions = imageServing.getCutParams(1, 1, 1, 1);
		expect(typeof cutOptions).toBe('object');
		expect(typeof cutOptions.xOffset1).toBe('number');
		expect(typeof cutOptions.yOffset1).toBe('number');
		expect(typeof cutOptions.xOffset2).toBe('number');
		expect(typeof cutOptions.yOffset2).toBe('number');
	});

	it('correctly cuts image', function () {
		var cases = [{
			originalWidth: 160,
			originalHeight: 90,
			expectedWidth: 160,
			expectedHeight: 90,
			xOffset1: 0,
			yOffset1: 0,
			xOffset2: 160,
			yOffset2: 90
		}, {
			originalWidth: 320,
			originalHeight: 180,
			expectedWidth: 160,
			expectedHeight: 90,
			xOffset1: 0,
			yOffset1: 0,
			xOffset2: 320,
			yOffset2: 180
		}, {
			originalWidth: 100,
			originalHeight: 100,
			expectedWidth: 200,
			expectedHeight: 100,
			xOffset1: 0,
			yOffset1: 10,
			xOffset2: 100,
			yOffset2: 60
		}, {
			originalWidth: 100,
			originalHeight: 100,
			expectedWidth: 400,
			expectedHeight: 100,
			xOffset1: 0,
			yOffset1: 30,
			xOffset2: 100,
			yOffset2: 55
		}, {
			originalWidth: 100,
			originalHeight: 100,
			expectedWidth: 100,
			expectedHeight: 200,
			xOffset1: 25,
			yOffset1: 0,
			xOffset2: 75,
			yOffset2: 100
		}];

		cases.forEach(function (image) {
			var message = 'for ' + JSON.stringify(image),
				cutOptions = imageServing.getCutParams(
					image.originalWidth,
					image.originalHeight,
					image.expectedWidth,
					image.expectedHeight
				);

			expect(cutOptions.xOffset1).toBe(image.xOffset1, message);
			expect(cutOptions.yOffset1).toBe(image.yOffset1, message);
			expect(cutOptions.xOffset2).toBe(image.xOffset2, message);
			expect(cutOptions.yOffset2).toBe(image.yOffset2, message);
		});
	});
});
