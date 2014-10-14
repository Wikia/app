/*global describe, it, expect, beforeEach, modules */
describe('VideoPageAdmin FeaturedSlidesCollection ( Backbone ):', function () {
	'use strict';
	var FeaturedSlidesCollection,
		instance;

	beforeEach(function () {
		FeaturedSlidesCollection = modules['videohomepage.collections.featuredslides']();
		instance = new FeaturedSlidesCollection([{
			embedData: 'foo'
		}]);
	});

	it('should export a constructor', function () {
		expect(typeof FeaturedSlidesCollection).toBe('function');
	});

	it('should be instantiated into an object', function () {
		expect(typeof instance).toBe('object');
	});

	it('should be an instance of Backbone.Collection', function () {
		expect(instance instanceof Backbone.Collection).toBe(true);
	});

	it('should be able to be instantiated with provided models', function () {
		expect(instance.length).toBe(1);
	});

	it('should properly reset the collection', function () {
		expect(instance.at(0).get('embedData')).toBe('foo');
		// reset the slides
		instance.resetEmbedData();
		expect(instance.at(0).get('embedData')).toBe(null);
	});
});
