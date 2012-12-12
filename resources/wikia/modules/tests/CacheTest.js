/**
 * @test-framework QUnit
 * @test-require-asset resources/wikia/modules/cache.js
 */

module('Wikia.Cache');

test('Set then get', function() {

	Wikia.Cache.set('a1', 'some-value');
	equal(Wikia.Cache.get('a1'), 'some-value', 'string');

	Wikia.Cache.set('a2', {'x': 'y', '123': 456});
	deepEqual(Wikia.Cache.get('a2'), {'x': 'y', '123': 456}, 'object');

	Wikia.Cache.set('a3', false);
	equal(Wikia.Cache.get('a3'), false, 'false');

	Wikia.Cache.set('a4', null);
	equal(Wikia.Cache.get('a4'), null, 'null');

	Wikia.Cache.set('a5', 0);
	equal(Wikia.Cache.get('a5'), 0, '0');

	Wikia.Cache.set('a6', '');
	equal(Wikia.Cache.get('a6'), '', 'empty string');

	Wikia.Cache.set('a7', {});
	deepEqual(Wikia.Cache.get('a7'), {}, 'empty object');

	Wikia.Cache.set('a8', []);
	deepEqual(Wikia.Cache.get('a8'), [], 'empty array');
});

test('Gets from localStorage', function() {
	localStorage.setItem('wkch_val_b1', JSON.stringify('some-value'));
	equal(Wikia.Cache.get('b1'), 'some-value', 'string');

	localStorage.setItem('wkch_val_b2', JSON.stringify({'x': 'y', '123': 456}));
	deepEqual(Wikia.Cache.get('b2'), {'x': 'y', '123': 456}, 'object');

	localStorage.setItem('wkch_val_b3', JSON.stringify(false));
	equal(Wikia.Cache.get('b3'), false, 'false');

	localStorage.setItem('wkch_val_b4', JSON.stringify(null));
	equal(Wikia.Cache.get('b4'), null, 'null');

	localStorage.setItem('wkch_val_b5', JSON.stringify(0));
	equal(Wikia.Cache.get('b5'), 0, '0');

	localStorage.setItem('wkch_val_b6', JSON.stringify(''));
	equal(Wikia.Cache.get('b6'), '', 'empty string');

	localStorage.setItem('wkch_val_b7', JSON.stringify({}));
	deepEqual(Wikia.Cache.get('b7'), {}, 'empty object');

	localStorage.setItem('wkch_val_b8', JSON.stringify([]));
	deepEqual(Wikia.Cache.get('b8'), [], 'empty array');
});

test('Sets to localStorage', function() {

	Wikia.Cache.set('c1', 'some-value');
	equal(localStorage.getItem('wkch_val_c1'), JSON.stringify('some-value'), 'string');

	Wikia.Cache.set('c2', {'x': 'y', '123': 456});
	equal(localStorage.getItem('wkch_val_c2'), JSON.stringify({'x': 'y', '123': 456}), 'object');

	Wikia.Cache.set('c3', false);
	equal(localStorage.getItem('wkch_val_c3'), JSON.stringify(false), 'false');

	Wikia.Cache.set('c4', null);
	equal(localStorage.getItem('wkch_val_c4'), JSON.stringify(null), 'null');

	Wikia.Cache.set('c5', 0);
	equal(localStorage.getItem('wkch_val_c5'), JSON.stringify(0), '0');

	Wikia.Cache.set('c6', '');
	equal(localStorage.getItem('wkch_val_c6'), JSON.stringify(''), 'empty string');

	Wikia.Cache.set('c7', {});
	equal(localStorage.getItem('wkch_val_c7'), JSON.stringify({}), 'empty object');

	Wikia.Cache.set('c8', []);
	equal(localStorage.getItem('wkch_val_c8'), JSON.stringify([]), 'empty array');
});

test('Get from localStorage then set', function() {
	localStorage.setItem('wkch_val_d', JSON.stringify('some-value'));
	equal(Wikia.Cache.get('d'), 'some-value', 'get from localStorage');
	Wikia.Cache.set('d', 'new-value');
	equal(Wikia.Cache.get('d'), 'new-value', 'get after set');
	equal(localStorage.getItem('wkch_val_d'), JSON.stringify('new-value'), 'set to localStorage');
});

test('Get returns the value that was set last', function() {
	Wikia.Cache.set('e', 'some-value');
	Wikia.Cache.set('e', 'other-value');
	equal(Wikia.Cache.get('e'), 'other-value');
});

test('Value expires after given TTL', function() {
	var fakeNowTimestamp = 8723687632
		, fakeNow = {getTime: function() {return fakeNowTimestamp;}}
		, anHourLater = {getTime: function() {return fakeNowTimestamp + 3600 * 1000;}}
		, twoHoursLater = {getTime: function() {return fakeNowTimestamp + 2 * 3600 * 1000;}};

	Wikia.Cache.set('f', 'some-value', 3601, fakeNow);
	equal(Wikia.Cache.get('f', anHourLater), 'some-value');
	equal(Wikia.Cache.get('f', twoHoursLater), null);
});
