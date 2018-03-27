describe('PageActions', function () {
	function noop() {}

	var mocks = {
		mw: {
			message: function (key) {
				return {
					escaped: function () {
						return key;
					}
				}
			}
		},
		modal: {
			length: 1,
			remove: noop
		},
		$: function () {
				return mocks.modal;
		},
		log: noop,
		context: {}
	};

	mocks.$.noop = noop;
	mocks.log.levels = {};

	function getModule() {
		return modules['PageActions'](mocks.mw, mocks.$, mocks.log, mocks.context);
	}

	beforeEach(function resetContext() {
		mocks.context = {
			location: {}
		};
	});

	describe('add', function () {
		it('registers shortcuts from global var wgWikiaPageActions', function () {
			mocks.context.wgWikiaPageActions = [
				{ id: 'a-test-module', caption: 'test', href: 'foo.example.com' },
				{ id: 'another-test-module', caption: 'baz', href: 'bar.example.com' }
			];

			var pageActions = getModule();

			expect(pageActions.find('a-test-module').id).toEqual('a-test-module');
			expect(pageActions.find('another-test-module').id).toEqual('another-test-module');
		});

		it('registers case insensitive shortcuts', function () {
			var pageActions = getModule(),
				action = { id: 'test-Id', caption: 'test', href: 'www.example.com' };

			pageActions.add(action);

			expect(pageActions.find('test-id').id).toEqual('test-id');
			expect(pageActions.find('test-Id').id).toEqual('test-id');
			expect(pageActions.find('test-ID').id).toEqual('test-id');
			expect(pageActions.find('TEST-ID').id).toEqual('test-id');
		});

		it('does not overwrite existing shortcut by default', function () {
			var pageActions = getModule(),
				actionOne = { id: 'test-Id', caption: 'test', href: 'www.example.com' },
				actionTwo = { id: 'test-Id', caption: 'other', href: 'bar.example.com' };

			pageActions.add(actionOne);
			pageActions.add(actionTwo);

			expect(pageActions.find('test-Id').caption).toEqual(actionOne.caption);
		});

		it('overwrites existing shortcut when specified', function () {
			var pageActions = getModule(),
				actionOne = { id: 'test-Id', caption: 'test', href: 'www.example.com' },
				actionTwo = { id: 'test-Id', caption: 'other', href: 'bar.example.com' };

			pageActions.add(actionOne);
			pageActions.add(actionTwo, true);

			expect(pageActions.find('test-Id').caption).toEqual(actionTwo.caption);
		});
	});

	describe('execute', function () {
		it('calls provided function when given', function () {
			var pageActions = getModule(),
				action = { id: 'test-Id', caption: 'test', fn: noop };

			spyOn(action, 'fn');
			spyOn(mocks.modal, 'remove');

			pageActions.add(action);

			pageActions.find('test-Id').execute();

			expect(action.fn).toHaveBeenCalled();
			expect(mocks.modal.remove).toHaveBeenCalled();
		});

		it('uses window.location redirect when href given', function () {
			var pageActions = getModule(),
				action = { id: 'test-Id', caption: 'test', href: 'www.example.com' };

			spyOn(mocks.modal, 'remove');

			pageActions.add(action);

			pageActions.find('test-Id').execute();

			expect(mocks.context.location.href).toEqual('www.example.com');
			expect(mocks.modal.remove).toHaveBeenCalled();
		});
	});

	describe('update', function () {
		it('updates single property', function () {
			var pageActions = getModule(),
				action = { id: 'test-Id', caption: 'test', fn: noop };

			pageActions.add(action);
			pageActions.find('test-Id').update('caption', 'bar');

			expect(pageActions.find('test-Id').caption).toEqual('bar');
		});

		it('updates property with object syntax', function () {
			var pageActions = getModule(),
				action = { id: 'test-Id', caption: 'test', fn: noop },
				update = { caption: 'bar' };

			pageActions.add(action);
			pageActions.find('test-Id').update(update);

			expect(pageActions.find('test-Id').caption).toEqual('bar');
		});
	});
});
