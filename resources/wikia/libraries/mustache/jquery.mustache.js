/*
 * Mustache integration for jQuery
 */
require(['jquery', 'wikia.mustache'], function($, Mustache) {

	$.mustache = function (template, view, partials) {
		return Mustache.render(template, view, partials);
	};

	$.fn.mustache = function (view, partials) {
		var html = $(this).first().html(),
			template = $.trim(html);
		return $.mustache(template, view, partials);
	};

});
