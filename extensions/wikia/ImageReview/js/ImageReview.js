$(function() {
	// cycle through radio fields on each image click
	var images = $('#ImageReviewForm div.img-container');
	images.bind('click', function(ev) {
		var img = $(this),
			cell = img.closest('td'),
			fields = cell.find('input'),
			selectedField = fields.filter(':checked'),
			selectedIndex = Math.max(0, fields.index(selectedField));

		// select the next radio
		var stateId = (selectedIndex + 1) % fields.length;

		fields.eq(stateId).click();
		cell.attr('class', 'state-' + fields.eq(stateId).val());
	});

	// do the same for checkboxes
	var checkboxes = $('#ImageReviewForm input');
	checkboxes.bind('click', function(ev) {
		var checkbox = $(this),
			cell = checkbox.closest('td');

		var stateId = checkbox.val();

		cell.attr('class', 'state-' + stateId);
	});
});