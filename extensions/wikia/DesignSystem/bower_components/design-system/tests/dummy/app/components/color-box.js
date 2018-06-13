import Component from '@ember/component';
import {computed} from '@ember/object';
import {htmlSafe} from '@ember/string';

export default Component.extend({
	classNames: 'color-box',
	safeStyle: computed('hex', function () {
		return htmlSafe(`background-color: ${this.get('hex')}`);
	})
});
