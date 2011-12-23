var WMWideTables = WMWideTables || (function() {
	var modal = $('#modalContent'),
	table = modal.find('table')
	firstRow = table.find('tbody tr:first-of-type'),
	firstColumn = $('td:first-of-type');

	function handleTableScrolling() {
		window.onscroll = function() {
			firstRow.css('top', window.pageYOffset + 'px');
			console.log('X: ' + window.pageXOffset);
			console.log('Y: ' + window.pageYOffset);
		};
	}

	return {
		handleTableScrolling: handleTableScrolling
	}
})()