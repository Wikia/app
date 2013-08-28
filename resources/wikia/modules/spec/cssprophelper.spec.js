describe('CSSPropsHelper', function() {
	'use strict';

	var document = {
			documentElement: {
				style: {
					webkitTransformOrigin: ''
				}
			}
		},
		cssProperty = 'transform-origin',
		cssPropsHelper = modules['wikia.csspropshelper'](document);

	it('registers AMD module', function() {
		expect(typeof cssPropsHelper).toBe('object');
		expect(typeof cssPropsHelper.getCSSPropName).toBe('function');
		expect(typeof cssPropsHelper.convertPropName).toBe('function');
	});

	it('apply JS camel case style formatting', function() {
		var formattedProp = 'transformOrigin',
			prop = cssPropsHelper.convertPropName(cssProperty);

		expect(prop).toBe(formattedProp);
	});

	it('return prop name supported by current browser', function() {
		var formattedProp = 'webkitTransformOrigin',
			prop = cssPropsHelper.getCSSPropName(cssProperty);

		expect(prop).toBe(formattedProp);
	});


});