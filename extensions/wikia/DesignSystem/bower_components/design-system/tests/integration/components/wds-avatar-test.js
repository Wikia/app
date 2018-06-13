import {module, test} from 'qunit';
import Service from '@ember/service';
import {setupRenderingTest} from 'ember-qunit';
import {render} from '@ember/test-helpers';
import hbs from 'htmlbars-inline-precompile';

module('Integration | Component | wds-avatar', function (hooks) {
	setupRenderingTest(hooks);

	test('it renders default state', async function (assert) {
		await render(hbs`{{wds-avatar}}`);

		assert.equal(this.element.querySelectorAll('svg.wds-avatar__image').length, 1, 'should render default avatar svg');
	});

	test('it renders provided image', async function (assert) {
		await render(hbs`{{wds-avatar src="/images/FANDOM-Avatar.jpg"}}`);

		assert.equal(this.element.querySelectorAll('img[src="/images/FANDOM-Avatar.jpg"]').length, 1, 'should render provided avatar image');
	});

	test('it renders as link to provided url', async function (assert) {
		await render(hbs`{{wds-avatar link="http://example.com"}}`);

		assert.equal(this.element.querySelectorAll('a[href="http://example.com"]').length, 1, 'should render link');
	});

	test('it renders badge if provided', async function (assert) {
		this.owner.register('service:i18n', Service.extend({
			t() {
				return 'some string';
			}
		}));

		await render(hbs`{{wds-avatar badge="admin"}}`);

		assert.equal(this.element.querySelectorAll('.wds-avatar__badge').length, 1, 'should render badge');
	});
});
