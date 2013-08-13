/**
 * Created with JetBrains PhpStorm.
 * User: Rafal Leszczynski
 * Date: 8/9/13
 * Time: 9:03 PM
 * To change this template use File | Settings | File Templates.
 */

require(['wikia.uifactory'], function(uiFactory) {

	uiFactory.init('button').done(function(button) {
		var params = {
				type: 'link',
				vars: {
					href: 'test',
					title: 'test',
					value: 'test',
					classes: ['test']
				}
			},
			html = button.render(params);

		console.log(html);

		params = {
			type: 'xxx',
			vars: {
				href: 'test',
				title: 'test',
				classes: ['test']
			}
		};
		html = button.render(params);
		console.log(html);
	});

	uiFactory.init('xxx').done(function(button) {
		var params = {
				type: 'link',
				vars: {
					href: 'test',
					title: 'test',
					value: 'test',
					classes: ['test']
				}
			},
			html = button.render(params);

		console.log(html);
	});
});
