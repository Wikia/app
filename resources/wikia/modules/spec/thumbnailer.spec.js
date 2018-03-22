describe('thumbnailer', function () {
	'use strict';

	var thumbnailer = modules['wikia.thumbnailer'](),
		fullSizeImageUrl = 'http://img2.wikia.nocookie.net/__cb20140419225924/thelastofus/images/f/ff/Joel.png',
		legacyThumbnailerUrl = 'http://images2.wikia.nocookie.net/__cb20111213221641/poznan/pl/images/thumb/0/06/Gzik.jpg/300px-Gzik.jpg',
		thumbnailerUrl = 'http://vignette.wikia.nocookie.net/arresteddevelopment/f/fb/1x08_My_Mother_the_Car_%2822%29.png/revision/latest/zoom-crop/width/240/height/240?cb=20120214071005',
		articleUrl = 'http://poznan.wikia.com/wiki/Gzik';

	it('identifies thumbnails', function () {
		expect(thumbnailer.isThumbUrl(legacyThumbnailerUrl)).toBe(true);
		expect(thumbnailer.isThumbUrl(thumbnailerUrl)).toBe(true);
		expect(thumbnailer.isThumbUrl(thumbnailerUrl.replace('vignette', 'vignette-poz'))).toBe(true); // Poznań devbox
		expect(thumbnailer.isThumbUrl(fullSizeImageUrl)).toBe(false);
		expect(thumbnailer.isThumbUrl(articleUrl)).toBe(false);
	});

	it('detects old and new URL format', function() {
		expect(thumbnailer.isLegacyThumbnailerUrl(legacyThumbnailerUrl)).toBe(true);
		expect(thumbnailer.isLegacyThumbnailerUrl(thumbnailerUrl)).toBe(false);
	});

	it('returns proper nocrop thumbnail URL', function () {
		expect(thumbnailer.getThumbURL(legacyThumbnailerUrl, 'nocrop', 660, 330)).toBe('http://images2.wikia.nocookie.net/__cb20111213221641/poznan/pl/images/thumb/0/06/Gzik.jpg/660x330-Gzik.png');
		expect(thumbnailer.getThumbURL(thumbnailerUrl, 'nocrop', 90, 55)).toBe('http://vignette.wikia.nocookie.net/arresteddevelopment/f/fb/1x08_My_Mother_the_Car_%2822%29.png/revision/latest/fixed-aspect-ratio/width/90/height/55?cb=20120214071005');
		expect(thumbnailer.getThumbURL(fullSizeImageUrl, 'nocrop', 90, 55)).toBe('http://img2.wikia.nocookie.net/__cb20140419225924/thelastofus/images/thumb/f/ff/Joel.png/90x55-Joel.png');
	});

	it('returns proper video thumbnail URL', function () {
		expect(thumbnailer.getThumbURL(legacyThumbnailerUrl, 'video', 660, 330)).toBe('http://images2.wikia.nocookie.net/__cb20111213221641/poznan/pl/images/thumb/0/06/Gzik.jpg/660x330-Gzik.png');
		expect(thumbnailer.getThumbURL(thumbnailerUrl, 'video', 90, 55)).toBe('http://vignette.wikia.nocookie.net/arresteddevelopment/f/fb/1x08_My_Mother_the_Car_%2822%29.png/revision/latest/fixed-aspect-ratio/width/90/height/55?cb=20120214071005');
		expect(thumbnailer.getThumbURL(fullSizeImageUrl, 'video', 90, 55)).toBe('http://img2.wikia.nocookie.net/__cb20140419225924/thelastofus/images/thumb/f/ff/Joel.png/90x55-Joel.png');
	});

	it('returns proper image thumbnail URL', function () {
		expect(thumbnailer.getThumbURL(legacyThumbnailerUrl, 'image', 660, 330)).toBe('http://images2.wikia.nocookie.net/__cb20111213221641/poznan/pl/images/thumb/0/06/Gzik.jpg/660x330x2-Gzik.png');
		expect(thumbnailer.getThumbURL(thumbnailerUrl, 'image', 90, 55)).toBe('http://vignette.wikia.nocookie.net/arresteddevelopment/f/fb/1x08_My_Mother_the_Car_%2822%29.png/revision/latest/zoom-crop/width/90/height/55?cb=20120214071005');
		expect(thumbnailer.getThumbURL(fullSizeImageUrl, 'image', 90, 55)).toBe('http://img2.wikia.nocookie.net/__cb20140419225924/thelastofus/images/thumb/f/ff/Joel.png/90x55x2-Joel.png');
	});

	it('returns proper full image URL', function () {
		expect(thumbnailer.getImageURL(legacyThumbnailerUrl)).toBe('http://images2.wikia.nocookie.net/__cb20111213221641/poznan/pl/images/0/06/Gzik.jpg');
		expect(thumbnailer.getImageURL(thumbnailerUrl)).toBe('http://vignette.wikia.nocookie.net/arresteddevelopment/f/fb/1x08_My_Mother_the_Car_%2822%29.png/revision/latest?cb=20120214071005');
		expect(thumbnailer.getImageURL(fullSizeImageUrl)).toBe(fullSizeImageUrl);
	});

	it('test 0 height image for legacy thumbnail', function () {
		expect(thumbnailer.getThumbURL(legacyThumbnailerUrl, 'image', 500, 0)).toBe('http://images2.wikia.nocookie.net/__cb20111213221641/poznan/pl/images/thumb/0/06/Gzik.jpg/500px-x2-Gzik.png');
	});

	it('test 0 height image for vignette thumbnail', function () {
		expect(thumbnailer.getThumbURL(thumbnailerUrl, 'image', 500, 0)).toBe('http://vignette.wikia.nocookie.net/arresteddevelopment/f/fb/1x08_My_Mother_the_Car_%2822%29.png/revision/latest/zoom-crop/width/500/height/0?cb=20120214071005');
	});
});
