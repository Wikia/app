import Component from '@ember/component';

export default Component.extend({
	classNameBindings: ['isLevel2:wds-dropdown-level-2__toggle:wds-dropdown__toggle'],
	attributeBindings: ['title', 'href']
});
