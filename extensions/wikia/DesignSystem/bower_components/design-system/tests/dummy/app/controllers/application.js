import Controller from '@ember/controller';

export default Controller.extend({
	// Routes with standalone components set this property
	standalone: false,

	init() {
		this._super(...arguments);

		this.navigation = [
			{
				name: 'Overview',
				id: 'main-navigation-overview',
				expanded: true,
				items: [
					{
						name: 'Getting started',
						location: 'overview.getting-started'
					},
					{
						name: 'Quick start',
						location: 'overview.quick-start'
					},
					{
						name: 'Contributing',
						location: 'overview.contributing'
					},
					{
						name: 'Installation',
						location: 'overview.installation'
					},
					{
						name: 'SVG assets',
						location: 'overview.svg-assets'
					},
					{
						name: 'Ember Addon',
						location: 'overview.ember-addon'
					}
				]
			},
			{
				name: 'Base styles',
				id: 'main-navigation-base-styles',
				expanded: true,
				items: [
					{
						name: 'Breakpoints',
						location: 'base-styles.wds-breakpoints'
					},
					{
						name: 'Grid',
						location: 'base-styles.wds-grid'
					},
					{
						name: 'Colors',
						location: 'base-styles.colors'
					},
					{
						name: 'Typography',
						location: 'base-styles.typography'
					},
					{
						name: 'Z-Index',
						location: 'base-styles.z-index'
					},
				]
			},
			{
				name: 'Components',
				id: 'main-navigation-components',
				expanded: false,
				items: [
					{
						name: 'Assets',
						location: 'route-components.assets'
					},
					{
						name: 'Avatars',
						location: 'route-components.avatars'
					},
					{
						name: 'Buttons',
						location: 'route-components.buttons'
					},
					{
						name: 'Floating Buttons',
						location: 'route-components.floating-buttons'
					},
					{
						name: 'Toggles',
						location: 'route-components.toggles'
					},
					{
						name: 'Dropdowns',
						location: 'route-components.dropdowns'
					},
					{
						name: 'Lists',
						location: 'route-components.lists'
					},
					{
						name: 'Progress indicators',
						location: 'route-components.progress-indicators'
					},
					{
						name: 'Tabs',
						location: 'route-components.tabs'
					},
					{
						name: 'Banner notifications',
						location: 'route-components.banner-notifications'
					}
				]
			},
			{
				name: 'Identity',
				id: 'main-navigation-identity',
				expanded: false,
				items: [
					{
						name: 'Assets',
						location: 'identity.assets'
					},
					{
						name: 'Global Footer',
						location: 'identity.global-footer.index'
					},
					{
						name: 'Global Navigation',
						location: 'identity.global-navigation.index'
					},
					{
						name: 'Community Header',
						location: 'identity.community-header.index'
					},
					{
						name: 'API',
						location: 'identity.api'
					},
				]
			}
		]
	}
});
