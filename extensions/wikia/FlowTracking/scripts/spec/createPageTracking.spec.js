describe('createPageTracking', function () {
	'use strict';

	function _() {}

	var mocks = {
			window: {
				location: 'http://www.muppet.wikia.com',
				history: {
					replaceState: function () {
					}
				},
				wgFlowTrackingFlows: {
					CREATE_PAGE_DIRECT_URL: 'create-page-direct-url',
					CREATE_PAGE_SPECIAL_CREATE_PAGE: 'create-page-special-create-page'
				}
			},
			document: {
				referer: ''
			},
			mw: {
				config: {
					get: function (value) {
						if (value === 'wgNamespaceNumber') {
							return 0;
						} else if (value === 'wgArticleId') {
							return 0;
						} else if (value === 'wgTitle') {
							return 'Test';
						}
					}
				}
			},
			flowTracking: {
				trackFlowStep: function () { return null; },
				beginFlow: function () { return null; }
			}
		},
		QuerystringModule = modules['wikia.querystring']();

	it('should be defined', function () {
		var createPageTrackingModule = modules['ext.wikia.flowTracking.createPageTracking'](
			mocks.flowTracking, QuerystringModule, mocks.mw, mocks.document, mocks.window
		);

		createPageTrackingModule.trackOnEditPageLoad('editor');

		expect(createPageTrackingModule).toBeDefined();
	});
});
