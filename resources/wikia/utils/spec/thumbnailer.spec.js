describe("thumbnailer", function () {
	'use strict';

	var thumbnailer = modules['wikia.thumbnailer'](),
		imgSrc = 'http://images2.wikia.nocookie.net/__cb20111213221641/poznan/pl/images/thumb/0/06/Gzik.jpg/300px-Gzik.jpg',
		articleUrl = 'http://poznan.wikia.com/wiki/Gzik';

	it('identifies thumbnails', function() {
		expect(thumbnailer.isThumbUrl(imgSrc)).toBe(true);
		expect(thumbnailer.isThumbUrl(articleUrl)).toBe(false);
	});

	it('returns proper thumbnail URL', function() {
		expect(thumbnailer.getThumbURL(imgSrc, 'nocrop', 660, 330)).toBe('http://images2.wikia.nocookie.net/__cb20111213221641/poznan/pl/images/thumb/0/06/Gzik.jpg/660x330-Gzik.png');
	});

	it('returns proper full image URL', function() {
		expect(thumbnailer.getImageURL(imgSrc)).toBe('http://images2.wikia.nocookie.net/__cb20111213221641/poznan/pl/images/0/06/Gzik.jpg');
	});
});