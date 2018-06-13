import Component from '@ember/component';

const isTouchDevice = ('ontouchstart' in window);

export default Component.extend({
	classNameBindings: [
		'isClicked:wds-is-clicked',
		'dropdownExpanded:wds-is-active',
		'hasShadow:wds-has-shadow',
		'hasDarkShadow:wds-has-dark-shadow',
		'isLevel2:wds-dropdown-level-2:wds-dropdown'
	],
	isLevel2: false,

	actions: {
		click(e) {
			if (isTouchDevice && !this.get('isClicked')) {
				this.set('isClicked', true);
				e.preventDefault();
			}
		},

		mouseLeave() {
			if (isTouchDevice) {
				this.set('isClicked', false);
			}
		}
	}
});
