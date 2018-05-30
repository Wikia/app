$(function() {
	$().log('setting up user preferences', 'RTE');

	var sections = ['editarea-size', 'monobook-layout'];

	$.each(sections, function() {
		var section = $('#mw-htmlform-' + this).parent();
		section.hide();
	});
});

