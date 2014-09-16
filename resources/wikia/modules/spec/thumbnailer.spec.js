describe("thumbnailer", function () {
	'use strict';

	var thumbnailer = modules['wikia.thumbnailer'](),
		fullSizeImageUrl = 'http://img2.wikia.nocookie.net/__cb20140419225924/thelastofus/images/f/ff/Joel.png',
		oldThumbnailerUrl = 'http://images2.wikia.nocookie.net/__cb20111213221641/poznan/pl/images/thumb/0/06/Gzik.jpg/300px-Gzik.jpg',
		newThumbnailerUrl = 'http://vignette2.wikia.nocookie.net/arresteddevelopment/f/fb/1x08_My_Mother_the_Car_%2822%29.png/revision/latest/zoom-crop/width/240/height/240?cb=20120214071005',
		articleUrl = 'http://poznan.wikia.com/wiki/Gzik';

	it('identifies thumbnails', function() {
		expect(thumbnailer.isThumbUrl(oldThumbnailerUrl)).toBe(true);
		expect(thumbnailer.isThumbUrl(newThumbnailerUrl)).toBe(true);
		expect(thumbnailer.isThumbUrl(articleUrl)).toBe(false);
	});

	it('returns proper thumbnail URL', function() {
		expect(thumbnailer.getThumbURL(oldThumbnailerUrl, 'nocrop', 660, 330)).toBe('http://images2.wikia.nocookie.net/__cb20111213221641/poznan/pl/images/thumb/0/06/Gzik.jpg/660x330-Gzik.png');
		expect(thumbnailer.getThumbURL(newThumbnailerUrl, 'nocrop', 90, 55)).toBe('http://vignette2.wikia.nocookie.net/arresteddevelopment/f/fb/1x08_My_Mother_the_Car_%2822%29.png/revision/latest/fixed-aspect-ratio/width/90/height/55');
	});

	it('returns proper full image URL', function() {
		expect(thumbnailer.getImageURL(oldThumbnailerUrl)).toBe('http://images2.wikia.nocookie.net/__cb20111213221641/poznan/pl/images/0/06/Gzik.jpg');
		expect(thumbnailer.getImageURL(newThumbnailerUrl)).toBe('http://vignette2.wikia.nocookie.net/arresteddevelopment/f/fb/1x08_My_Mother_the_Car_%2822%29.png/revision/latest');
		expect(thumbnailer.getImageURL(fullSizeImageUrl)).toBe(fullSizeImageUrl);
	});
});