// Javascript for Special:Index to hide/show details
// Adapted from the enhanced RC JS

appendCSS('.mw-index-hidden {'+
	'	display:none;'+
	'}'+
	'ul.mw-index-expanded {'+
	'	display:block;'+
	'}'+
	'span.mw-index-expanded {'+
	'	display:inline !important;'+
	'	visibility:visible !important;'+
	'}'+
	'#use-js-note {'+
	'	display: block !important;'+
	'}'	
);

/*
 * Switch details between hidden/shown
*/ 
function toggleVisibility(idNumber) {
	var openarrow = document.getElementById("mw-index-open-"+idNumber);
	var closearrow = document.getElementById("mw-index-close-"+idNumber);
	var inner = document.getElementById("mw-index-inner-"+idNumber);
	if (openarrow.className == 'mw-index-expanded') {
		openarrow.className = 'mw-index-hidden';
		closearrow.className = 'mw-index-expanded';
		inner.className = 'mw-index-expanded';
	} else {
		openarrow.className = 'mw-index-expanded';
		closearrow.className = 'mw-index-hidden';
		inner.className = 'mw-index-hidden';
	}
}
