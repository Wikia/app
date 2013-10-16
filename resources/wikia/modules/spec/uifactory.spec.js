describe('UIFactory', function(){
	'use strict';

	var requestedComponent = 'button',
		async = new AsyncSpec(this),
		nirvana = {},
		loader = function() {
			return {
				done: function(func) {
					func();
				}
			}
		},
		uiComponent = function() {
			var config = {};
			this.setComponentsConfig = function(templates, templateVarsConfig) {
				config.templates = templates;
				config.templateVarsConfig = templateVarsConfig;
			}
		},
		componentConfig = {
			components: [
				{
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
			]
		},
		error = 'NotFoundApiException: File not found (/usr/wikia/source/wiki/resources/wikia/ui_components/xxx/xxx_config.json).',
		uifactory = modules['wikia.ui.factory'](nirvana, window, loader, uiComponent, jQuery);

	window.wgStyleVersion = 12345;

	it('registers AMD module', function() {
		expect(uifactory).toBeDefined();
		expect(typeof uifactory).toBe('object', 'uifactory');
	});

	it('gives nice and clean API', function() {
		expect(typeof uifactory.init).toBe('function', 'init');
	});

	async.it('check if requested components are passed to AJAX request as array', function(done){
		function nirvanaMock(resp) {
			var nirvana = {
				getJson: function(controller, method, params, callback) {
					expect(params.components instanceof Array).toBe(true);
					callback(resp);
				}
			};

			return nirvana;
		}
		var nirvana = nirvanaMock(componentConfig),
		uifactory = modules['wikia.ui.factory'](nirvana, window, loader, uiComponent, jQuery);

		uifactory.init(requestedComponent).done(function() {
			done();
		});
	});

	async.it('check if cachebaster is passed to AJAX request', function(done) {
		function nirvanaMock(resp) {
			var nirvana = {
				getJson: function(controller, method, params, callback) {
					expect(params.cb).toBe(window.wgStyleVersion);

					callback(resp);
				}
			};

			return nirvana;
		}

		var nirvana = nirvanaMock(componentConfig),
		uifactory = modules['wikia.ui.factory'](nirvana, window, loader, uiComponent, jQuery);

		uifactory.init(requestedComponent).done(function() {
			done();
		});
	});

	async.it('returns single component', function(done) {
		function nirvanaMock(resp) {
			var nirvana = {
				getJson: function(controller, method, params, callback) {
					expect(params.cb).toBe(window.wgStyleVersion);

					callback(resp);
				}
			};

			return nirvana;
		}

		var nirvana = nirvanaMock(componentConfig),
		uifactory = modules['wikia.ui.factory'](nirvana, window, loader, uiComponent, jQuery);

		uifactory.init(requestedComponent).done(function(component) {
			expect(component instanceof uiComponent).toBe(true);

			done();
		});
	});

	async.it('returns array of components', function(done) {
		function nirvanaMock(resp) {
			var nirvana = {
				getJson: function(controller, method, params, callback) {
					callback(resp);
				}
			};

			return nirvana;
		}

		var requestedComponent = ['button1', 'button2'],
			componentConfig = {
				components: [
					{
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
					},
					{
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
				]
			},
			nirvana = nirvanaMock(componentConfig),
		uifactory = modules['wikia.ui.factory'](nirvana, window, loader, uiComponent, jQuery);

		uifactory.init(requestedComponent).done(function(components) {
			expect(components.length).toBe(2);
			expect(components[0] instanceof uiComponent).toBe(true);
			expect(components[1] instanceof uiComponent).toBe(true);

			done();
		});
	});

	async.it('returns error form backend when requesting components', function(done) {
		function nirvanaMock(resp) {
			var nirvana = {
				getJson: function(controller, method, params, callback, errorCallback) {
					errorCallback(resp);
				}
			};

			return nirvana;
		}

		var xhrObject = {
			responseText: '{"error":"NotFoundApiException","message":"File not found (\/usr\/wikia\/source\/wiki\/resources\/wikia\/ui_components\/xxx\/xxx_config.json)."}'
			},
			nirvana = nirvanaMock(xhrObject),
			requestedComponent = 'xxx',
		uifactory = modules['wikia.ui.factory'](nirvana, window, loader, uiComponent, jQuery);

		expect(function() {
			uifactory.init(requestedComponent);
		}).toThrow(error);

		done();
	});
});
