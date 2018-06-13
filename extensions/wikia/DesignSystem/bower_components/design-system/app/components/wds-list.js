import Component from '@ember/component';

export default Component.extend({
	tagName: 'ul',
	classNames: 'wds-list',
	classNameBindings: [
		'big:wds-has-big-items',
		'bold:wds-has-bolded-items',
		'lines:wds-has-lines-between',
		'linked:wds-is-linked',
		'ellipsis:wds-has-ellipsis'
	],
});
