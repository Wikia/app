import Route from '@ember/routing/route';
import model from '../../../models/global-navigation';

export default Route.extend({
	model(params) {
		return model[params['variant_name']];
	},

	setupController() {
		this._super(...arguments);
		this.controllerFor('application').set('standalone', true);
		this.controllerFor('identity.global-navigation').set('standalone', true);
	}
});
