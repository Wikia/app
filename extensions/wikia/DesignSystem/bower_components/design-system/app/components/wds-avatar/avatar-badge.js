import Component from '@ember/component';
import {computed} from '@ember/object';
import {inject as service} from '@ember/service';

export default Component.extend({
	i18n: service(),

	tagName: 'span',
	classNames: 'wds-avatar__badge',
	attributeBindings: ['title'],
	name: null,

	badgeAssetName: computed('name', function() {
		const name = this.get('name');

		return name ? `wds-avatar-badges-${name}` : null;
	}),

	title: computed('name', function() {
		const name = this.get('name');

		return name ? this.get('i18n').t(`design-system:wds-avatar-badges-${name}-tooltip`) : '';
	}),
});
