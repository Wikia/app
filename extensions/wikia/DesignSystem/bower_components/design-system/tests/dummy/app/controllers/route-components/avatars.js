import Controller from '@ember/controller';
import ENV from '../../config/environment';

export default Controller.extend({
	rootURL: ENV.rootURL,
	avatars: null,

	init() {
		this._super(...arguments);

		this.set('avatars', [
			{
				src: `${ENV.rootURL}images/FANDOM-Avatar.jpg`,
				alt: 'user name',
				link: 'http://fandom.wikia.com',
			},
			{
				src: null,
				alt: 'user name'
			},
			{
				src: `${ENV.rootURL}images/FANDOM-Avatar.jpg`,
				alt: 'user name',
				link: 'http://fandom.wikia.com'
			},
			{
				src: `${ENV.rootURL}images/FANDOM-Avatar.jpg`,
				alt: 'user name',
				badge: 'admin',
			},
			{
				src: null,
				alt: 'user name'
			},
			{
				src: `${ENV.rootURL}images/FANDOM-Avatar.jpg`,
				alt: 'user name'
			},
			{
				src: `${ENV.rootURL}images/FANDOM-Avatar.jpg`,
				alt: 'user name'
			},
			{
				src: `${ENV.rootURL}images/FANDOM-Avatar.jpg`,
				alt: 'user name'
			},
			{
				src: `${ENV.rootURL}images/FANDOM-Avatar.jpg`,
				alt: 'user name'
			},
		]);
	},
});
