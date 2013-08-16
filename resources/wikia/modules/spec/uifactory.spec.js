describe('UIFactory', function(){
	'use strict';

	var requestedComponent = 'button',
		async = new AsyncSpec(this),
		nirvana = {},
		deferred = jQuery.Deferred,
		uiComponent = function() {
			var confing = {};
			this.setComponentsConfig = function(templates, templateVarsConfig) {
				confing.templates = templates;
				confing.templateVarsConfig = templateVarsConfig;
			}
		},
		componentConfig = {
			status: 1,
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
		uifactory = modules['wikia.uifactory'](nirvana, window, deferred, uiComponent);

	window.wgStyleVersion = 12345;

	it('registers AMD module', function() {
		expect(uifactory).toBeDefined();
		expect(typeof uifactory).toBe('object', 'uifactory');
	});

	it('gives nice and clean API', function() {
		expect(typeof uifactory.init).toBe('function', 'init');
	});

	async.it('returns single component', function(done) {
		function nirvanaMock(resp) {
			var nirvana = {
				getJson: function(controller, method, params, callback) {
					expect(params.components).toBe(requestedComponent);
					expect(params.cb).toBe(window.wgStyleVersion);

					callback(resp);
				}
			};

			return nirvana;
		}

		var nirvana = nirvanaMock(componentConfig);
		uifactory = modules['wikia.uifactory'](nirvana, window, deferred, uiComponent);

		uifactory.init(requestedComponent).done(function(component) {
			expect(component instanceof uiComponent).toBe(true);

			done();
		});
	});

	async.it('returns array of components', function(done) {
		function nirvanaMock(resp) {
			var nirvana = {
				getJson: function(controller, method, params, callback) {
					expect(params.components).toBe(requestedComponent);
					expect(params.cb).toBe(window.wgStyleVersion);

					callback(resp);
				}
			};

			return nirvana;
		}

		var requestedComponent = ['button1', 'button2'],
			componentConfig = {
				status: 1,
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
			nirvana = nirvanaMock(componentConfig);
		uifactory = modules['wikia.uifactory'](nirvana, window, deferred, uiComponent);

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
					expect(params.components).toBe(requestedComponent);
					expect(params.cb).toBe(window.wgStyleVersion);

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
		uifactory = modules['wikia.uifactory'](nirvana, window, deferred, uiComponent);

		expect(function() {
			uifactory.init(requestedComponent);
		}).toThrow(error);

		done();
	});

	async.it('add assets to DOM', function(done) {
		function nirvanaMock(resp) {
			var nirvana = {
				getJson: function(controller, method, params, callback) {
					expect(params.components).toBe(requestedComponent);
					expect(params.cb).toBe(window.wgStyleVersion);

					callback(resp);
				}
			};

			return nirvana;
		}

		var nirvana = nirvanaMock(componentConfig),
			window = {
				document: {
					head: {
						appendChild: function(prop) {
							this[prop] = {}
						}
					},
					body: {
						appendChild: function(prop) {
							this[prop] = {}
						}
					},
					createDocumentFragment: function() {
						return {
							appendChild: function(prop) {
								this[prop] = {}
							}
						}
					},
					createElement: function(object) {
						return {};
					}
				},
				wgStyleVersion: 12345
			},
		uifactory = modules['wikia.uifactory'](nirvana, window, deferred, uiComponent);

		spyOn(window.document.body, 'appendChild').andCallThrough();
		spyOn(window.document.head, 'appendChild').andCallThrough();
		spyOn(window.document, 'createDocumentFragment').andCallThrough();
		spyOn(window.document, 'createElement').andCallThrough();

		uifactory.init(requestedComponent).done(function() {

			expect(window.document.createDocumentFragment.calls.length).toEqual(2);
			expect(window.document.createElement.calls.length).toEqual(6);
			expect(window.document.body.appendChild.calls.length).toEqual(1);
			expect(window.document.head.appendChild.calls.length).toEqual(1);

			done();
		});
	});


});
