/* global getBody */
describe('Modal module', function () {
	'use strict';

	var win = {
			document: {
				body: getBody()
			}
		},
		jQuery = function (selector) {
			return {
				selector: selector,
				append: function (html) {
					win.document.body.innerHTML = html;
				},
				children: function () {},
				find: function () {
					return {
						click: function () {}
					};
				},
				on: function () {},
				click: function () {},
				removeClass: function () {
					return this;
				}
			};
		},
		browserDetect = {},
		tracker = {
			ACTIONS: {
				CLICK: 'click'
			},
			buildTrackingFunction: function () {}
		},
		modal,
		uiComponentMock = {
			render: function () {}
		};

	jQuery.msg = $.msg = function (key) {
		return key;
	};
	jQuery.isArray = function () {};
	jQuery.extend = window.jQuery.extend;
	jQuery.proxy = function () {};

	modal = modules['wikia.ui.modal'](jQuery, win, browserDetect, tracker);

	it('registers AMD module', function () {
		expect(modal).toBeDefined();
		expect(typeof modal).toBe('object');
	});

	it('gives nice and clean API', function () {
		expect(typeof modal.createComponent).toBe('function', 'init');
	});

	it('create instance of Modal class and link it with DOM element ID', function () {
		var id = 'testModal',
			selector = '#' + id,
			params = {
				vars: {
					id: id
				}
			},
			modalObject = modal.createComponent(params, uiComponentMock);

		expect(typeof modalObject).toBe('object');
		expect(modalObject.$element.selector).toBe(selector);
	});

	it('render modal, append to DOM and create instance of Modal class', function () {
		var params = {
				vars: {
					id: 'testModal'
				}
			},
			id = params.vars.id,
			modalSelector = '#' + id,
			htmlMock = '<div id="' + id + '"></div>',
			uiComponent = {
				render: function () {
					return htmlMock;
				}
			},
			modalObject = modal.createComponent(params, uiComponent);

		expect(win.document.body.innerHTML.indexOf(htmlMock)).not.toBe(-1);
		expect(typeof modalObject).toBe('object');
		expect(modalObject.$element.selector).toBe(modalSelector);
	});
});

describe('Modal events', function () {
	'use strict';

	var browserDetect = {},
		tracker = {
			ACTIONS: {
				CLICK: 'click'
			},
			buildTrackingFunction: function () {}
		},
		module = modules['wikia.ui.modal'](jQuery, window, browserDetect, tracker),
		modal = null,
		uiComponentMock = {
			render: function () {}
		},
		modalParams = {
			vars: {
				id: 'test'
			}
		};

	beforeEach(function () {
		modal = module.createComponent(modalParams, uiComponentMock);
	});

	it('triggers the event listener exactly once', function () {
		var listeners = {
			onFoo: function () {}
		};
		spyOn(listeners, 'onFoo');

		modal.bind('foo', listeners.onFoo);
		modal.trigger('foo');

		expect(listeners.onFoo).toHaveBeenCalled();
		expect(listeners.onFoo.calls.count()).toEqual(1);
	});

	it('triggers the proper event listener', function () {
		var listeners = {
			onFoo: function () {},
			onBar: function () {}
		};
		spyOn(listeners, 'onFoo');
		spyOn(listeners, 'onBar');

		modal.bind('foo', listeners.onFoo);
		modal.bind('bar', listeners.onBar);
		modal.trigger('foo');
		modal.trigger('foo');

		expect(listeners.onFoo).toHaveBeenCalled();
		expect(listeners.onFoo.calls.count()).toEqual(2);
		expect(listeners.onBar).not.toHaveBeenCalled();
	});

	it('triggers all event listeners', function () {
		var listeners = {
			onFoo1: function () {},
			onFoo2: function () {}
		};
		spyOn(listeners, 'onFoo1');
		spyOn(listeners, 'onFoo2');

		modal.bind('foo', listeners.onFoo1);
		modal.bind('foo', listeners.onFoo2);
		modal.trigger('foo');

		expect(listeners.onFoo1).toHaveBeenCalled();
		expect(listeners.onFoo1.calls.count()).toEqual(1);
		expect(listeners.onFoo2).toHaveBeenCalled();
		expect(listeners.onFoo2.calls.count()).toEqual(1);
	});

	it('triggers event listeners in order', function () {
		var array = [],
			listeners = {
				onFoo1: function () {
					array.push('foo1');
				},
				onFoo2: function () {
					array.push('foo2');
				}
			};

		modal.bind('foo', listeners.onFoo1);
		modal.bind('foo', listeners.onFoo2);
		modal.trigger('foo');

		expect(array).toEqual(['foo1', 'foo2']);
	});

	it('allows listeners to return deferreds', function () {
		var listeners = {
			onFoo: function () {
				var deferred = new $.Deferred();
				deferred.resolve();
				return deferred.promise();
			},
			onTriggerComplete: function () {}
		};

		spyOn(listeners, 'onFoo').and.callThrough();
		spyOn(listeners, 'onTriggerComplete');

		modal.bind('foo', listeners.onFoo);
		modal.trigger('foo').then(listeners.onTriggerComplete);
		expect(listeners.onFoo).toHaveBeenCalled();
		expect(listeners.onFoo.calls.count()).toEqual(1);
		expect(listeners.onTriggerComplete).toHaveBeenCalled();
		expect(listeners.onTriggerComplete.calls.count()).toEqual(1);
	});

	it('allows event to be completed without listeners', function () {
		var listeners = {
			onTriggerComplete: function () {}
		};

		spyOn(listeners, 'onTriggerComplete');
		modal.trigger('foo').then(listeners.onTriggerComplete);
		expect(listeners.onTriggerComplete).toHaveBeenCalled();
		expect(listeners.onTriggerComplete.calls.count()).toEqual(1);
	});

	it('allows to pass parameters to listeners', function () {
		var listeners = {
			onFoo: function () {}
		};

		spyOn(listeners, 'onFoo');

		modal.bind('foo', listeners.onFoo);
		modal.trigger('foo', 1, 'test', ['bar']);

		expect(listeners.onFoo).toHaveBeenCalledWith(1, 'test', ['bar']);
	});

	it('allows to use reject for canceling the event call', function () {
		var listeners = {
			onFoo1: function () {
				var deferred = new $.Deferred();
				deferred.reject();
				return deferred.promise();
			},
			onFoo2: function () {},
			onTriggerSuccess: function () {},
			onTriggerCancelled: function () {}
		};

		spyOn(listeners, 'onFoo1').and.callThrough();
		spyOn(listeners, 'onFoo2');
		spyOn(listeners, 'onTriggerSuccess');
		spyOn(listeners, 'onTriggerCancelled');

		modal.bind('foo', listeners.onFoo1);
		modal.bind('foo', listeners.onFoo2);
		modal.trigger('foo').then(listeners.onTriggerSuccess, listeners.onTriggerCancelled);

		expect(listeners.onFoo1).toHaveBeenCalled();
		expect(listeners.onFoo2).not.toHaveBeenCalled();
		expect(listeners.onTriggerSuccess).not.toHaveBeenCalled();
		expect(listeners.onTriggerCancelled).toHaveBeenCalled();
	});

	it('allows to mix synchronous and asynchronous listeners', function () {
		var listeners = {
			onFoo1: function () {
				var deferred = new $.Deferred();
				deferred.resolve();
				return deferred.promise();
			},
			onFoo2: function () {},
			onTriggerSuccess: function () {}
		};

		spyOn(listeners, 'onFoo1').and.callThrough();
		spyOn(listeners, 'onFoo2');
		spyOn(listeners, 'onTriggerSuccess');

		modal.bind('foo', listeners.onFoo2);
		modal.bind('foo', listeners.onFoo1);
		modal.bind('foo', listeners.onFoo2);
		modal.bind('foo', listeners.onFoo1);
		modal.trigger('foo').then(listeners.onTriggerSuccess);

		expect(listeners.onFoo1).toHaveBeenCalled();
		expect(listeners.onFoo1.calls.count()).toEqual(2);
		expect(listeners.onFoo2).toHaveBeenCalled();
		expect(listeners.onFoo2.calls.count()).toEqual(2);
		expect(listeners.onTriggerSuccess).toHaveBeenCalled();
		expect(listeners.onTriggerSuccess.calls.count()).toEqual(1);
	});

});

