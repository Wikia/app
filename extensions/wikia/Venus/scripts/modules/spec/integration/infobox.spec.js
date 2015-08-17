describe( 'infobox', function(){
	'use strict';

	var infobox,
		windowMock = window,
		mwMock = {
			msg: function() {
				return 'see more';
			}
		},
		styles, css,
		infoboxMock = document.createElement('div'),
		idMock = 'seeMoreButtonMock';

	windowMock.mw = mwMock;

	css = '\
		#infoboxMock { \
			font-size: 12px; \
			text-align: left; \
			background-color: #f0f0f0; \
			margin-top: 20px; \
		} \
		';

	infoboxMock.id = 'infoboxMock';

	styles = document.createElement('style');
	styles.type = 'text/css';
	styles.appendChild(document.createTextNode(css));

	document.head.appendChild(styles);
	document.body.appendChild(infoboxMock);

	infobox = modules['venus.infobox'](document, windowMock);

	it('button shoould be created', function(){
		var button = infobox.createSeeMoreButton(infoboxMock, idMock);

		expect(button.tagName).toBe('A');
		expect(button.id).toBe(idMock);
		expect(button.classList.contains('see-more')).toBe(true);
		expect(button.innerHTML).toBe('see more');

		// #f0f0f0 == rgb(240,240,240)
		expect(button.style.backgroundColor).toBe('rgb(240, 240, 240)');
	});

	it('getColorAlpha should return alpha channel values', function() {
		var cases = {
			'rgba(255, 255, 255, 0.2)': 0.2,
			'rgba(255,255,255,0.2)': 0.2,
			'rgba(255,255,255,0.5)': 0.5,
			'rgba(255,255,255,0.75)': 0.75,
			'rgba(255,255,255,1.0)': null,
			'rgb(255,255,255)': null
		};

		Object.keys(cases).forEach(function(val) {
			var expected = cases[val];

			expect(infobox.getColorAlpha(val)).toBe(expected);
		})
	});

});
