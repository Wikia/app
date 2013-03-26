describe("CacheTest", function(){
	var localStorage = {
		data: {},
		setItem: function(key, data){
			localStorage.data[key] = data;
		},
		getItem: function(key){
			return localStorage.data[key];
		}
	};

	var wc = modules['wikia.cache'](localStorage);

	it( 'Set then get', function() {
		wc.set('a1', 'some-value');
		expect(wc.get('a1')).toEqual('some-value');

		wc.set('a2', {'x': 'y', '123': 456});
		expect(wc.get('a2')).toEqual({'x': 'y', '123': 456});

		wc.set('a3', false);
		expect(wc.get('a3')).toEqual(false);

		wc.set('a4', null);
		expect(wc.get('a4')).toEqual(null);

		wc.set('a5', 0);
		expect(wc.get('a5')).toEqual(0);

		wc.set('a6', '');
		expect(wc.get('a6')).toEqual('');

		wc.set('a7', {});
		expect(wc.get('a7')).toEqual({});

		wc.set('a8', []);
		expect(wc.get('a8')).toEqual([]);
	});


	it('Gets from localStorage', function() {
		localStorage.setItem('wkch_val_b1', JSON.stringify('some-value'));
		expect(wc.get('b1')).toEqual('some-value');

		localStorage.setItem('wkch_val_b2', JSON.stringify({'x': 'y', '123': 456}));
		expect(wc.get('b2')).toEqual({'x': 'y', '123': 456});

		localStorage.setItem('wkch_val_b3', JSON.stringify(false));
		expect(wc.get('b3')).toEqual(false);

		localStorage.setItem('wkch_val_b4', JSON.stringify(null));
		expect(wc.get('b4')).toEqual(null);

		localStorage.setItem('wkch_val_b5', JSON.stringify(0));
		expect(wc.get('b5')).toEqual(0);

		localStorage.setItem('wkch_val_b6', JSON.stringify(''));
		expect(wc.get('b6')).toEqual('');

		localStorage.setItem('wkch_val_b7', JSON.stringify({}));
		expect(wc.get('b7')).toEqual({});

		localStorage.setItem('wkch_val_b8', JSON.stringify([]));
		expect(wc.get('b8')).toEqual([]);
	});

	it('Sets to localStorage', function() {
		wc.set('c1', 'some-value');
		expect(localStorage.getItem('wkch_val_c1')).toEqual(JSON.stringify('some-value'));

		wc.set('c2', {'x': 'y', '123': 456});
		expect(localStorage.getItem('wkch_val_c2')).toEqual(JSON.stringify({'x': 'y', '123': 456}));

		wc.set('c3', false);
		expect(localStorage.getItem('wkch_val_c3')).toEqual(JSON.stringify(false));

		wc.set('c4', null);
		expect(localStorage.getItem('wkch_val_c4')).toEqual(JSON.stringify(null));

		wc.set('c5', 0);
		expect(localStorage.getItem('wkch_val_c5')).toEqual(JSON.stringify(0));

		wc.set('c6', '');
		expect(localStorage.getItem('wkch_val_c6')).toEqual(JSON.stringify(''));

		wc.set('c7', {});
		expect(localStorage.getItem('wkch_val_c7')).toEqual(JSON.stringify({}));

		wc.set('c8', []);
		expect(localStorage.getItem('wkch_val_c8')).toEqual(JSON.stringify([]));
	});

	it('Get from localStorage then set', function() {
		localStorage.setItem('wkch_val_d', JSON.stringify('some-value'));
		expect(wc.get('d')).toEqual('some-value');
		wc.set('d', 'new-value');
		expect(wc.get('d')).toEqual('new-value');
		expect(localStorage.getItem('wkch_val_d')).toEqual(JSON.stringify('new-value'));
	});


	it('Get returns the value that was set last', function() {
		wc.set('e', 'some-value');
		wc.set('e', 'other-value');
		expect(wc.get('e')).toEqual('other-value');
	});

	it('Value expires after given TTL', function() {
		var fakeNowTimestamp = 8723687632,
			fakeNow = {getTime: function() {return fakeNowTimestamp;}},
			anHourLater = {getTime: function() {return fakeNowTimestamp + 3600 * 1000;}},
			twoHoursLater = {getTime: function() {return fakeNowTimestamp + 2 * 3600 * 1000;}};

		wc.set('f', 'some-value', 3601, fakeNow);
		expect(wc.get('f', anHourLater)).toEqual('some-value');
		expect(wc.get('f', twoHoursLater)).toEqual(null);
	});

	it('returns null if cachebuster value get changed', function() {
		var windowMock = {
				wgStyleVersion: 1
			},
			wc = modules['wikia.cache'](window.localStorage, windowMock);

		wc.setVersioned('f', 'some-value1');
		expect(wc.getVersioned('f')).toEqual('some-value1');

		windowMock.wgStyleVersion = 100;
		expect(wc.getVersioned('f')).toEqual(null);
	});

});
