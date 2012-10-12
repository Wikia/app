/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdConfig2Late.js
 */

module('AdConfig2Late');

test('getProvider returns Liftium2Dom if it can handle it', function() {
	var adProviderNullMock = {name: 'NullMock'}
		, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, adProviderLiftium2DomMock = {name: 'Liftium2DomMock', canHandleSlot: function() {return true;}}
		, logMock = function() {}
		, windowMock = {}
		, adConfig;

	adConfig = AdConfig2Late(
		logMock, windowMock

		, adProviderGameProMock
		, adProviderLiftium2DomMock
		, adProviderNullMock
	);

	equal(adConfig.getProvider(['foo']), adProviderLiftium2DomMock, 'adProviderLiftium2DomMock');
});

test('getProvider returns Null if Liftium cannot handle it', function() {
	var adProviderNullMock = {name: 'NullMock'}
		, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return false;}}
		, adProviderLiftium2DomMock = {name: 'Liftium2DomMock', canHandleSlot: function() {return false;}}
		, logMock = function() {}
		, windowMock = {}
		, adConfig;

	adConfig = AdConfig2Late(
		logMock, windowMock

		, adProviderGameProMock
		, adProviderLiftium2DomMock
		, adProviderNullMock
	);

	equal(adConfig.getProvider(['foo']), adProviderNullMock, 'adProviderNullMock');
});

test('for German sites, getProvider returns GamePro if it can handle it and Null for three slots', function() {
	var adProviderNullMock = {name: 'NullMock'}
		, adProviderGameProMock = {name: 'GameProMock', canHandleSlot: function() {return true;}}
		, adProviderLiftium2DomMock = {name: 'Liftium2DomMock', canHandleSlot: function() {return false;}}
		, logMock = function() {}
		, windowMock = {wgContentLanguage: 'de'}
		, adConfig;

	adConfig = AdConfig2Late(
		logMock, windowMock

		, adProviderGameProMock
		, adProviderLiftium2DomMock
		, adProviderNullMock
	);

	equal(adConfig.getProvider(['foo']), adProviderGameProMock, 'adProviderGameProMock');
	equal(adConfig.getProvider(['PREFOOTER_RIGHT_BOXAD']), adProviderNullMock, 'adProviderNullMock');
	equal(adConfig.getProvider(['LEFT_SKYSCRAPER_3']), adProviderNullMock, 'adProviderNullMock');
	equal(adConfig.getProvider(['TOP_RIGHT_BUTTON']), adProviderNullMock, 'adProviderNullMock');
});
