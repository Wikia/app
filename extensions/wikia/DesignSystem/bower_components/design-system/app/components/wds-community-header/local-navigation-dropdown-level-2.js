import Component from '@ember/component';
import {computed} from '@ember/object';

export default Component.extend({
	tagName: '',
	stickedClassName: computed('model', 'currentIndex', function () {
		return (this.get('model').submenu.length < this.get('currentIndex') + 1) ? 'wds-is-sticked-to-parent' : '';
	})
});
