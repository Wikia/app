describe('UIFactory', function(){
	'use strict';

	var requestedComponent = 'button',
		async = new AsyncSpec(this),
		nirvana = {},
		deferred = jQuery.Deferred,
	//TODO: speak with Jakub about mocking window and document
		window = {
			document: getBody(),
			wgStyleVersion: 12345
		},
		uiComponent = function() {
			var confing = {};
			this.setComponentsConfig = function(templates, templateVars) {
				confing.templates = templates;
				confing.templateVars = templateVars;
			}
		},
		componentConfig = {
			templates: {
				link: '<a href="{{href}}" titile="{{title}}">{{value}}</a>'
			},
			templateVars: {
				required: ['href', 'title', 'value']
			},
			dependencies: {
				css: ['link1', 'link2', 'link3'],
				js: ['link1', 'link2', 'link3']
			}
		},
		uifactory = modules['wikia.uifactory'](nirvana, window, deferred, uiComponent);

	function nirvanaMock(resp) {
		return {
			getJSON: function(controller, method, params, callback) {
				// token and regexp is correctly passed
				expect(params.components).toBe(requestedComponent);
				expect(params.cb).toBe(window.wgStyleVersion);

				callback(resp);
			}
		}
	}

	it('registers AMD module', function() {
		expect(uifactory).toBeDefined();
		expect(typeof uifactory).toBe('object', 'uifactory');
	});

	it('gives nice and clean API', function() {
		expect(typeof uifactory.init).toBe('function', 'init');
	});

	async.it('returns single component', function(done) {
		var nirvana = nirvanaMock(componentConfig);
		uifactory = modules['wikia.uifactory'](nirvana, window, deferred, uiComponent);

		uifactory.init(requestedComponent).done(function(component) {
			expect(component instanceof uiComponent).toBe(true);
			done();
		});
	});

	async.it('returns array of components', function(done) {
		var requestedComponent = ['button1', 'button2'],
		//TODO: add config
			componentConfig = {},
			nirvana = nirvanaMock(componentConfig);
		uifactory = modules['wikia.uifactory'](nirvana, window, deferred, uiComponent);

		uifactory.init(requestedComponent).done(function(components) {
			expect(components.length).toBe(2);
			expect(components[0] instanceof uiComponent).toBe(true);
			expect(components[1] instanceof uiComponent).toBe(true);
			done();
		});
	});

	async.it('add assets to DOM', function(done) {
		var nirvana = nirvanaMock(componentConfig);
		uifactory = modules['wikia.uifactory'](nirvana, window, deferred, uiComponent);

		uifactory.init(requestedComponent).done(function() {



			done();
		});
	});


});
