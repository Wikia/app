describe('VideosModule -- sData Data: ', function () {
	'use strict';
	var VideosData,
		nirvana,
		geo,
		instance;

	beforeEach(function () {
		nirvana = modules['wikia.nirvana']();
		geo = modules['wikia.geo']();
		VideosData = modules['videosmodule.models.videos'](nirvana, geo);
		instance = new VideosData();
		spyOn(geo, 'getCountryCode').andReturn('US');
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

	it('geo should have getCountryCode function', function () {
		expect(typeof geo.getCountryCode).toBe('function');
	});

	it('when fetch is called, it should make a call to nirvana', function () {
		expect(instance.data).toBeNull();
		instance.fetch();
		expect(geo.getCountryCode).toHaveBeenCalled();

		expect(nirvana.getJson).toHaveBeenCalledWith('VideosModuleController', 'index', {
			userRegion: 'US'
		});
		expect(instance.data).toBe('foo');
	});

});
