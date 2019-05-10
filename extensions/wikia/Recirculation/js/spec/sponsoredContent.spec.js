describe('sponsoredContent', function () {
	var jQueryMock,
		windowMock,
		logMock = function () {},
		sponsoredContent;

	beforeEach(function () {
		var geoMock = {
			getCountryCode: function () {
				return 'SG';
			},
		};
		jQueryMock = {
			Deferred: function () {
				return $.Deferred();
			},
		};
		windowMock = {};
		sponsoredContent = modules['ext.wikia.recirculation.helpers.sponsoredContent'](jQueryMock, windowMock, geoMock, logMock);
	});

	var contentSelectionTestCases = [
		{
			name: 'should prefer content with matching geo and wiki ID if present',
			items: [
				{
					"id": 125,
					"url": "http://www.fandom.com/articles/brightburn-5-questions",
					"thumbnailUrl": "https://vignette.wikia.nocookie.net/06b47442-1d9b-414b-b009-d47d85d464fe",
					"weight": 1,
					"geos": ["SG"],
					"title": "5 Questions About 'Brightburn' We Want Answered",
					"wikiIds": [],
					"attribution": "Sony Pictures",
					"attributionLabel": "Sponsored by"
				}, {
					"id": 123,
					"url": "https://www.fandom.com/articles/lynx-john-wick",
					"thumbnailUrl": "https://vignette.wikia.nocookie.net/9f6dfa75-5b5a-478e-bfc1-857187b7d8e2",
					"weight": 1,
					"geos": ["AU", "NZ", "SG"],
					"wikiIds": [147],
					"title": "Work It Like John Wick – FANDOM Guide to (Not) Impress",
					"attribution": "Lynx",
					"attributionLabel": "Sponsored by"
				}, {
					"id": 119,
					"url": "https://www.fandom.com/articles/why-glass-is-a-different-superhero-movie",
					"thumbnailUrl": "https://vignette.wikia.nocookie.net/1044d8d1-da78-41b3-9991-8d458054b1e2",
					"weight": 1,
					"geos": ["AU"],
					"wikiIds": [],
					"title": "Why M.Night Shyamalan’s 'Glass' is so Different From All Other Superhero Movies",
					"attribution": "Glass",
					"attributionLabel": "Sponsored by"
				}
			],
			expectedId: 123
		},
		{
			name: 'should prefer content with matching wiki ID if present',
			items: [
				{
					"id": 125,
					"url": "http://www.fandom.com/articles/brightburn-5-questions",
					"thumbnailUrl": "https://vignette.wikia.nocookie.net/06b47442-1d9b-414b-b009-d47d85d464fe",
					"weight": 1,
					"geos": ["SG"],
					"title": "5 Questions About 'Brightburn' We Want Answered",
					"wikiIds": [],
					"attribution": "Sony Pictures",
					"attributionLabel": "Sponsored by"
				}, {
					"id": 123,
					"url": "https://www.fandom.com/articles/lynx-john-wick",
					"thumbnailUrl": "https://vignette.wikia.nocookie.net/9f6dfa75-5b5a-478e-bfc1-857187b7d8e2",
					"weight": 1,
					"geos": ["AU", "NZ", "SG"],
					"wikiIds": [],
					"title": "Work It Like John Wick – FANDOM Guide to (Not) Impress",
					"attribution": "Lynx",
					"attributionLabel": "Sponsored by"
				}, {
					"id": 119,
					"url": "https://www.fandom.com/articles/why-glass-is-a-different-superhero-movie",
					"thumbnailUrl": "https://vignette.wikia.nocookie.net/1044d8d1-da78-41b3-9991-8d458054b1e2",
					"weight": 1,
					"geos": ["AU"],
					"wikiIds": [147],
					"title": "Why M.Night Shyamalan’s 'Glass' is so Different From All Other Superhero Movies",
					"attribution": "Glass",
					"attributionLabel": "Sponsored by"
				}
			],
			expectedId: 119
		},
		{
			name: 'should return content with matching geo if no wiki specific items exist',
			items: [
				{
					"id": 125,
					"url": "http://www.fandom.com/articles/brightburn-5-questions",
					"thumbnailUrl": "https://vignette.wikia.nocookie.net/06b47442-1d9b-414b-b009-d47d85d464fe",
					"weight": 1,
					"geos": ["SG"],
					"title": "5 Questions About 'Brightburn' We Want Answered",
					"wikiIds": [],
					"attribution": "Sony Pictures",
					"attributionLabel": "Sponsored by"
				}, {
					"id": 123,
					"url": "https://www.fandom.com/articles/lynx-john-wick",
					"thumbnailUrl": "https://vignette.wikia.nocookie.net/9f6dfa75-5b5a-478e-bfc1-857187b7d8e2",
					"weight": 1,
					"geos": ["AU", "NZ", "SG"],
					"wikiIds": [],
					"title": "Work It Like John Wick – FANDOM Guide to (Not) Impress",
					"attribution": "Lynx",
					"attributionLabel": "Sponsored by"
				}, {
					"id": 119,
					"url": "https://www.fandom.com/articles/why-glass-is-a-different-superhero-movie",
					"thumbnailUrl": "https://vignette.wikia.nocookie.net/1044d8d1-da78-41b3-9991-8d458054b1e2",
					"weight": 1,
					"geos": ["AU"],
					"wikiIds": [],
					"title": "Why M.Night Shyamalan’s 'Glass' is so Different From All Other Superhero Movies",
					"attribution": "Glass",
					"attributionLabel": "Sponsored by"
				}
			],
			expectedId: 125
		},
	];

	contentSelectionTestCases.forEach(function(testCase) {
		it(testCase.name, function (done) {
			windowMock.wgCityId = 147;
			jQueryMock.ajax = function () {
				return $.Deferred().resolve(testCase.items);
			};

			sponsoredContent.fetch().done(function (content) {
				var item = sponsoredContent.getSponsoredItem(content);

				expect(item.id).toBe(testCase.expectedId);
				done();
			});
		});
	});

	it('should return no content when no items exist with matching geo or wiki ID', function (done) {
		windowMock.wgCityId = 147;
		jQueryMock.ajax = function () {
			return $.Deferred().resolve([
				{
					"id": 125,
					"url": "http://www.fandom.com/articles/brightburn-5-questions",
					"thumbnailUrl": "https://vignette.wikia.nocookie.net/06b47442-1d9b-414b-b009-d47d85d464fe",
					"weight": 1,
					"geos": ["US"],
					"title": "5 Questions About 'Brightburn' We Want Answered",
					"wikiIds": [],
					"attribution": "Sony Pictures",
					"attributionLabel": "Sponsored by"
				}, {
					"id": 123,
					"url": "https://www.fandom.com/articles/lynx-john-wick",
					"thumbnailUrl": "https://vignette.wikia.nocookie.net/9f6dfa75-5b5a-478e-bfc1-857187b7d8e2",
					"weight": 1,
					"geos": ["AU", "NZ"],
					"wikiIds": [],
					"title": "Work It Like John Wick – FANDOM Guide to (Not) Impress",
					"attribution": "Lynx",
					"attributionLabel": "Sponsored by"
				}, {
					"id": 119,
					"url": "https://www.fandom.com/articles/why-glass-is-a-different-superhero-movie",
					"thumbnailUrl": "https://vignette.wikia.nocookie.net/1044d8d1-da78-41b3-9991-8d458054b1e2",
					"weight": 1,
					"geos": ["DE"],
					"wikiIds": [],
					"title": "Why M.Night Shyamalan’s 'Glass' is so Different From All Other Superhero Movies",
					"attribution": "Glass",
					"attributionLabel": "Sponsored by"
				}
			]);
		};

		sponsoredContent.fetch().done(function (content) {
			var item = sponsoredContent.getSponsoredItem(content);

			expect(item).toBeUndefined();
			done();
		});
	});
});
