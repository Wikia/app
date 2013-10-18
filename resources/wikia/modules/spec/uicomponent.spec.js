describe('UIComponent', function() {
	'use strict';

	var mustache = {
			render: function(template, params) {
				return componentHTMLMock;
			}
		},
		uicomponent = modules['wikia.ui.component'](mustache),
		componentConfig = {
			templates: {
				link: '<a href="{{href}}" titile="{{title}}">{{value}}</a>'
			},
			templateVarsConfig: {
				link: {
					required: ['href', 'title', 'value']
				}
			}
		},
		paramsToRender = {
			type: 'link',
			vars: {
				href: 'http://www.wikia.com',
				title: 'Wikia Home Page',
				value: 'Wikia'
			}
		},
		componentHTMLMock = '<a href="http://www.wikia.com" titile="Wikia Home Page">Wikia</a>';

	it('registers AMD module', function() {
		expect(uicomponent).toBeDefined();
		expect(typeof uicomponent).toBe('function', 'uicomponent');
	});

	it('gives nice and clean API', function() {
		var uiComponent = new uicomponent;

		expect(typeof uiComponent.render).toBe('function', 'render');
		expect(typeof uiComponent.setComponentsConfig).toBe('function', 'setComponentsConfig');
	});

	it('calling without a "new" returns a new instance of UIComponent', function() {
		var uiComponent1 = uicomponent(),
			uiComponent2 = uicomponent();

		expect(typeof uiComponent1.render).toBe('function', 'render');
		expect(typeof uiComponent1.setComponentsConfig).toBe('function', 'setComponentsConfig');
		expect(typeof uiComponent2.render).toBe('function', 'render');
		expect(typeof uiComponent2.setComponentsConfig).toBe('function', 'setComponentsConfig');
		expect(uiComponent1 === uiComponent2).toBe(false);
	});

	it('render component', function() {
		var uiComponent = uicomponent();
		uiComponent.setComponentsConfig(componentConfig['templates'], componentConfig['templateVarsConfig']);
		var html = uiComponent.render(paramsToRender);

		expect(html).toBe(componentHTMLMock);
	});

	it('throw error on validation - requested type is not supported', function(){
		var paramsToRender = {
				type: 'xxx',
				vars: {
					href: 'http://www.wikia.com',
					title: 'Wikia Home Page',
					value: 'Wikia'

				}
			},
			validationError = 'Requested component type is not supported!',
			uiComponent = uicomponent();

		uiComponent.setComponentsConfig(componentConfig['templates'], componentConfig['templateVarsConfig']);

		expect(function() {
			uiComponent.render(paramsToRender);
		}).toThrow(validationError);
	});

	it('throw error on validation - missing required variable', function() {
		var paramsToRender = {
			type: 'link',
			vars: {
				href: 'http://www.wikia.com',
				title: 'Wikia Home Page'
			}
			},
			validationError = 'Missing required mustache variables: value!',
			uiComponent = uicomponent();

		uiComponent.setComponentsConfig(componentConfig['templates'], componentConfig['templateVarsConfig']);

		expect(function() {
			uiComponent.render(paramsToRender);
		}).toThrow(validationError);
	})
});
