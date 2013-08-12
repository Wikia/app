/**
 * Created with JetBrains PhpStorm.
 * User: Rafal Leszczynski
 * Date: 8/9/13
 * Time: 9:03 PM
 * To change this template use File | Settings | File Templates.
 */

require(['wikia.uifactory', 'wikia.uicomponent'], function(uiFactory, uiComponent){

	console.log(uiFactory);
	var test = new uiComponent;
	console.log(test);
	var test2 = uiComponent();
	console.log(test2);

	uiFactory.init('button').done(function(button) {
		var params = {},
			html = button.render(params);

			console.log(html);
	});
});
