import Component from '@ember/component';

export default Component.extend({
	tagName: 'ul',
	classNames: 'wds-tabs',

	selected: 0,
	
	onChange() {},

	actions: {
		onChange(tab) {
			this.set('selected', tab.get('value'));

			this.get('onChange')(...arguments);
		}
	}
});
