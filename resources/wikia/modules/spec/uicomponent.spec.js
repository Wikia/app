describe('UIComponent', function () {
	'use strict';

	var mustache = {
			render: function () {
				return componentHTMLMock;
			}
		},
		UiComponent = modules['wikia.ui.component'](mustache),
		componentConfig = {
			templates: {
				link: '<a href="{{href}}" titile="{{title}}">{{value}}</a>'
			},
			templateVarsConfig: {
				link: {
					required: ['href', 'title', 'value']
				}
			},
			dependencies: {}
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

	it('registers AMD module', function () {
		expect(UiComponent).toBeDefined();
		expect(typeof UiComponent).toBe('function', 'UiComponent');
	});

	it('gives nice and clean API', function () {
		var uiComponent = new UiComponent;

		expect(typeof uiComponent.render).toBe('function');
		expect(typeof uiComponent.setComponentsConfig).toBe('function');
		expect(typeof uiComponent.getSubComponent).toBe('function');
		expect(typeof uiComponent.createComponent).toBe('function');
	});

	it('calling without a "new" returns a new instance of UIComponent', function () {
		var uiComponent1 = UiComponent(),
			uiComponent2 = UiComponent();

		expect(typeof uiComponent1.render).toBe('function');
		expect(typeof uiComponent1.setComponentsConfig).toBe('function');
		expect(typeof uiComponent2.render).toBe('function');
		expect(typeof uiComponent2.setComponentsConfig).toBe('function');
		expect(uiComponent1 === uiComponent2).toBe(false);
	});

	it('render component', function () {
		var uiComponent = UiComponent();
		uiComponent.setComponentsConfig(componentConfig);
		var html = uiComponent.render(paramsToRender);

		expect(html).toBe(componentHTMLMock);
	});

	it('throw error on validation - requested type is not supported', function () {
		var paramsToRender = {
				type: 'xxx',
				vars: {
					href: 'http://www.wikia.com',
					title: 'Wikia Home Page',
					value: 'Wikia'

				}
			},
			validationError = 'Requested component type is not supported!',
			uiComponent = UiComponent();

		uiComponent.setComponentsConfig(componentConfig);

		expect(function () {
			uiComponent.render(paramsToRender);
		}).toThrow(new Error(validationError));
	});

	it('throw error on validation - missing required variable', function () {
		var paramsToRender = {
				type: 'link',
				vars: {
					href: 'http://www.wikia.com',
					title: 'Wikia Home Page'
				}
			},
			validationError = 'Missing required mustache variables: value!',
			uiComponent = UiComponent();

		uiComponent.setComponentsConfig(componentConfig);

		expect(function () {
			uiComponent.render(paramsToRender);
		}).toThrow(new Error(validationError));
	});

	it('throw error when sub component is not found', function () {
		var subComponentName = 'submarine',
			subComponentNotFoundError = 'Dependency ' + subComponentName + ' not found.',
			uiComponent = UiComponent();

		uiComponent.setComponentsConfig(componentConfig);

		expect(function () {
			uiComponent.getSubComponent(subComponentName);
		}).toThrow(new Error(subComponentNotFoundError));
	});

	it('returns UIComponent if jsWrapperModule is not set', function () {
		var uiComponent1 = UiComponent();
		uiComponent1.createComponent(paramsToRender, function (uiComponent2) {
			expect(uiComponent1 === uiComponent2).toBe(true);
		});
	});

	it('returns Custom object if jsWrapperModule is set', function () {
		var uiComponent1 = UiComponent(),
			componentConfig = {
				templates: {
					link: '<a href="{{href}}" titile="{{title}}">{{value}}</a>'
				},
				templateVarsConfig: {
					link: {
						required: ['href', 'title', 'value']
					}
				},
				dependencies: {},
				jsWrapperModule: 'wikia.ui.modal'
			};
		uiComponent1.setComponentsConfig(componentConfig);
		uiComponent1.createComponent(paramsToRender, function (uiComponent2) {
			expect(uiComponent1 === uiComponent2).toBe(false);
		});
	});
});
