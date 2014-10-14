/* Variations C, D & E */
$(function(){
	'use strict';

	function moveLocalSearch() {
		var pageHeader = $('#WikiaPageHeader');
		pageHeader.prepend($('#WikiaSearch'));
	}

	moveLocalSearch();
});