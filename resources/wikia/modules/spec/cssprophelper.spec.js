describe('CSSPropsHelper', function() {
	'use strict';

	var document = {
			documentElement: {
				style: {
					backgroundColor: '',
					borderShadow: '',
					lineHeight: '',
					webkitTransformOrigin: '',
					zIndex: ''
				}
			}
		},
		cssProperty = 'transform-origin',
		error = 'Requested CSS property - ' + cssProperty + ' is not supported by your browser!',
		cssPropsHelper = modules['wikia.csspropshelper'](document);

	it('registers AMD module', function() {
		expect(typeof cssPropsHelper).toBe('object');
		expect(typeof cssPropsHelper.getSupportedProp).toBe('function');
		expect(typeof cssPropsHelper.formatName).toBe('function');
	});

	it('applies JS camel case style formatting', function() {
		var formattedProp = 'transformOrigin',
			prop = cssPropsHelper.formatName(cssProperty);

		expect(prop).toBe(formattedProp);
	});

	it('return property name supported by current browser', function() {
		var formattedProp = 'webkitTransformOrigin',
			prop = cssPropsHelper.getSupportedProp(cssProperty);

		expect(prop).toBe(formattedProp);
	});

	it('throws error when property is not supported', function() {
		var document = {
			documentElement: {
				style: {
					backgroundColor: '',
					borderShadow: '',
					lineHeight: '',
					zIndex: ''
				}
			}
		},
			cssPropsHelper = modules['wikia.csspropshelper'](document);

		expect(function() {
			cssPropsHelper.getSupportedProp(cssProperty);
		}).toThrow(error);
	});

});
