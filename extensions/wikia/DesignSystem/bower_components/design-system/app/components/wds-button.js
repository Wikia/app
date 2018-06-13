import Component from '@ember/component';

export default Component.extend({
	attributeBindings: [
		'disabled',
		'href',
		'title',
		'data-tracking-label',
		'type',
	],
	classNames: 'wds-button',
	classNameBindings: [
		'secondary:wds-is-secondary',
		'text:wds-is-text',
		'square:wds-is-square'
	],
	tagName: 'button',
	disabled: false,

	init() {
		this._super(...arguments);

		if (this.get('href')) {
			this.set('tagName', 'a');
		}
	}
});
