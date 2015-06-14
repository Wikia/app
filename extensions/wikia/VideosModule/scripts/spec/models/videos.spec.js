describe('VideosModule -- sData Data: ', function () {
	'use strict';
	var VideosData,
		nirvana,
		geo,
		bucky,
		instance;

	beforeEach(function () {
		nirvana = modules['wikia.nirvana']();
		geo = modules['wikia.geo']();
		bucky = modules['bucky.mock'];
		VideosData = modules['videosmodule.models.videos'](nirvana, geo, bucky);
		instance = new VideosData();
		spyOn(geo, 'getCountryCode').and.returnValue('US');
		spyOn(nirvana, 'getJson').and.returnValue({
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
