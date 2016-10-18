describe('createPageTracking', function () {
	'use strict';

	var wgNamespaceNumber = 0,
		wgArticleId = 0,
		wgTitle = 'Test',
		mocks = {
			window: {
				location: 'http://www.muppet.wikia.com/wiki/Elmo?action=edit',
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
							return wgNamespaceNumber;
						} else if (value === 'wgArticleId') {
							return wgArticleId;
						} else if (value === 'wgTitle') {
							return wgTitle;
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

	beforeEach(function () {
		wgArticleId = 0;
		wgNamespaceNumber = 0;
		mocks.window.location = 'http://www.muppet.wikia.com/wiki/Elmo?action=edit';

		spyOn(mocks.flowTracking, 'beginFlow');
		spyOn(mocks.flowTracking, 'trackFlowStep');
	});

	it('should track direct url flow', function () {
		wgArticleId = 0;
		wgNamespaceNumber = 0;

		var createPageTrackingModule = modules['ext.wikia.flowTracking.createPageTracking'](
			mocks.flowTracking, QuerystringModule, mocks.mw, mocks.document, mocks.window
		);

		createPageTrackingModule.trackOnEditPageLoad('editor');

		expect(mocks.flowTracking.beginFlow).toHaveBeenCalledWith('create-page-direct-url', {editor: 'editor'});
		expect(mocks.flowTracking.trackFlowStep).not.toHaveBeenCalled();
	});

	it('should track contribute button flow', function () {
		wgArticleId = 0;
		wgNamespaceNumber = 0;
		mocks.window.location = 'http://www.muppet.wikia.com/wiki/Elmo?action=edit&flow=create-page-contribute-button';

		var createPageTrackingModule = modules['ext.wikia.flowTracking.createPageTracking'](
			mocks.flowTracking, QuerystringModule, mocks.mw, mocks.document, mocks.window
		);

		createPageTrackingModule.trackOnEditPageLoad('visualeditor');

		expect(mocks.flowTracking.beginFlow).not.toHaveBeenCalledWith();
		expect(mocks.flowTracking.trackFlowStep).toHaveBeenCalledWith(
			'create-page-contribute-button', {editor: 'visualeditor'}
		);
	});

	it('should not track flow if article exists', function () {
		wgArticleId = 2;
		wgNamespaceNumber = 0;

		var createPageTrackingModule = modules['ext.wikia.flowTracking.createPageTracking'](
			mocks.flowTracking, QuerystringModule, mocks.mw, mocks.document, mocks.window
		);

		createPageTrackingModule.trackOnEditPageLoad('editor');

		expect(mocks.flowTracking.beginFlow).not.toHaveBeenCalled();
		expect(mocks.flowTracking.trackFlowStep).not.toHaveBeenCalled();
	});

	it('should not track flow if namespace is different than main or special', function () {
		wgArticleId = 0;
		wgNamespaceNumber = 4;

		var createPageTrackingModule = modules['ext.wikia.flowTracking.createPageTracking'](
			mocks.flowTracking, QuerystringModule, mocks.mw, mocks.document, mocks.window
		);

		createPageTrackingModule.trackOnEditPageLoad('editor');

		expect(mocks.flowTracking.beginFlow).not.toHaveBeenCalled();
		expect(mocks.flowTracking.trackFlowStep).not.toHaveBeenCalled();
	});

	it('should not track flow if namespace is special but page is different than CreatePage', function () {
		wgArticleId = 0;
		wgNamespaceNumber = -1;
		wgTitle = 'Insights';

		var createPageTrackingModule = modules['ext.wikia.flowTracking.createPageTracking'](
			mocks.flowTracking, QuerystringModule, mocks.mw, mocks.document, mocks.window
		);

		createPageTrackingModule.trackOnEditPageLoad('editor');

		expect(mocks.flowTracking.beginFlow).not.toHaveBeenCalled();
		expect(mocks.flowTracking.trackFlowStep).not.toHaveBeenCalled();
	});
});
