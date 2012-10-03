/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/AdConfig2Late.js
 */

module('AdConfig2Late');

test('getProvider returns Liftium2 if it can handle it', function() {
	var adProviderNullMock = {name: 'NullMock'}
		, adProviderLiftium2Mock = {name: 'Liftium2Mock', canHandleSlot: function() {return true;}}
		, adProviderLiftium2DomMock = {name: 'Liftium2DomMock', canHandleSlot: function() {return false;}}
		, logMock = function() {}
		, adConfig;

	adConfig = AdConfig2Late(
		logMock

		, adProviderLiftium2Mock
		, adProviderLiftium2DomMock
		, adProviderNullMock
	);

	equal(adConfig.getProvider(['foo']), adProviderLiftium2Mock, 'adProviderLiftium2Mock');
});

test('getProvider returns Null if Liftium cannot handle it', function() {
	var adProviderNullMock = {name: 'NullMock'}
		, adProviderLiftium2Mock = {name: 'Liftium2Mock', canHandleSlot: function() {return false;}}
		, adProviderLiftium2DomMock = {name: 'Liftium2DomMock', canHandleSlot: function() {return false;}}
		, logMock = function() {}
		, adConfig;

	adConfig = AdConfig2Late(
		logMock

		, adProviderLiftium2Mock
		, adProviderLiftium2DomMock
		, adProviderNullMock
	);

	equal(adConfig.getProvider(['foo']), adProviderNullMock, 'adProviderNullMock');
});
