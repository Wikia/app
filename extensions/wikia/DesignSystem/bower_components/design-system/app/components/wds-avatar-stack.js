import Component from '@ember/component';
import {computed} from '@ember/object';

export default Component.extend({
	classNames: ['wds-avatar-stack'],
	maxStackSize: 5,
	avatars: null,

	overflow: computed('avatars', function() {
		const count = this.get('avatars').length || 0;
		const maxStackSize = this.get('maxStackSize');

		return count > maxStackSize ? count - maxStackSize : 0;
	}),
	displayableAvatars: computed('avatars', 'maxStackSize', function() {
		const avatars = this.get('avatars') || [];
		const count = avatars.length;
		const maxStackSize = this.get('maxStackSize');

		return count > maxStackSize ? avatars.slice(0, maxStackSize) : avatars;
	}),
});
