define('wikia.dropdownNavigation.templates', [], function () {
	'use strict';
	return {
		dropdown_navigation: '<ul id="{{id}}" class="wikia-dropdown-nav {{posX}} {{poxY}} {{#scrollX}} scroll-x {{/scrollX}}{{#classes}}{{.}}{{/classes}}" {{#maxHeight}}style="max-height: {{maxHeight}};"{{/maxHeight}}><li><a href="#{{id}}" title="{{title}}" rel="nofollow">{{title}}</a>{{#wrapper}}{{#sections}}<li><a href="#{{id}}" title="{{title}}" rel="nofollow">{{title}}</a></li>{{/sections}}{{/wrapper}}</li></ul>',
		done: 'true'
	};
});
