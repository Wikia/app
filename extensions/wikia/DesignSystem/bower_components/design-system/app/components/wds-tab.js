import Component from '@ember/component';
import {computed} from '@ember/object';

export default Component.extend({
	tagName: 'li',
	classNames: 'wds-tabs__tab',
	classNameBindings: ['isSelected:wds-is-current', 'disabled:wds-is-disabled'],

	isSelected: computed('selected', 'value', function () {
		const value = this.get('value');

		return value !== undefined && this.get('selected') === value;
	}),

	onSelect() {},

	click() {
		this.get('onSelect')(this);
	}
});
