import Component from '@ember/component';

export default Component.extend({
	tagName: '',

	checked: false,
	disabled: false,

	onChange() {},

	didInsertElement() {
		this.set('input', document.getElementById(this.get('id')));
	},

	actions: {
		onChange() {
			this.get('onChange')(this.input.checked)
		}
	}
});
