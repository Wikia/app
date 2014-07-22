/*
 * Handlebars integration for jQuery
 */
//$.handlebars = Handlebars.compile;

$.fn.handlebars = function(view, context) {
	console.log('handlebars');
	var temp = window.Handlebars.compile(view);
	return temp(context);
};

alert('ok');

//$.fn.handlebars = function(view) {
//	console.log('handlebars');
//	return $.handlebars(view);
//};


