/*global describe, it, expect, beforeEach, modules, spyOn */
describe('VideoPageTool: Admin CategoryData Collection ( Backbone ):', function () {
	'use strict';
	var CategoryDataCollection,
		instance;

	beforeEach(function () {
		CategoryDataCollection = modules['videopageadmin.collections.categorydata']();
		instance = new CategoryDataCollection();
		spyOn(Backbone.Collection.prototype, 'fetch').andCallFake(function () {
			instance.parse({
				thumbnails: [{
					foo: 'bar'
				}]
			});
		});
		spyOn(instance, 'parse').andCallThrough();
	});

	it('should export a constructor', function () {
		expect(typeof CategoryDataCollection).toBe('function');
	});

	it('should extend Backbone.Collection', function () {
		expect(instance instanceof Backbone.Collection).toBe(true);
	});

	it('should send requests to wikia.php', function () {
		expect(instance.url).toBe('/wikia.php');
	});

	it('should call the right controller, method with the right format', function () {
		expect(instance.controller).toBe('VideoPageAdminSpecial');
		expect(instance.method).toBe('getVideosByCategory');
		expect(instance.format).toBe('json');
	});

	it('should perform fetch ( up to prototype chain ) with the right data', function () {
		var recentCall;
		instance.fetch();
		recentCall = Backbone.Collection.prototype.fetch.mostRecentCall.args[0];
		expect(Backbone.Collection.prototype.fetch).toHaveBeenCalled();
		expect(recentCall.data).toBeDefined();
		expect(recentCall.data.controller).toBe('VideoPageAdminSpecial');
		expect(recentCall.data.method).toBe('getVideosByCategory');
		expect(recentCall.data.format).toBe('json');
		expect(recentCall.data.categoryName).toBe(null);
	});

	it('should call an overrided parse that also manually resets collection', function () {
		// because we manually call Backbone.Collection.prototype.fetch, we must manually trigger
		// parse and proceding reset
		expect(instance.length).toBe(0);
		instance.fetch();
		expect(instance.parse).toHaveBeenCalled();
		expect(instance.length).toBe(1);
	});

	it('setCategory() should set a category using supplied string', function () {
		expect(instance.categoryName).toBe(null);
		instance.setCategory('foo');
		expect(instance.categoryName).toBe('foo');
	});

	it('setCategory() to throw TypeError on non-String arguments', function () {
		var error = new TypeError('name is not a String');
		expect(function () {
			instance.setCategory(0);
		}).toThrow(error);
		expect(function () {
			instance.setCategory(NaN);
		}).toThrow(error);
		expect(function () {
			instance.setCategory(undefined);
		}).toThrow(error);
		expect(function () {
			instance.setCategory({});
		}).toThrow(error);
	});
});
