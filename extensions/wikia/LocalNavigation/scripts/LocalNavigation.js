(function(window) {
	'use strict';

	var entryPoint = window.document.getElementById('contribute-container'),
		dropdown = window.document.getElementById('contribute-dropdown');

	entryPoint.addEventListener('mouseover', function() {
		dropdown.classList.add('active');
	});

	entryPoint.addEventListener('mouseout', function() {
		dropdown.classList.remove('active');
	});
})(window);
