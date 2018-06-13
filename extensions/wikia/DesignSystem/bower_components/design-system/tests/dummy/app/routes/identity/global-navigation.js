import Route from '@ember/routing/route';
import model from '../../models/global-navigation';

export default Route.extend({
	model() {
		return model;
	}
});
