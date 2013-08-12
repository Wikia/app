describe('UICompnent', function(){

	var mustache = {
			render: function(template, params) {
				return componentHTMLMock;
			}
		},
		uicomponent = modules['wikia.uicomponent'](mustache),
		componentConfig = {
			templates: {
				link: '<a href="{{href}}" titile="{{title}}">{{value}}</a>'
			},
			templateVars: {
				required: ['href', 'title', 'value']
			}
		},
		mustacheVariables = {
			href: 'http://www.wikia.com',
			title: 'Wikia Home Page',
			value: 'Wikia'
		},
		componentHMTLMock = '<a href="http://www.wikia.com" titile="Wikia Home Page">Wikia</a>',
		validationError = 'Missing required mustache variables: value!';

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
		var uiComponent = uicomponent();

		expect(typeof uiComponent.render).toBe('function', 'render');
		expect(typeof uiComponent.setComponentsConfig).toBe('function', 'setComponentsConfig');
	});

	it('render component', function() {
		var uiComponent = uicomponent();

		uiComponent.setComponentsConfig(componentConfig['templates'], componentConfig['templateVars']);
		var html = uiComponent.render(mustacheVariables);

		expect(html.toContain(componentHMTLMock));
	});

	mustacheVariables = {
		href: 'http://www.wikia.com',
		title: 'Wikia Home Page'
	};

	it('throw error on validation', function() {
		var uiComponent = uicomponent();

		uiComponent.setComponentsConfig(componentConfig['templates'], componentConfig['templateVars']);

		expect(function() {
			uiComponent.render(mustacheVariables);
		}).toThrow(validationError);
	})

});