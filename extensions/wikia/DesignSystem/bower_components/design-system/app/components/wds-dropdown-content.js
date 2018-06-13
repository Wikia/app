import Component from '@ember/component';

export default Component.extend({
	classNameBindings: [
		'dropdownLeftAligned:wds-is-left-aligned',
		'dropdownRightAligned:wds-is-right-aligned',
		'scrollable::wds-is-not-scrollable',
		'isLevel2:wds-dropdown-level-2__content:wds-dropdown__content'
	],

	scrollable: true
});
