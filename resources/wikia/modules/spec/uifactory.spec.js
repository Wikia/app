describe('UIFactory', function () {
	'use strict';

	var requestedComponent = 'button',
		nirvana = {},
		loader = function () {
			return {
				done: function (func) {
					func();
				}
			};
		},
		uiComponent = function () {
			var componentConfig = {};
			this.setComponentsConfig = function (config) {
				componentConfig = config;
			};
			this.getSubComponent = function (name) {
				return componentConfig.dependencies[name];
			};
		},
		componentConfig = {
			components: [{
				templates: {
					link: '<a href="{{href}}" titile="{{title}}">{{value}}</a>'
				},
				templateVarsConfig: {
					link: {
						required: ['href', 'title', 'value']
					}
				},
				assets: {
					css: ['link1', 'link2', 'link3'],
					js: ['link1', 'link2', 'link3']
				}
			}]
		},
		error = 'NotFoundApiException: File not found ' +
		'(/usr/wikia/source/wiki/resources/wikia/ui_components/xxx/xxx_config.json).',
		uifactory = modules['wikia.ui.factory'](nirvana, window, loader, uiComponent, jQuery);

	window.wgStyleVersion = 12345;

	it('registers AMD module', function () {
		expect(uifactory).toBeDefined();
		expect(typeof uifactory).toBe('object', 'uifactory');
	});

	it('gives nice and clean API', function () {
		expect(typeof uifactory.init).toBe('function', 'init');
	});

	it('check if requested components are passed to AJAX request as array', function (done) {
		function nirvanaMock(resp) {
			var nirvana = {
				getJson: function (controller, method, params, callback) {
					expect(params.components instanceof Array).toBe(true);
					callback(resp);
				}
			};

			return nirvana;
		}
		var nirvana = nirvanaMock(componentConfig),
			uifactory = modules['wikia.ui.factory'](nirvana, window, loader, uiComponent, jQuery);

		uifactory.init(requestedComponent).done(function () {
			done();
		});
	});

	it('check if cachebaster is passed to AJAX request', function (done) {
		function nirvanaMock(resp) {
			var nirvana = {
				getJson: function (controller, method, params, callback) {
					expect(params.cb).toBe(window.wgStyleVersion);

					callback(resp);
				}
			};

			return nirvana;
		}

		var nirvana = nirvanaMock(componentConfig),
			uifactory = modules['wikia.ui.factory'](nirvana, window, loader, uiComponent, jQuery);

		uifactory.init(requestedComponent).done(function () {
			done();
		});
	});

	it('returns single component', function (done) {
		function nirvanaMock(resp) {
			var nirvana = {
				getJson: function (controller, method, params, callback) {
					expect(params.cb).toBe(window.wgStyleVersion);

					callback(resp);
				}
			};

			return nirvana;
		}

		var nirvana = nirvanaMock(componentConfig),
			uifactory = modules['wikia.ui.factory'](nirvana, window, loader, uiComponent, jQuery);

		uifactory.init(requestedComponent).done(function (component) {
			expect(component instanceof uiComponent).toBe(true);

			done();
		});
	});

	it('returns array of components', function (done) {
		function nirvanaMock(resp) {
			var nirvana = {
				getJson: function (controller, method, params, callback) {
					callback(resp);
				}
			};

			return nirvana;
		}

		var requestedComponent = ['button1', 'button2'],
			componentConfig = {
				components: [{
					templates: {
						link: '<a href="{{href}}" titile="{{title}}">{{value}}</a>'
					},
					templateVarsConfig: {
						link: {
							required: ['href', 'title', 'value']
						}
					},
					assets: {
						css: ['link1', 'link2', 'link3'],
						js: ['link1', 'link2', 'link3']
					}
				}, {
					templates: {
						link: '<a href="{{href}}" titile="{{title}}">{{value}}</a>'
					},
					templateVarsConfig: {
						link: {
							required: ['href', 'title', 'value']
						}
					},
					assets: {
						css: ['link1', 'link2', 'link3'],
						js: ['link1', 'link2', 'link3']
					}
				}]
			},
			nirvana = nirvanaMock(componentConfig),
			uifactory = modules['wikia.ui.factory'](nirvana, window, loader, uiComponent, jQuery);

		uifactory.init(requestedComponent).done(function (component1, component2) {
			expect(arguments.length).toBe(2);
			expect(component1 instanceof uiComponent).toBe(true);
			expect(component2 instanceof uiComponent).toBe(true);

			done();
		});
	});

	it('returns error form backend when requesting components', function (done) {
		function nirvanaMock(resp) {
			var nirvana = {
				getJson: function (controller, method, params, callback, errorCallback) {
					errorCallback(resp);
				}
			};

			return nirvana;
		}

		var xhrObject = {
				responseText: '{"error":"NotFoundApiException","message":"File not found ' +
					'(\/usr\/wikia\/source\/wiki\/resources\/wikia\/ui_components\/xxx\/xxx_config.json)."}'
			},
			nirvana = nirvanaMock(xhrObject),
			requestedComponent = 'xxx',
			uifactory = modules['wikia.ui.factory'](nirvana, window, loader, uiComponent, jQuery);

		expect(function () {
			uifactory.init(requestedComponent);
		}).toThrow(new Error(error));

		done();
	});

	it('creates and returns sub components', function (done) {
		function nirvanaMock(resp) {
			var nirvana = {
				getJson: function (controller, method, params, callback) {
					callback(resp);
				}
			};

			return nirvana;
		}

		var requestedComponent = ['button1'],
			componentConfig = {
				dependencies: {
					button: {
						templates: {
							link: '<a href="{{href}}" titile="{{title}}">{{value}}</a>'
						},
						templateVarsConfig: {
							link: {
								required: ['href', 'title', 'value']
							}
						},
						assets: {
							css: ['link1', 'link2', 'link3'],
							js: ['link1', 'link2', 'link3']
						}
					}
				},
				components: [{
					templates: {
						link: '<a href="{{href}}" titile="{{title}}">{{value}}</a>'
					},
					templateVarsConfig: {
						link: {
							required: ['href', 'title', 'value']
						}
					},
					assets: {
						css: ['link1', 'link2', 'link3'],
						js: ['link1', 'link2', 'link3']
					},
					dependencies: ['button']
				}]
			},
			nirvana = nirvanaMock(componentConfig),
			uifactory = modules['wikia.ui.factory'](nirvana, window, loader, uiComponent, jQuery);

		uifactory.init(requestedComponent).done(function (component1) {
			expect(arguments.length).toBe(1);
			expect(component1 instanceof uiComponent).toBe(true);
			expect(component1.getSubComponent('button') instanceof uiComponent).toBe(true);
			expect(component1 === component1.getSubComponent('button')).toBe(false);
			done();
		});
	});
});
