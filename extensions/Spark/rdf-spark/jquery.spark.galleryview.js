/**
 * Spark query result format "galleryview" # TODO should be easyslider
 * # TODO rewrite
 * == Description ==
 * Displays the result set as an image gallery.
 * 
 * == SPARQL variable names ==
 * None required. Only the first result is taken. It has to be the URI
 * of a picture.
 * 
 * == Parameters ==
 * None as of now.
 *    
 * == Additional required file ==
 * ../lib/easyslider1.7/css/screen.css
 * ../lib/easyslider1.7/js/easySlider1.7.js
 *
 * == Notes ==
 * Just a quick hack on the summer school. Needs to be thoroughly improved.
 */
(function($){
	$.spark.format.galleryview = function(element, result, reduced, params) {
		// Start creating the HTML that will contain the formatting
		var html = '<div id="slider"><ul>'; // TODO rename hardcoded slider id

		$.each(reduced, function(item, values) {
			html += '<li><img src="' + item + '" /></li>';
		});

		html += '</ul></div>';
		// Replace the content of the marked up element with the newly
		// created formatting.
		element.html(html);

		// start slider 
		// TODO rename hardcoded slider id, or do it on the element directly
		$("#slider").easySlider({
			auto: true, 
			continuous: true
		});
	};
})(jQuery);
