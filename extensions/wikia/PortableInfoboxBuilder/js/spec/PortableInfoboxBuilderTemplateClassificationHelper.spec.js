describe('wikia.infoboxBuilder.templateClassificationHelper', function () {
	var helper = null,
		windowMock = {},
		supportedTemplateType = 'infobox',
		notSupportedTemplateType = 'testType',
		modalMode = 'addTemplate',
		notSupportedModalMode = 'notSupportedModalMode',
		removeClassSpy = jasmine.createSpy('removeClassSpy'),
		jQueryMock = function () {
			return {
				removeClass: removeClassSpy
			}
		};

	beforeEach(function () {
		helper = null;
		windowMock = {};
		removeClassSpy.calls.reset();
	});

	it('should redirect to infobox builder', function () {
		windowMock.infoboxBuilderPath = 'test';
		windowMock.isTemplateBodySupportedInfobox = true;
		helper = modules['wikia.infoboxBuilder.templateClassificationHelper'](windowMock, jQueryMock);

		expect(helper.shouldRedirectToInfoboxBuilder(supportedTemplateType, modalMode)).toBe(true);
	});

	it('shouldn\'t redirect to infobox builder', function () {
		var testCases = [
			{
				infoboxBuilderPath: false,
				isTemplateBodySupportedInfobox: true,
				templateType: supportedTemplateType,
				modalMode: modalMode
			},
			{
				infoboxBuilderPath: true,
				isTemplateBodySupportedInfobox: false,
				templateType: supportedTemplateType,
				modalMode: modalMode
			},
			{
				infoboxBuilderPath: true,
				isTemplateBodySupportedInfobox: true,
				templateType: notSupportedTemplateType,
				modalMode: modalMode
			},
			{
				infoboxBuilderPath: true,
				isTemplateBodySupportedInfobox: true,
				templateType: supportedTemplateType,
				modalMode: notSupportedModalMode
			}
		];

		testCases.forEach(function (testCase) {
			windowMock.infoboxBuilderPath = testCase.infoboxBuilderPath;
			windowMock.isTemplateBodySupportedInfobox = testCase.isTemplateBodySupportedInfobox;
			helper = modules['wikia.infoboxBuilder.templateClassificationHelper'](windowMock, jQuery);

			expect(helper.shouldRedirectToInfoboxBuilder(testCase.templateType, testCase.modalMode)).toBe(false);

			//reset windowMock
			windowMock = {};
		});
	});

	it('redirects to infobox builder', function () {
		windowMock.infoboxBuilderPath = 'test/path';
		helper = modules['wikia.infoboxBuilder.templateClassificationHelper'](windowMock, jQueryMock);
		helper.redirectToInfoboxBuilder();

		expect(windowMock.location).toBe(windowMock.infoboxBuilderPath);
	});

	it('doesn\'t redirect to infobox builder if infoboxBuilderPath path is not defined', function () {
		helper = modules['wikia.infoboxBuilder.templateClassificationHelper'](windowMock, jQueryMock);
		helper.redirectToInfoboxBuilder();

		expect(windowMock.location).toBeUndefined();
	});

	it('removesClass from body element', function () {
		var tcClassName = 'test';

		windowMock.tcBodyClassName = tcClassName;
		helper = modules['wikia.infoboxBuilder.templateClassificationHelper'](windowMock, jQueryMock);
		helper.showHiddenEditor();

		expect(removeClassSpy).toHaveBeenCalledWith(tcClassName);
	});

	it('removesClass from body element', function () {
		helper = modules['wikia.infoboxBuilder.templateClassificationHelper'](windowMock, jQueryMock);
		helper.showHiddenEditor();

		expect(removeClassSpy).not.toHaveBeenCalled();
	});
});
