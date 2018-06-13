import Component from '@ember/component';

export default Component.extend({
	attributeBindings: ['model.href:href'],
	classNames: 'wds-global-footer__link',
	tagName: 'a',
});
