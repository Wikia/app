/*global describe, it, expect, modules*/
describe('ext.wikia.adEngine.ml.bucketizers', function () {
	'use strict';

	function getModule() {
		return modules['ext.wikia.adEngine.ml.bucketizers']();
	}

	it('should bucketize viewport', function () {
		var bucketizers = getModule();

		expect(bucketizers.bucketizeViewportHeight(0)).toEqual(400);
		expect(bucketizers.bucketizeViewportHeight(200)).toEqual(400);
		expect(bucketizers.bucketizeViewportHeight(399)).toEqual(400);

		expect(bucketizers.bucketizeViewportHeight(400)).toEqual(500);
		expect(bucketizers.bucketizeViewportHeight(420)).toEqual(500);
		expect(bucketizers.bucketizeViewportHeight(499)).toEqual(500);

		expect(bucketizers.bucketizeViewportHeight(500)).toEqual(600);
		expect(bucketizers.bucketizeViewportHeight(520)).toEqual(600);
		expect(bucketizers.bucketizeViewportHeight(599)).toEqual(600);

		expect(bucketizers.bucketizeViewportHeight(600)).toEqual(700);
		expect(bucketizers.bucketizeViewportHeight(620)).toEqual(700);
		expect(bucketizers.bucketizeViewportHeight(699)).toEqual(700);

		expect(bucketizers.bucketizeViewportHeight(700)).toEqual(800);
		expect(bucketizers.bucketizeViewportHeight(720)).toEqual(800);
		expect(bucketizers.bucketizeViewportHeight(799)).toEqual(800);

		expect(bucketizers.bucketizeViewportHeight(800)).toEqual(900);
		expect(bucketizers.bucketizeViewportHeight(820)).toEqual(900);
		expect(bucketizers.bucketizeViewportHeight(899)).toEqual(900);

		expect(bucketizers.bucketizeViewportHeight(900)).toEqual(1000);
		expect(bucketizers.bucketizeViewportHeight(920)).toEqual(1000);
		expect(bucketizers.bucketizeViewportHeight(999)).toEqual(1000);

		expect(bucketizers.bucketizeViewportHeight(1000)).toEqual(1100);
		expect(bucketizers.bucketizeViewportHeight(3000)).toEqual(1100);
	});
});
