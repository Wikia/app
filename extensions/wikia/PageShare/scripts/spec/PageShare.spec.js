describe('pageShare', function () {
	'use strict';

	function _() {}

	var windowMock = {
			Wikia: {
				Tracker: {
					ACTIONS: {
						CLICK: _
					}
				}
			}
		},
		trackingModuleMock = {
			buildTrackingFunction: _
		},
		testDataSet = [
			{
				mock: {
					window: {}
				},
				expectedResult: null
			},
			{
				mock: {
					window: {
						wgUserName: null,
						wgUserLanguage: 'en'
					}
				},
				expectedResult: null
			},
			{
				mock: {
					window: {
						wgUserName: 'Warkot',
						wgUserLanguage: 'pl',
						wgAcceptLangList: ['pl', 'en-US', 'en-GB', 'en']
					}
				},
				expectedResult: 'pl'
			},
			{
				mock: {
					window: {
						wgUserName: null,
						wgUserLanguage: 'en',
						wgAcceptLangList: ['ja', 'en-US', 'en-GB', 'en']
					}
				},
				expectedResult: 'ja'
			},
			{
				mock: {
					window: {
						wgUserName: null,
						wgUserLanguage: 'en',
						wgAcceptLangList: ['zn-CN', 'en-US', 'en-GB', 'en']
					}
				},
				expectedResult: 'zn'
			},
			{
				mock: {
					window: {
						wgUserName: 'Warkot',
						wgUserLanguage: 'pl'
					}
				},
				expectedResult: 'pl'
			},
			{
				mock: {
					window: {
						wgUserName: 'Warkot',
						wgUserLanguage: 'pl'
					},
					useLang: 'ru'
				},
				expectedResult: 'ru'
			},
			{
				mock: {
					window: {
						wgUserName: null,
						wgUserLanguage: 'en'
					},
					useLang: 'pl'
				},
				expectedResult: 'pl'
			},
			{
				mock: {
					window: {
						wgUserName: null,
						wgUserLanguage: 'en'
					},
					useLang: 'Quenya'
				},
				expectedResult: 'Quenya'
			}
		];

	it('should be defined', function () {
		var pageShareModule = modules['wikia.pageShare'](windowMock, trackingModuleMock, _);

		expect(pageShareModule).toBeDefined();
		expect(typeof pageShareModule.loadShareIcons).toBe('function');
		expect(typeof pageShareModule.getShareLang).toBe('function');
	});

	it('should return the right language code', function () {
		var pageShareModule;

		testDataSet.forEach(function (testData) {
			testData.mock.window.Wikia = windowMock.Wikia;
			pageShareModule = modules['wikia.pageShare'](testData.mock.window, trackingModuleMock, _);
			expect(pageShareModule.getShareLang(testData.mock.useLang)).toBe(testData.expectedResult);
		});
	});
});
