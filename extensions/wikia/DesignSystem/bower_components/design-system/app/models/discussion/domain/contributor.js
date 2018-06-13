import EmberObject from '@ember/object';
import {inject as service} from '@ember/service';

export default EmberObject.extend({
	wikiUrls: service(),
	wikiVariables: service(),

	avatarUrl: null,
	badgePermission: null,
	id: null,
	name: null,
	profileUrl: null,

	init() {
		this._super(...arguments);
		this.set('profileUrl', this.get('wikiUrls').build({
			host: this.get('wikiVariables.host'),
			namespace: 'User',
			title: this.get('name')
		}));
	}
});
