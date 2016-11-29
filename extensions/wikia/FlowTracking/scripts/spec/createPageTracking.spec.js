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
				},
				wgNamespaceIds: {
					'': 0,
					'special': -1,
					'template': 10,
					'category': 14
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

	/**
	 * Article tests
	 */

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

		expect(mocks.flowTracking.beginFlow).not.toHaveBeenCalled();
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

	it('should not track flow if already tracked', function () {
		wgArticleId = 0;
		wgNamespaceNumber = 0;
		mocks.window.location = 'http://www.muppet.wikia.com/wiki/Elmo?action=edit' +
			'&flow=create-page-contribute-button&tracked';

		var createPageTrackingModule = modules['ext.wikia.flowTracking.createPageTracking'](
			mocks.flowTracking, QuerystringModule, mocks.mw, mocks.document, mocks.window
		);

		createPageTrackingModule.trackOnEditPageLoad('editor');

		expect(mocks.flowTracking.beginFlow).not.toHaveBeenCalled();
		expect(mocks.flowTracking.trackFlowStep).not.toHaveBeenCalled();
	});

	it('should not track flow if namespace is special', function () {
		wgArticleId = 0;
		wgNamespaceNumber = -1;

		var createPageTrackingModule = modules['ext.wikia.flowTracking.createPageTracking'](
			mocks.flowTracking, QuerystringModule, mocks.mw, mocks.document, mocks.window
		);

		createPageTrackingModule.trackOnEditPageLoad('editor');

		expect(mocks.flowTracking.beginFlow).not.toHaveBeenCalled();
		expect(mocks.flowTracking.trackFlowStep).not.toHaveBeenCalled();
	});

	/**
	 * Special:CreatePage tests
	 */

	it('should track special create flow', function () {
		wgArticleId = 0;
		wgNamespaceNumber = -1;
		wgTitle = 'CreatePage';
		mocks.window.location = 'http://www.muppet.wikia.com/wiki/Special:CreatePage';

		var createPageTrackingModule = modules['ext.wikia.flowTracking.createPageTracking'](
			mocks.flowTracking, QuerystringModule, mocks.mw, mocks.document, mocks.window
		);

		createPageTrackingModule.trackOnSpecialCreatePageLoad('editor', 'articleName');

		expect(mocks.flowTracking.beginFlow).toHaveBeenCalledWith('create-page-special-create-page', {editor: 'editor'});
		expect(mocks.flowTracking.trackFlowStep).not.toHaveBeenCalled();
	});

	it('should track special create flow if article name contains colon but prefix is not a known namespace',
		function () {
			wgArticleId = 0;
			wgNamespaceNumber = -1;
			wgTitle = 'CreatePage';
			mocks.window.location = 'http://www.muppet.wikia.com/wiki/Special:CreatePage';

			var createPageTrackingModule = modules['ext.wikia.flowTracking.createPageTracking'](
				mocks.flowTracking, QuerystringModule, mocks.mw, mocks.document, mocks.window
			);

			createPageTrackingModule.trackOnSpecialCreatePageLoad('editor', 'Testing:articleName');

			expect(mocks.flowTracking.beginFlow).toHaveBeenCalledWith(
				'create-page-special-create-page', {editor: 'editor'}
			);
			expect(mocks.flowTracking.trackFlowStep).not.toHaveBeenCalled();
	});

	it('should track community page flow', function () {
		wgArticleId = 0;
		wgNamespaceNumber = -1;
		wgTitle = 'CreatePage';
		mocks.window.location = 'http://www.muppet.wikia.com/wiki/Special:CreatePage?flow=create-page-community-page';

		var createPageTrackingModule = modules['ext.wikia.flowTracking.createPageTracking'](
			mocks.flowTracking, QuerystringModule, mocks.mw, mocks.document, mocks.window
		);

		createPageTrackingModule.trackOnSpecialCreatePageLoad('editor', 'articleName');

		expect(mocks.flowTracking.beginFlow).not.toHaveBeenCalled();
		expect(mocks.flowTracking.trackFlowStep).toHaveBeenCalledWith(
			'create-page-community-page', {editor: 'editor'}
		);
	});

	it('should not track flow if provided article is in non main namespace', function () {
		wgArticleId = 0;
		wgNamespaceNumber = -1;
		wgTitle = 'CreatePage';
		mocks.window.location = 'http://www.muppet.wikia.com/wiki/Special:CreatePage';

		var createPageTrackingModule = modules['ext.wikia.flowTracking.createPageTracking'](
			mocks.flowTracking, QuerystringModule, mocks.mw, mocks.document, mocks.window
		);

		createPageTrackingModule.trackOnSpecialCreatePageLoad('editor', 'Category:articleName');

		expect(mocks.flowTracking.beginFlow).not.toHaveBeenCalled();
		expect(mocks.flowTracking.trackFlowStep).not.toHaveBeenCalled();
	});

	it('should not track flow if namespace is special but page is different than CreatePage', function () {
		wgArticleId = 0;
		wgNamespaceNumber = -1;
		wgTitle = 'Insights';
		mocks.window.location = 'http://www.muppet.wikia.com/wiki/Special:Insights';

		var createPageTrackingModule = modules['ext.wikia.flowTracking.createPageTracking'](
			mocks.flowTracking, QuerystringModule, mocks.mw, mocks.document, mocks.window
		);

		createPageTrackingModule.trackOnSpecialCreatePageLoad('editor', 'articleName');

		expect(mocks.flowTracking.beginFlow).not.toHaveBeenCalled();
		expect(mocks.flowTracking.trackFlowStep).not.toHaveBeenCalled();
	});

	it('should not track flow if namespace is different than main or special', function () {
		wgArticleId = 0;
		wgNamespaceNumber = 4;

		var createPageTrackingModule = modules['ext.wikia.flowTracking.createPageTracking'](
			mocks.flowTracking, QuerystringModule, mocks.mw, mocks.document, mocks.window
		);

		createPageTrackingModule.trackOnSpecialCreatePageLoad('editor', 'articleName');

		expect(mocks.flowTracking.beginFlow).not.toHaveBeenCalled();
		expect(mocks.flowTracking.trackFlowStep).not.toHaveBeenCalled();
	});

	it('should not track flow if already tracked', function () {
		wgArticleId = 0;
		wgNamespaceNumber = 0;
		mocks.window.location = 'http://www.muppet.wikia.com/wiki/Special:CreatePage?tracked';

		var createPageTrackingModule = modules['ext.wikia.flowTracking.createPageTracking'](
			mocks.flowTracking, QuerystringModule, mocks.mw, mocks.document, mocks.window
		);

		createPageTrackingModule.trackOnSpecialCreatePageLoad('editor', 'articleName');

		expect(mocks.flowTracking.beginFlow).not.toHaveBeenCalled();
		expect(mocks.flowTracking.trackFlowStep).not.toHaveBeenCalled();
	});

});
