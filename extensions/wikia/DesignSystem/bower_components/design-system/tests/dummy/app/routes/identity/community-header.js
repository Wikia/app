import Route from '@ember/routing/route';
import model from '../../models/community-header';

export default Route.extend({
	model() {
		return model;
	}
});
