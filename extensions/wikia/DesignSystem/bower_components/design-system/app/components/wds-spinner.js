import {bool} from '@ember/object/computed';
import Component from '@ember/component';
import {computed} from '@ember/object';

export default Component.extend({
	classNameBindings: ['overlay:wds-spinner__overlay'],

	spinnerClasses: computed('isBlock', function () {
		return `wds-spinner ${this.get('isBlock') ? 'wds-spinner__block' : ''}`;
	}),

	isVisible: bool('active'),
	active: false,
	overlay: true,
	isBlock: false,
	isThemed: true,
	radius: 30,
	strokeWidth: 6,

	fullRadius: computed('radius', function () {
		return this.get('radius') + (this.get('strokeWidth') / 2);
	}),

	fullDiameter: computed('radius', function () {
		return this.get('radius') * 2 + this.get('strokeWidth');
	}),

	strokeLength: computed('radius', function () {
		return 2 * Math.PI * this.get('radius');
	})
});
