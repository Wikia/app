describe('VideosModule -- sData Data: ', function () {
	'use strict';
	var VideosData,
		nirvana,
		instance;

	beforeEach(function () {
		nirvana = modules['wikia.nirvana']();
		VideosData = modules['videosmodule.models.videos'](nirvana);
		instance = new VideosData();
		spyOn(nirvana, 'getJson').andReturn({
			done: function (cb) {
				cb('foo');
			}
		});
	});

	it('should export a function', function () {
		expect(typeof VideosData).toBe('function');
	});

	it('should have a fetch method', function () {
		expect(typeof instance.fetch).toBe('function');
	});

	it('when fetch is called, it should make a call to nirvana', function () {
		expect(instance.data).toBe(null);
		instance.fetch();
		expect(nirvana.getJson).toHaveBeenCalled();
		expect(nirvana.getJson).toHaveBeenCalledWith('VideosModuleController', 'index', {
			articleId: null,
			verticalOnly: null
		});
		expect(instance.data).toBe('foo');
	});

});
