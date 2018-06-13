'use strict';

module.exports = {
	name: 'design-system',

	included(app) {
		this._super.included.apply(this, arguments);

		app.import('vendor/polyfills.js', {prepend: true});
	}
};