describe('Modal buttons', function () {
	'use strict';

	var browserDetect = {},
		renderFunction = function (params) {
			return params;
		},
		tracker = {
			ACTIONS: {
				CLICK: 'click'
			},
			buildTrackingFunction: function () {}
		},
		button = {
			type: 'button',
			vars: {
				type: 'button',
				classes: ['normal', 'secondary']
			}
		},
		subComponent = {
			render: renderFunction
		},
		uiComponent = {
			render: renderFunction,
			getSubComponent: function () {
				return subComponent;
			}
		},
		modal = modules['wikia.ui.modal'](jQuery, window, browserDetect, tracker);

	it('allows modals without buttons', function () {
		var params = {
				vars: {
					title: 'Test',
					size: 'small'
				}
			},
			modalObject = modal.createComponent(params, uiComponent);
		expect(typeof modalObject).toEqual('object');
	});

	it('creates buttons defined buttons', function () {
		var params = {
				vars: {
					title: 'Test',
					size: 'small',
					buttons: [button]
				}
			},
			modalObject;

		spyOn(uiComponent, 'render');
		spyOn(subComponent, 'render');

		modalObject = modal.createComponent(params, uiComponent);

		expect(typeof modalObject).toEqual('object');
		expect(typeof uiComponent.render).toEqual('function');

		expect(uiComponent.render).toHaveBeenCalled();
		expect(subComponent.render).toHaveBeenCalledWith(button);
	});

	it('skips buttons if non array is passed', function () {
		var params = {
				vars: {
					title: 'Test',
					size: 'small',
					buttons: 'button'
				}
			},
			modalObject;

		spyOn(subComponent, 'render');

		modalObject = modal.createComponent(params, uiComponent);
		expect(subComponent.render).not.toHaveBeenCalledWith(button);
	});

	it('renders buttons', function () {
		var params = {
				vars: {
					title: 'Test',
					size: 'small',
					buttons: [button, '<button>']
				}
			},
			modal = modules['wikia.ui.modal'](jQuery, window, browserDetect, tracker),
			renderResult = {
				type: 'default',
				vars: {
					closeText: 'close',
					escapeToClose: true,
					title: 'Test',
					size: 'small',
					buttons: [{
							type: 'button',
							vars: {
								type: 'button',
								classes: ['normal', 'secondary']
							}
						},
						'<button>'
					]
				},
				confirmCloseModal: false
			};

		spyOn(jQuery.fn, 'append');
		modal.createComponent(params, uiComponent);
		expect(jQuery.fn.append).toHaveBeenCalledWith(renderResult);
	});
});
