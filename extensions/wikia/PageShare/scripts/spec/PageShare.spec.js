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
		logModuleMock = (function () {
			var log = _;

			log.levels = {
				debug: ''
			};

			return log;
		})(),
		testDataSet = [
			{
				mock: {
					window: {
						navigator: {}
					}
				},
				expectedResult: null
			},
			{
				mock: {
					window: {
						wgUserName: null,
						wgUserLanguage: 'en',
						navigator: {}
					}
				},
				expectedResult: null
			},
			{
				mock: {
					window: {
						wgUserName: 'Warkot',
						wgUserLanguage: 'pl',
						navigator: {
							languages: ['pl', 'en-US', 'en-GB', 'en']
						}
					}
				},
				expectedResult: 'pl'
			},
			{
				mock: {
					window: {
						wgUserName: null,
						wgUserLanguage: 'en',
						navigator: {
							languages: ['ja', 'en-US', 'en-GB', 'en']
						}
					}
				},
				expectedResult: 'ja'
			},
			{
				mock: {
					window: {
						wgUserName: null,
						wgUserLanguage: 'en',
						navigator: {
							languages: ['zn-CN', 'en-US', 'en-GB', 'en']
						}
					}
				},
				expectedResult: 'zn'
			},
			{
				mock: {
					window: {
						wgUserName: null,
						wgUserLanguage: 'en',
						navigator: {
							language: 'pl'
						}
					}
				},
				expectedResult: 'pl'
			},
			{
				mock: {
					window: {
						wgUserName: null,
						wgUserLanguage: 'de',
						navigator: {
							language: 'en-US'
						}
					}
				},
				expectedResult: 'en'
			},
			{
				mock: {
					window: {
						wgUserName: 'Warkot',
						wgUserLanguage: 'pl',
						navigator: {
							userLanguage: 'de'
						}
					}
				},
				expectedResult: 'pl'
			},
			{
				mock: {
					window: {
						wgUserName: null,
						wgUserLanguage: 'en',
						navigator: {
							userLanguage: 'ru'
						}
					}
				},
				expectedResult: 'ru'
			},
			{
				mock: {
					window: {
						wgUserName: 'Warkot',
						wgUserLanguage: 'pl',
						navigator: {
							userLanguage: 'de'
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
							userLanguage: 'ru'
						}
					},
					useLang: 'pl'
				},
				expectedResult: 'pl'
			},
			{
				mock: {
					window: {
						wgUserName: null,
						wgUserLanguage: 'en',
						navigator: {
							userLanguage: 'en-GB'
						}
					},
					useLang: 'Quenya'
				},
				expectedResult: 'Quenya'
			}
		];

	it('should be defined', function () {
		var pageShareModule = modules['wikia.pageShare'](windowMock, trackingModuleMock, logModuleMock, _);

		expect(pageShareModule).toBeDefined();
		expect(typeof pageShareModule.loadShareIcons).toBe('function');
		expect(typeof pageShareModule.getShareLang).toBe('function');
	});

	it('should return the right language code', function () {
		var pageShareModule;

		testDataSet.forEach(function (testData) {
			testData.mock.window.Wikia = windowMock.Wikia;
			pageShareModule = modules['wikia.pageShare'](testData.mock.window, trackingModuleMock, logModuleMock, _);
			expect(pageShareModule.getShareLang(testData.mock.useLang)).toBe(testData.expectedResult);
		});
	});
});
