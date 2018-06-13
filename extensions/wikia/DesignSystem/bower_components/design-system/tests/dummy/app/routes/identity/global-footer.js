import Route from '@ember/routing/route';
import model from '../../models/global-footer';

export default Route.extend({
	model() {
		return model;
	}
});
