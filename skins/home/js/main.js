var search_terms = [ 
	['Spider-Man', 'marvel'],
	['Spore', 'spore'],
	['Grand Theft Auto', 'gta'],
	['Super Smash Bros', 'ssb'],
	['Indiana Jones', 'indianajones'],
	['Nascar Racing', 'thirdturn'],
	['Harry Potter', 'harrypotter'],
	['Star Wars', 'starwars'],
	['Star Trek', 'memoryalpha'],
	['Lost', 'lost'],
	['Muppets', 'muppets'],
	['Jack Bauer', '24'],
	['Simpsons', 'simpsons'],
	['Family Guy', 'familyguy'],
	['South Park', 'southpark'],
	['Wrestling', 'prowrestling'],
	['Transformers', 'transformers'],
	['Godzilla', 'godzilla'],
	['Pixar Movies', 'pixar'],
];
var search_term_index = '';

function doSubmit() {
	alert('submitted');
}

function get_search_term() {
	if (!search_term_index) {
		search_term_index = Math.floor(search_terms.length * Math.random());
	} else if (search_term_index == search_terms.length - 1) {
		search_term_index = 0;
	} else {
		search_term_index++;
	}
	//alert(search_term_index + ', ' + search_terms.length);
	search_query = search_terms[search_term_index][0];
	search_site = search_terms[search_term_index][1];
}

function change_search_value() {
	get_search_term();
	searchField.value = search_query;
}

function perform_search() {
	for (i=0; i<search_terms.length; i++) {
		if (searchField.value == search_terms[i][0]) {
			document.location = 'http://' + search_terms[i][1] + '.wikia.com';
			exit;
		}
	}
	document.location = 'http://www.wikia.com/wiki/Special:Search?search=' + searchField.value;
}

function search_field_focus() {
	clearInterval(search_timer);
	searchField.value = '';
}
function search_field_blur() {
	if (searchField.value == '') {
		change_search_value();
		search_timer = setInterval(change_search_value, 5000);S
	}
}

YAHOO.util.Event.onDOMReady(function() {
	YAHOO.util.Event.addListener('search_button', "click", perform_search); 
	YAHOO.util.Event.addListener('search_field', "focus", search_field_focus); 
	YAHOO.util.Event.addListener('search_field', "blur", search_field_blur); 
	searchField = YAHOO.util.Dom.get('search_field');
	change_search_value();
	search_timer = setInterval(change_search_value, 5000);
});

function wikia_search() {
	document.location = 'http://re.search.wikia.com/search.html#' + YAHOO.util.Dom.get('wikia_search_field').value;
}
