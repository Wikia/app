import Component from '@ember/component';

export default Component.extend({
	tagName: 'a',
	attributeBindings: ['model.href:href', 'model.tracking_label:data-tracking-label'],
	classNameBindings:['standaloneLink:wds-global-navigation__link'],
});
