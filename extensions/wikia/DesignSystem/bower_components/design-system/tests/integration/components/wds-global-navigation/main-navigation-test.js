import {module, test} from 'qunit';
import {setupRenderingTest} from 'ember-qunit';
import Service from '@ember/service';
import {render} from '@ember/test-helpers';
import hbs from 'htmlbars-inline-precompile';

const modelStub = {
	"main_navigation": [
		{
			"type": "link-text",
			"title": {
				"type": "translatable-text",
				"key": "global-navigation-fandom-overview-link-vertical-games"
			},
			"href": "//fandom.wikia.com/topics/games",
			"tracking_label": "link.games"
		},
		{
			"type": "link-text",
			"title": {
				"type": "translatable-text",
				"key": "global-navigation-fandom-overview-link-vertical-movies"
			},
			"href": "//fandom.wikia.com/topics/movies",
			"tracking_label": "link.movies"
		},
		{
			"type": "link-text",
			"title": {
				"type": "translatable-text",
				"key": "global-navigation-fandom-overview-link-vertical-tv"
			},
			"href": "//fandom.wikia.com/topics/tv",
			"tracking_label": "link.tv"
		},
		{
			"type": "link-text",
			"title": {
				"type": "translatable-text",
				"key": "global-navigation-fandom-overview-link-video"
			},
			"href": "//fandom.wikia.com/video",
			"tracking_label": "link.video"
		},
		{
			"type": "link-group",
			"title": {
				"type": "translatable-text",
				"key": "global-navigation-wikis-header"
			},
			"tracking_label": "link.wikis",
			"items": [
				{
					"type": "link-text",
					"title": {
						"type": "translatable-text",
						"key": "global-navigation-wikis-explore"
					},
					"href": "//fandom.wikia.com/explore",
					"tracking_label": "link.explore"
				},
				{
					"type": "link-text",
					"title": {
						"type": "translatable-text",
						"key": "global-navigation-wikis-community-central"
					},
					"href": "//community.jakubjt.wikia-dev.pl/wiki/Community_Central",
					"tracking_label": "link.community-central"
				},
				{
					"type": "link-text",
					"title": {
						"type": "translatable-text",
						"key": "global-navigation-wikis-fandom-university"
					},
					"href": "//community.jakubjt.wikia-dev.pl/wiki/Fandom_University",
					"tracking_label": "link.fandom-university"
				},
				{
					"type": "link-button",
					"title": {
						"type": "translatable-text",
						"key": "global-navigation-create-wiki-link-start-wikia"
					},
					"href": "//www.jakubjt.wikia-dev.pl/Special:CreateNewWiki",
					"tracking_label": "link.start-a-wiki"
				}
			]
		}
	]
};

module('Integration | Component | wds-global-navigation/main-navigation', function (hooks) {
	setupRenderingTest(hooks);

	hooks.beforeEach(function () {
		this.set('model', modelStub);
		this.owner.register('service:i18n', Service.extend({
			t() {
				return 'some string';
			}
		}));
	});

	test('it renders', async function (assert) {
		await render(hbs`{{wds-global-navigation/main-navigation model=model.main_navigation}}`);

		assert.equal(this.element.querySelectorAll('.wds-global-navigation__links').length, 1,
			'should render component');
	});

	test('it has 5 links', async function (assert) {
		await render(hbs`{{wds-global-navigation/main-navigation model=model.main_navigation}}`);

		assert.equal(this.element.querySelectorAll('.wds-global-navigation__link').length, 5,
			'should render 5 links');
	});

	test('it should render button in dropdown', async function (assert) {
		await render(hbs`{{wds-global-navigation/main-navigation model=model.main_navigation}}`);

		assert.equal(this.element.querySelectorAll('.wds-global-navigation__link-button').length, 1,
			'should render a button');
	});
});
