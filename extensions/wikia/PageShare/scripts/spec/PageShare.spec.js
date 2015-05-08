describe('pageShare', function () {
	'use strict';

	function _() {}

	it('should be defined', function () {
		var pageShareModule = modules['wikia.pageShare']({}, _, _);

		expect(pageShareModule).toBeDefined();
		expect(typeof pageShareModule.loadShareIcons).toBe('function');
		expect(typeof pageShareModule.getShareLang).toBe('function');
	});

	it('should return the right language code', function () {
		var pageShareModule,
			testDataSet = [
				{
					mock: {
						window: {
							wgUserName: undefined,
							wgUserLanguage: undefined,
							navigator: {
								languages: undefined,
								browserLanguage: undefined
							}
						},
						useLang: undefined
					},
					expectedResult: null
				},
				{
					mock: {
						window: {
							wgUserName: null,
							wgUserLanguage: 'en',
							navigator: {
								languages: undefined,
								browserLanguage: undefined
							}
						},
						useLang: undefined
					},
					expectedResult: null
				},
				{
					mock: {
						window: {
							wgUserName: 'Warkot',
							wgUserLanguage: 'pl',
							navigator: {
								languages: ['pl', 'en-US', 'en-GB', 'en'],
								browserLanguage: undefined
							}
						},
						useLang: undefined
					},
					expectedResult: 'pl'
				},
				{
					mock: {
						window: {
							wgUserName: null,
							wgUserLanguage: 'en',
							navigator: {
								languages: ['ja', 'en-US', 'en-GB', 'en'],
								browserLanguage: undefined
							}
						},
						useLang: undefined
					},
					expectedResult: 'ja'
				},
				{
					mock: {
						window: {
							wgUserName: null,
							wgUserLanguage: 'en',
							navigator: {
								languages: ['zn-CN', 'en-US', 'en-GB', 'en'],
								browserLanguage: undefined
							}
						},
						useLang: undefined
					},
					expectedResult: 'zn'
				},
				{
					mock: {
						window: {
							wgUserName: 'Warkot',
							wgUserLanguage: 'pl',
							navigator: {
								languages: undefined,
								browserLanguage: 'de'
							}
						},
						useLang: undefined
					},
					expectedResult: 'pl'
				},
				{
					mock: {
						window: {
							wgUserName: null,
							wgUserLanguage: 'en',
							navigator: {
								languages: undefined,
								browserLanguage: 'ru'
							}
						},
						useLang: undefined
					},
					expectedResult: 'ru'
				},
				{
					mock: {
						window: {
							wgUserName: 'Warkot',
							wgUserLanguage: 'pl',
							navigator: {
								languages: undefined,
								browserLanguage: 'de'
							}
						},
						useLang: 'ru'
					},
					expectedResult: 'ru'
				},
				{
					mock: {
						window: {
							wgUserName: null,
							wgUserLanguage: 'en',
							navigator: {
								languages: undefined,
								browserLanguage: 'ru'
							}
						},
						useLang: 'pl'
					},
					expectedResult: 'pl'
				}
			];

		testDataSet.forEach(function (testData) {
			pageShareModule = modules['wikia.pageShare'](testData.mock.window, _, _);
			expect(pageShareModule.getShareLang(testData.mock.useLang)).toBe(testData.expectedResult);
		});
	});
});
