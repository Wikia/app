import Component from '@ember/component';
import {computed} from '@ember/object';

export default Component.extend({
	attributeBindings: ['style'],
	classNames: 'wds-community-header',
	tagName: 'header',
	style: computed('model', function () {
		return `background-image: url(${this.get('model')['background-image-url']});`
	}),
});
