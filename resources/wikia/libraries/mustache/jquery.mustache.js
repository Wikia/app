/*
 * Mustache integration for jQuery
 */
require(['jquery', 'wikia.mustache'], function($, Mustache) {

	$.mustache =  Mustache.render;

	$.fn.mustache = function (view, partials) {
		var html = $(this).first().html(),
			template = $.trim(html);
		return $.mustache(template, view, partials);
	};
});
