import {module, test} from 'qunit';
import {setupRenderingTest} from 'ember-qunit';
import {render} from '@ember/test-helpers';
import hbs from 'htmlbars-inline-precompile';

module('Integration | Component | wds-avatar-stack', function (hooks) {
	setupRenderingTest(hooks);

	test('it renders', async function (assert) {
		this.set('avatars3', new Array(3).fill({src: '/images/FANDOM-Avatar.jpg', alt: 'user name'}));
		await render(hbs`{{wds-avatar-stack avatars=avatars3}}`);

		assert.equal(this.element.querySelectorAll('.wds-avatar').length, 3, 'should render 3 avatars');
		assert.equal(this.element.querySelectorAll('.wds-avatar-stack__overflow').length, 0, 'should render only 3 avatars');

		this.set('avatars5', new Array(5).fill({src: '/images/FANDOM-Avatar.jpg', alt: 'user name'}));
		await render(hbs`{{wds-avatar-stack avatars=avatars5}}`);

		assert.equal(this.element.querySelectorAll('.wds-avatar').length, 5, 'should render 5 avatars');
		assert.equal(this.element.querySelectorAll('.wds-avatar-stack__overflow').length, 0, 'should render only 5 avatars');

		this.set('avatars9', new Array(9).fill({src: '/images/FANDOM-Avatar.jpg', alt: 'user name'}));
		await render(hbs`{{wds-avatar-stack avatars=avatars9}}`);

		assert.equal(this.element.querySelectorAll('.wds-avatar').length, 5, 'should render 5 avatars with overflow');
		assert.equal(this.element.querySelectorAll('.wds-avatar-stack__overflow').length, 1, 'should render overflow');
		assert.equal(this.element.querySelector('.wds-avatar-stack__overflow').textContent.trim(), '+4', 'wrong value of overflow');
	});
});
