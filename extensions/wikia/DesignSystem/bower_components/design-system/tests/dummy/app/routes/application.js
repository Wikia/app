import Route from '@ember/routing/route';
import {inject as service} from '@ember/service';

export default Route.extend({
	i18n: service(),
	queryParams: {
		uselang: {
			replace: true
		}
	},

	afterModel(model, transition) {
		this._super(...arguments);

		this.get('i18n').initialize(transition.queryParams.uselang || 'en');
		this.set('targetName', transition.targetName);
	},

	setupController(controller) {
		this._super(...arguments);

		const targetName = this.get('targetName');

		controller.get('navigation').forEach((collection, index) => {
			collection.items.forEach((object) => {
				if (object.location === targetName) {
					if (index !== 0 && index !== 1) {
						controller.set('navigation.1.expanded', false);
					}

					controller.set(`navigation.${index}.expanded`, true);
				}
			});
		});
	}
});
