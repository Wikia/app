(function(window) {
	'use strict';

	var entryPoint = window.document.getElementById('contributeEntryPoint'),
		dropdown = window.document.getElementById('contributeDropdown');

	entryPoint.addEventListener('mouseover', function() {
		dropdown.classList.add('active');
	});

	entryPoint.addEventListener('mouseout', function() {
		dropdown.classList.remove('active');
	});
})(window);
