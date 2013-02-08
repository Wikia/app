/**
 * @test-require-asset resources/wikia/libraries/define.mock.js
 * @test-require-asset resources/wikia/modules/cache.js
 */

module("CacheTest");

test('Set then get', function() {
	var wc = define.getModule();

	wc.set('a1', 'some-value');
	equal(wc.get('a1'), 'some-value', 'string');

	wc.set('a2', {'x': 'y', '123': 456});
	deepEqual(wc.get('a2'), {'x': 'y', '123': 456}, 'object');

	wc.set('a3', false);
	equal(wc.get('a3'), false, 'false');

	wc.set('a4', null);
	equal(wc.get('a4'), null, 'null');

	wc.set('a5', 0);
	equal(wc.get('a5'), 0, '0');

	wc.set('a6', '');
	equal(wc.get('a6'), '', 'empty string');

	wc.set('a7', {});
	deepEqual(wc.get('a7'), {}, 'empty object');

	wc.set('a8', []);
	deepEqual(wc.get('a8'), [], 'empty array');
});

test('Gets from localStorage', function() {
	var wc = define.getModule();

	localStorage.setItem('wkch_val_b1', JSON.stringify('some-value'));
	equal(wc.get('b1'), 'some-value', 'string');

	localStorage.setItem('wkch_val_b2', JSON.stringify({'x': 'y', '123': 456}));
	deepEqual(wc.get('b2'), {'x': 'y', '123': 456}, 'object');

	localStorage.setItem('wkch_val_b3', JSON.stringify(false));
	equal(wc.get('b3'), false, 'false');

	localStorage.setItem('wkch_val_b4', JSON.stringify(null));
	equal(wc.get('b4'), null, 'null');

	localStorage.setItem('wkch_val_b5', JSON.stringify(0));
	equal(wc.get('b5'), 0, '0');

	localStorage.setItem('wkch_val_b6', JSON.stringify(''));
	equal(wc.get('b6'), '', 'empty string');

	localStorage.setItem('wkch_val_b7', JSON.stringify({}));
	deepEqual(wc.get('b7'), {}, 'empty object');

	localStorage.setItem('wkch_val_b8', JSON.stringify([]));
	deepEqual(wc.get('b8'), [], 'empty array');
});

test('Sets to localStorage', function() {
	var wc = define.getModule();

	wc.set('c1', 'some-value');
	equal(localStorage.getItem('wkch_val_c1'), JSON.stringify('some-value'), 'string');

	wc.set('c2', {'x': 'y', '123': 456});
	equal(localStorage.getItem('wkch_val_c2'), JSON.stringify({'x': 'y', '123': 456}), 'object');

	wc.set('c3', false);
	equal(localStorage.getItem('wkch_val_c3'), JSON.stringify(false), 'false');

	wc.set('c4', null);
	equal(localStorage.getItem('wkch_val_c4'), JSON.stringify(null), 'null');

	wc.set('c5', 0);
	equal(localStorage.getItem('wkch_val_c5'), JSON.stringify(0), '0');

	wc.set('c6', '');
	equal(localStorage.getItem('wkch_val_c6'), JSON.stringify(''), 'empty string');

	wc.set('c7', {});
	equal(localStorage.getItem('wkch_val_c7'), JSON.stringify({}), 'empty object');

	wc.set('c8', []);
	equal(localStorage.getItem('wkch_val_c8'), JSON.stringify([]), 'empty array');
});

test('Get from localStorage then set', function() {
	var wc = define.getModule();
	localStorage.setItem('wkch_val_d', JSON.stringify('some-value'));
	equal(wc.get('d'), 'some-value', 'get from localStorage');
	wc.set('d', 'new-value');
	equal(wc.get('d'), 'new-value', 'get after set');
	equal(localStorage.getItem('wkch_val_d'), JSON.stringify('new-value'), 'set to localStorage');
});

test('Get returns the value that was set last', function() {
	var wc = define.getModule();
	wc.set('e', 'some-value');
	wc.set('e', 'other-value');
	equal(wc.get('e'), 'other-value');
});

test('Value expires after given TTL', function() {
	var wc = define.getModule(),
		fakeNowTimestamp = 8723687632,
		fakeNow = {getTime: function() {return fakeNowTimestamp;}},
		anHourLater = {getTime: function() {return fakeNowTimestamp + 3600 * 1000;}},
		twoHoursLater = {getTime: function() {return fakeNowTimestamp + 2 * 3600 * 1000;}};

	wc.set('f', 'some-value', 3601, fakeNow);
	equal(wc.get('f', anHourLater), 'some-value');
	equal(wc.get('f', twoHoursLater), null);
});
